import { Button, Container } from '@mui/material'
import { setUser } from '../../lib/user'

const AuthDummy = () => {
  const handleLoginAdmin = () => {
    setUser("xi", "xi", "artist")
  }

  const handleLoginArtist = () => {
    setUser("vito g", "vito", "admin")
  }

  const handleLogout = () => {
    localStorage.removeItem('name')
    localStorage.removeItem('role')
    localStorage.removeItem('username')
  }

  return (
    <Container sx={{ padding: '20px' }}>
      <Button onClick={handleLoginAdmin}>Login as Admin</Button>
      <Button onClick={handleLoginArtist}>Login as Artist</Button>
      <Button onClick={handleLogout}>Logout</Button>
    </Container>
  )
}

export default AuthDummy
