import { Box, Container, Typography } from '@mui/material'

const NotFound = () => {
  return (
    <Container
      sx={{ width: '100vw', height: '100vh', display: 'flex', alignItems: 'center', justifyContent: 'center' }}
    >
      <Container>
        <Typography variant="h1" textAlign={'center'}>
          404 Not Found
        </Typography>
        <Typography variant="h4" textAlign={'center'}>
          Binotify Premium App
        </Typography>
      </Container>
    </Container>
  )
}

export default NotFound
