import { Button, Typography, Paper, Grid } from '@mui/material'
import { useNavigate } from 'react-router-dom'
import Navbar from '../../components/Navbar'
import useTitle from '../../hooks/useTitle'
import SongTable from './SongTable'

const ManageSong = () => {
  useTitle('Manage Song')
  const navigate = useNavigate()

  return (
    <>
      <Navbar />
      <Grid container className="with-bg" sx={{ minHeight: '100vh', justifyContent: 'center', alignItems: 'center' }}>
        <Paper
          sx={{
            margin: 2,
            padding: 4,
            display: 'flex',
            alignItems: 'center',
            flexDirection: 'column',
            maxWidth: '700px',
            marginTop: 12,
          }}
        >
          <Typography variant="h3" textAlign="center">
            Manage Your Song
          </Typography>
          <Typography variant="h6" textAlign="center">
            Binotify Premium App
          </Typography>
          <Button variant="outlined" sx={{ float: 'right', marginTop: 2 }} onClick={() => navigate('/create')}>
            Insert New Song
          </Button>
          <SongTable sx={{ marginTop: 4 }} />
        </Paper>
      </Grid>
    </>
  )
}

export default ManageSong
