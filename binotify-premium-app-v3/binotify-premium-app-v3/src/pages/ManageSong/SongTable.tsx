import { useState, useEffect } from 'react'
import {
  Paper,
  TableContainer,
  Table,
  TableHead,
  TableRow,
  TableCell,
  TableBody,
  TablePagination,
  Tooltip,
  IconButton,
  CircularProgress,
} from '@mui/material'
import EditIcon from '@mui/icons-material/Edit'
import DeleteIcon from '@mui/icons-material/Delete'
import { useNavigate } from 'react-router-dom'
import { getToken } from '../../lib/user'
import CustomDialog from '../../components/CustomDialog'
import { fetchApi } from '../../lib/fetchApi'

type RowProps = {
  index: number
  songId: number
  title: string
  onEdit: Function
  onDelete: Function
}

// const createData = (id: number, title: string) => ({ id, title })

const Row = ({ index, title, onEdit, onDelete, songId }: RowProps) => {
  return (
    <TableRow hover>
      <TableCell align="center">{index}</TableCell>
      <TableCell align="center">{title}</TableCell>
      <TableCell align="center">
        <Tooltip title="Edit song">
          <IconButton
            onClick={() => {
              onEdit(songId)
            }}
          >
            <EditIcon />
          </IconButton>
        </Tooltip>
        <Tooltip title="Delete song">
          <IconButton
            onClick={() => {
              onDelete(songId, title)
            }}
          >
            <DeleteIcon />
          </IconButton>
        </Tooltip>
      </TableCell>
    </TableRow>
  )
}

const SongTable = ({ ...props }) => {
  const rowsPerPage = 10
  const [page, setPage] = useState(0)
  const navigate = useNavigate()
  const [songData, setSongData] = useState({ data: [], isLoading: true })
  const [dialog, setDialog] = useState({
    id: 0,
    songId: 0,
    isOpen: false,
    title: 'Delete this item?',
    description: 'Are you sure you want to delete this item?',
  })

  const handleChangePage = (event: React.MouseEvent<HTMLButtonElement> | null, newPage: number) => {
    setPage(newPage)
  }

  const onEdit = (id: number) => {
    navigate(`/edit/${id}`)
  }

  const onDelete = (songId: number, title: string) => {
    setDialog({
      ...dialog,
      songId: songId,
      isOpen: true,
      title: `Delete ${title}?`,
      description: `Are you sure you want to delete ${title}?`,
    })
  }

  const onDeleteConfirm = async () => {
    try {
      const url = import.meta.env.VITE_SERVER_URL + '/manage-songs/' + dialog.songId.toString()
      const headers = {
        Authorization: 'Bearer ' + getToken() || '',
      }
      const res = await fetchApi(url, 'DELETE', headers)
      const data = await res.json()

      if (data.status === "success") {
        alert('Song successfully deleted!')
        navigate(0)
      }
    } catch (error) {
      alert('Error on deleting!')
    }

    setDialog({
      ...dialog,
      isOpen: false,
    })
  }

  const fetchData = async () => {
    try {
      const url = import.meta.env.VITE_SERVER_URL + '/manage-songs'
      const headers = {
        Authorization: 'Bearer ' + getToken() || '',
      }
      const res = await fetchApi(url, 'GET', headers)
      const data = await res.json()

      const dataIndexed = data.map((item: any, index: number) => ({ index: index + 1, ...item }))

      setSongData({ data: dataIndexed, isLoading: false })
    } catch (error) {
      alert('fetching failed')
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  if (songData.isLoading) {
    return <CircularProgress sx={{ marginTop: 4 }} />
  }

  return (
    <Paper {...props}>
      <CustomDialog
        title={dialog.title}
        description={dialog.description}
        onSubmit={onDeleteConfirm}
        isOpen={dialog.isOpen}
        setOpen={(open: boolean) => {
          setDialog({ ...dialog, isOpen: open })
        }}
      />
      <Paper sx={{ width: '100%', display: 'table', tableLayout: 'fixed', maxWidth: '600px', marginTop: 2 }}>
        <TableContainer>
          <Table size="small">
            <TableHead>
              <TableRow>
                <TableCell align="center">No.</TableCell>
                <TableCell align="center">Song Name</TableCell>
                <TableCell align="center">Action</TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {songData.data.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((row) => (
                <Row
                  key={row['index']}
                  index={row['index']}
                  songId={row['song_id']}
                  title={row['judul']}
                  onEdit={onEdit}
                  onDelete={onDelete}
                />
              ))}
            </TableBody>
          </Table>
        </TableContainer>
        <TablePagination
          count={songData.data.length}
          rowsPerPageOptions={[rowsPerPage]}
          rowsPerPage={rowsPerPage}
          onPageChange={handleChangePage}
          page={page}
          component="div"
        />
      </Paper>
    </Paper>
  )
}

export default SongTable
