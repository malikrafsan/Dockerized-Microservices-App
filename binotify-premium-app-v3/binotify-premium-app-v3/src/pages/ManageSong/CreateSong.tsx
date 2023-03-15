import {
  Box,
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
import { useRef, FormEvent, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import Navbar from '../../components/Navbar'
import uploadFile from '../../lib/uploadFile'
import { getName, getToken } from '../../lib/user'

interface DataProps {
  title: string
  file: Blob
}

const CreateSong = () => {
  const [loading, setLoading] = useState(false)
  const navigate = useNavigate()

  const [data, setData] = useState<DataProps>({
    title: '',
    file: new Blob(),
  })

  const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    setLoading(true)
    
    const audio_path = await uploadFile(data.file)

    const url = import.meta.env.VITE_SERVER_URL + '/manage-songs'
    const headers = {
      Authorization: 'Bearer ' + getToken() || '',
      'Content-Type': 'application/json',
    }

    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify({
          judul: data.title,
          audio_path: audio_path.data,
        }),
      })
      const resp = await res.json()

      setLoading(false)
      if (resp.status === "success") {
        alert("Success inserting file to database!");
        navigate("/manage-song");
      }
    } catch (error) {
      alert('Error on creating song!')
    }
  }
  return (
    <>
      <Navbar />
      <Backdrop open={loading} sx={{ color: '#fff', zIndex: (theme) => theme.zIndex.modal + 1 }}>
        <CircularProgress size={48} />
      </Backdrop>
      <Grid
        container
        className="with-bg"
        sx={{ width: '100vw', minHeight: '100vh', justifyContent: 'center', alignItems: 'center' }}
      >
        <Paper sx={{ maxWidth: 500, padding: 4 }}>
          <Typography variant="h4" sx={{ textAlign: 'center' }}>
            Create Song
          </Typography>
          <Box component="form" onSubmit={handleSubmit}>
            <TableContainer sx={{ marginTop: 2 }}>
              <Table>
                <TableBody>
                  <TableRow>
                    <TableCell>
                      <Typography>Artist</Typography>
                    </TableCell>
                    <TableCell>
                      <Input disabled={true} defaultValue={getName()} fullWidth />
                    </TableCell>
                  </TableRow>
                  <TableRow>
                    <TableCell>
                      <Typography>Title</Typography>
                    </TableCell>
                    <TableCell>
                      <Input
                        fullWidth
                        required
                        onChange={(e) => {
                          setData({ ...data, title: e.target.value })
                        }}
                      />
                    </TableCell>
                  </TableRow>
                  <TableRow>
                    <TableCell>
                      <Typography>File</Typography>
                    </TableCell>
                    <TableCell>
                      <Input
                        type="file"
                        required
                        onChange={(e) => {
                          setData({ ...data, file: (e.target as any).files[0] })
                        }}
                        inputProps={{ accept: 'audio/*' }}
                      />
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </TableContainer>
            <Button variant="contained" sx={{ float: 'right', marginTop: 4 }} type="submit">
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
          </Box>
        </Paper>
      </Grid>
    </>
  )
}

export default CreateSong
