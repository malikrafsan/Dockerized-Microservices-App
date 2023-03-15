import { Box, CircularProgress } from '@mui/material'

const FullPageLoader = () => {
  return (
    <Box
      className="with-bg"
      sx={{ minHeight: '100vh', display: 'flex', justifyContent: 'center', alignItems: 'center' }}
    >
      <CircularProgress size={64} />
    </Box>
  )
}

export default FullPageLoader
