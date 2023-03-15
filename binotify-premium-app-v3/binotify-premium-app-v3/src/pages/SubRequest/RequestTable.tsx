import {
  Paper,
  Table,
  Tooltip,
  TableContainer,
  TableHead,
  TableBody,
  TableCell,
  TableRow,
  IconButton,
  TablePagination,
  Backdrop,
  CircularProgress,
  Typography,
} from '@mui/material'
import DeleteOutlineIcon from '@mui/icons-material/DeleteOutline'
import CheckIcon from '@mui/icons-material/Check'
import { useState, useEffect } from 'react'
import CustomDialog from '../../components/CustomDialog'
import { getToken } from '../../lib/user'
import { fetchApi } from '../../lib/fetchApi'
import { useNavigate } from 'react-router-dom'

type RowProps = {
  reqId: number
  artist: string
  subscriberId: number
  creatorId: number
  onAccept: Function
  onDecline: Function
}

const createData = (id: number, username: string) => ({ id, username })

const Row = ({ reqId, artist, subscriberId, creatorId, onAccept, onDecline }: RowProps) => {
  return (
    <TableRow>
      <TableCell align="center">{reqId}</TableCell>
      <TableCell>{subscriberId}</TableCell>
      <TableCell>{artist}</TableCell>
      <TableCell align="center">
        <Tooltip title="Decline request">
          <IconButton
            onClick={() => {
              onDecline(creatorId, subscriberId)
            }}
          >
            <DeleteOutlineIcon />
          </IconButton>
        </Tooltip>
        <Tooltip title="Accept request">
          <IconButton
            onClick={() => {
              onAccept(creatorId, subscriberId)
            }}
          >
            <CheckIcon />
          </IconButton>
        </Tooltip>
      </TableCell>
    </TableRow>
  )
}

const RequestTable = () => {
  const [page, setPage] = useState(0)
  const [reqData, setReqData] = useState([])
  const [dialog, setDialog] = useState({
    id: 0,
    username: '-',
    title: 'title',
    description: 'description',
    isOpen: false,
    isDecline: true,
    creatorId: 0,
    subscriberId: 0,
  })
  const [loadingSubmit, setLoadingSubmit] = useState(false)
  const rowsPerPage = 10
  const navigate = useNavigate()

  const fetchData = async () => {
    try {
      const url = import.meta.env.VITE_SERVER_URL
      const res = await fetch(`${url}/subscription`, {
        headers: {
          Authorization: 'Bearer ' + getToken(),
        },
      })
      const data = await res.json()

      setReqData(data.map((item: any, index: number) => ({ ...item, id: index + 1 })))
    } catch (error) {
      alert('Could not fetch subscription data')
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  const handleChangePage = (event: React.MouseEvent<HTMLButtonElement> | null, newPage: number) => {
    setPage(newPage)
  }

  const onAccept = (creatorId: number, subscriberId: number) => {
    setDialog({
      ...dialog,
      title: 'Accept this user?',
      description: "Are you sure you want to accept this user's subscription request?",
      isOpen: true,
      isDecline: false,
      creatorId: creatorId,
      subscriberId: subscriberId,
    })
  }

  const onDecline = (creatorId: number, subscriberId: number) => {
    setDialog({
      ...dialog,
      title: 'Decline this user?',
      description: "Are you sure you want to decline this user's subscription request?",
      isOpen: true,
      isDecline: true,
      creatorId: creatorId,
      subscriberId: subscriberId,
    })
  }

  const onSubmit = async () => {
    setLoadingSubmit(true)
    let url = import.meta.env.VITE_SERVER_URL + '/subscription'
    if (dialog.isDecline) {
      url += '/reject'
    } else {
      url += '/accept'
    }

    try {
      const headers = {
        'Content-Type': 'application/json',
        Authorization: 'Bearer ' + getToken() || '',
      }
      const body = {
        creator_id: dialog.creatorId,
        subscriber_id: dialog.subscriberId,
      }
      const res = await fetchApi(url, 'PUT', headers, body)
      const data = await res.json()

      if (dialog.isDecline && data.status === 'REJECTED') {
        alert('Request rejected!')
      } else if (!dialog.isDecline && data.status === 'ACCEPTED') {
        alert('Request accepted!')
      } else {
        alert('Failed to accept or reject!')
      }

      navigate(0)
    } catch (error) {
      alert('Server Error!')
    }

    setDialog({ ...dialog, isOpen: false })
    setLoadingSubmit(false)
  }

  if (reqData.length === 0) {
    return (
      <Typography variant="h5" sx={{ marginTop: 2 }}>
        You currently have no subscription requests
      </Typography>
    )
  }

  return (
    <Paper sx={{ width: '100%', display: 'table', tableLayout: 'fixed', maxWidth: '600px', marginTop: 2 }}>
      <Backdrop open={loadingSubmit} sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.modal + 1 }}>
        <CircularProgress size={48} />
      </Backdrop>
      <CustomDialog
        title={dialog.title}
        description={dialog.description}
        onSubmit={onSubmit}
        isOpen={dialog.isOpen}
        setOpen={(open: boolean) => {
          setDialog({ ...dialog, isOpen: open })
        }}
      />
      <TableContainer>
        <Table size="small">
          <TableHead>
            <TableRow>
              <TableCell align="center" width="10%">
                No.
              </TableCell>
              <TableCell align="left" width="10%">
                User ID
              </TableCell>
              <TableCell align="left" width="50%">
                Artist
              </TableCell>
              <TableCell align="center" width="30%">
                Action
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {reqData.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((row, i) => (
              <Row
                key={i}
                reqId={row['id']}
                artist={row['creatorName'] || '-'}
                subscriberId={row['subscriberId']}
                creatorId={row['creatorId']}
                onAccept={onAccept}
                onDecline={onDecline}
              />
            ))}
          </TableBody>
        </Table>
      </TableContainer>
      <TablePagination
        count={reqData.length}
        rowsPerPageOptions={[rowsPerPage]}
        rowsPerPage={rowsPerPage}
        onPageChange={handleChangePage}
        page={page}
        component="div"
      />
    </Paper>
  )
}

export default RequestTable
