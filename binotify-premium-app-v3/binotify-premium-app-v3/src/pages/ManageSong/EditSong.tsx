import {
  Typography,
  Grid,
  Paper,
  TableContainer,
  Table,
  TableBody,
  TableCell,
  TableRow,
  Input,
  Button,
  Backdrop,
  CircularProgress
} from '@mui/material'
import { useLoaderData, useNavigate, useParams } from 'react-router-dom'
import { useState, useEffect, ChangeEvent } from 'react'
import Navbar from '../../components/Navbar'
import { getName, getToken } from '../../lib/user'
import { fetchApi } from '../../lib/fetchApi'
import uploadFile from '../../lib/uploadFile'

class songType {
  id: number = 0
  artist: string = ''
  title: string = ''
}

const EditSong = () => {
  const navigate = useNavigate()
  const { id } = useParams()
  const [songData, setSongData] = useState({
    id: 0,
    artist: '-',
    title: '-',
    filePath: '-',
  })
  const [fileData, setFileData] = useState({
    file: new Blob(),
    editted: false,
  })
  const [loading, setLoading] = useState(false)

  const fetchData = async () => {
    if (typeof id === 'undefined') {
      navigate('/manage-song')
      return
    }

    try {
      const url = import.meta.env.VITE_SERVER_URL + '/manage-songs/' + id
      const headers = {
        Authorization: 'Bearer ' + getToken() || '',
      }
      const res = await fetchApi(url, 'GET', headers)
      const data = await res.json()

      if (data) {
        setSongData({
          ...songData,
          artist: getName() || '-',
          id: Number(id),
          title: data.data.judul,
          filePath: data.data.audio_path,
        })
      } else {
        navigate('/manage-song')
      }
    } catch (error) {
      alert('fetching failed')
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  const handleChange = (e: ChangeEvent<HTMLInputElement>) => {
    setSongData({
      ...songData,
      title: e.target.value,
    })
  }

  const onSubmit = async () => {
    setLoading(true)
    let audio_path
    if (fileData.editted) {
      audio_path = await uploadFile(fileData.file)
    } else {
      audio_path = songData.filePath
    }

    try {
      const url = import.meta.env.VITE_SERVER_URL + '/manage-songs/' + id
      const headers = {
        Authorization: 'Bearer ' + getToken() || '',
        'Content-Type': 'application/json',
      }
      const body = {
        judul: songData.title,
        audio_path: audio_path.data,
      }
      const res = await fetchApi(url, 'PATCH', headers, body)
      const data = await res.json()

      setLoading(false)
      if (data.status === 'success') {
        alert('Song edited successfully!')
        navigate("/manage-song")
      } else {
        alert(`Song failed to update: ${data.message}`)
      }
    } catch (error) {
      alert('Server error!')
    }
  }

  return (
    <>
      <Navbar />
      <Backdrop open={loading} sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.modal + 1 }}>
        <CircularProgress size={48} />
      </Backdrop>
      <Grid container className="with-bg" sx={{ minHeight: '100vh', justifyContent: 'center', alignItems: 'center' }}>
        <Paper sx={{ maxWidth: 500, padding: 4 }}>
          <Typography variant="h4" sx={{ textAlign: 'center' }}>
            Edit Song
          </Typography>
          <TableContainer sx={{ marginTop: 2 }}>
            <Table>
              <TableBody>
                <TableRow>
                  <TableCell>
                    <Typography>Artist</Typography>
                  </TableCell>
                  <TableCell>
                    <Input disabled={true} value={songData.artist} fullWidth />
                  </TableCell>
                </TableRow>
                <TableRow>
                  <TableCell>
                    <Typography>Title</Typography>
                  </TableCell>
                  <TableCell>
                    <Input value={songData.title} onChange={handleChange} fullWidth />
                  </TableCell>
                </TableRow>
                <TableRow>
                  <TableCell>
                    <Typography>File</Typography>
                  </TableCell>
                  <TableCell>
                    <Input
                      type="file"
                      inputProps={{ accept: 'audio/*' }}
                      onChange={(e) => {
                        setFileData({ file: (e.target as any).files[0], editted: true })
                      }}
                    />
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </TableContainer>
          <Button variant="contained" sx={{ float: 'right', marginTop: 4 }} type="submit" onClick={onSubmit}>
            Submit
          </Button>
          <Button
            variant="outlined"
            sx={{ float: 'right', marginRight: 2, marginTop: 4 }}
            onClick={() => {
              navigate('/manage-song')
            }}
          >
            Cancel
          </Button>
        </Paper>
      </Grid>
    </>
  )
}

export default EditSong
