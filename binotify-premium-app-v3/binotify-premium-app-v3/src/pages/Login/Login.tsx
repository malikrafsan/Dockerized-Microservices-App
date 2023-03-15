import { useRef, FormEvent } from 'react'
import { Box, Button, Paper, Typography, TextField, Grid, Link } from '@mui/material'
import useTitle from '../../hooks/useTitle'
import '../../assets/bg.css'
import { setToken } from '../../lib/user'
import { useNavigate, Navigate } from 'react-router-dom'
import { fetchApi } from '../../lib/fetchApi'

const SignIn = () => {
  useTitle('Login')
  const usernameRef = useRef<HTMLInputElement>(null)
  const passwordRef = useRef<HTMLInputElement>(null)
  const navigate = useNavigate()


  const handleSubmit = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    if (usernameRef.current === null || passwordRef.current === null) {
      alert('Please fill in all fields!')
      return
    }

    const username = usernameRef.current.value
    const password = passwordRef.current.value

    const url = import.meta.env.VITE_SERVER_URL + '/login'

    try {
      const headers = {
        'Content-Type': 'application/json',
      }
      const body = {
        username,
        password,
      }
      const res = await fetchApi(url, 'POST', headers, body)

      const data = await res.json()

      if (data.token) {
        setToken(data.token)
        navigate('/')
      } else {
        alert(data.message)
      }


    } catch (error) {
      alert('Server error!')
    }
  }

  return (
    <Grid
      container
      direction="column"
      sx={{ height: '100vh', justifyContent: 'center', alignItems: 'center' }}
      className="with-bg"
    >
      <Paper
        sx={{
          padding: '25px',
          maxWidth: '500px',
          display: 'flex',
          alignItems: 'center',
          flexDirection: 'column',
          margin: 2,
        }}
        variant="elevation"
      >
        <Typography variant="h3">Sign In</Typography>
        <Typography variant="h6">for Binotify Premium App</Typography>
        <Typography variant="subtitle2" marginTop={2}>
          Don't have an account? <Link href="/register">Sign Up</Link> instead.
        </Typography>
        <Box
          component="form"
          sx={{ width: '80%' }}
          onSubmit={(e) => {
            handleSubmit(e)
          }}
        >
          <TextField
            required
            margin="normal"
            fullWidth
            id="email"
            label="Username or email"
            name="email"
            inputRef={usernameRef}
          />
          <TextField
            required
            margin="normal"
            fullWidth
            id="password"
            label="Password"
            name="password"
            type="password"
            inputRef={passwordRef}
          />
          <Button variant="contained" sx={{ marginTop: '20px', float: 'right', minWidth: '120px' }} type="submit">
            Submit
          </Button>
        </Box>
      </Paper>
    </Grid>
  )
}

export default SignIn
