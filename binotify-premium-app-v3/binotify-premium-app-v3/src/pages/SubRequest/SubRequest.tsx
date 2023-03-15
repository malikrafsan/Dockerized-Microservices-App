import { Box, Typography, Paper, Grid } from '@mui/material'
import useTitle from '../../hooks/useTitle'
import RequestTable from './RequestTable'
import Navbar from '../../components/Navbar'
import '../../assets/bg.css'

const SubRequest = () => {
  useTitle('Subscription Request')

  return (
    <>
      <Navbar />
      <Grid
        container
        className="with-bg"
        sx={{ minHeight: '100vh', justifyContent: 'center', alignItems: 'center' }}
      >
        <Paper
          sx={{
            margin: 2,
            marginTop: 16,
            padding: 4,
            display: 'flex',
            alignItems: 'center',
            flexDirection: 'column',
            maxWidth: '700px',
          }}
        >
          <Typography variant="h3" textAlign="center">
            Subscription Request
          </Typography>
          <Typography variant="h6" textAlign="center">
            for Binotify Premium App
          </Typography>
          <RequestTable />
        </Paper>
      </Grid>
    </>
  )
}

export default SubRequest
