import { Box, Button, Paper, Typography, TextField, Grid, Link } from '@mui/material'
import useTitle from '../../hooks/useTitle'
import '../../assets/bg.css'
import { getUser } from '../../lib/user'
import { useNavigate, Navigate } from 'react-router-dom'
import { useRef, useState, FormEvent, ChangeEvent } from 'react'

const Register = () => {
  useTitle('Register')
  const { isAuthenticated } = getUser()
  const navigate = useNavigate()

  const nameRef = useRef<HTMLInputElement>(null)
  const usernameRef = useRef<HTMLInputElement>(null)
  const passwordRef = useRef<HTMLInputElement>(null)
  const emailRef = useRef<HTMLInputElement>(null)
  const confirmPasswordRef = useRef<HTMLInputElement>(null)
  const [error, setError] = useState({
    usernameError: false,
    emailError: false,
  })

  if (isAuthenticated) {
    return <Navigate to="/" />
  }

  const onUsernameChange = (e: ChangeEvent<HTMLInputElement>) => {
    const usernamePattern = /^[a-zA-Z0-9_]+$/

    const truth = usernamePattern.test(e.target.value)
    console.log(truth, e.target.value)

    if (truth) {
      setError({ ...error, usernameError: false })
    } else {
      setError({ ...error, usernameError: true })
    }
  }

  const onEmailChange = (e: ChangeEvent<HTMLInputElement>) => {
    const emailPattern = /^[\w]+@[\w]+(.[\w]+){0,}\.[\w]+$/
    const truth = emailPattern.test(e.target.value)

    if (truth) {
      setError({ ...error, emailError: false })
    } else {
      setError({ ...error, emailError: true })
    }
    console.log(truth, e.target.value)
  }

  const onSubmit = async () => {
    const name = nameRef.current?.value
    const username = usernameRef.current?.value
    const email = emailRef.current?.value
    const password = passwordRef.current?.value
    const confirmPassword = confirmPasswordRef.current?.value

    if (!name || !username || !password || !email || !confirmPassword) {
      alert('Please fill in all fields!')
      return
    }

    if (password !== confirmPassword) {
      alert('Passwords do not match!')
      return
    }

    const url = import.meta.env.VITE_SERVER_URL
    try {
      const res = await fetch(`${url}/register`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          name,
          username,
          email,
          password,
        }),
      })

      const data = await res.json()
      if (data.message) {
        alert(data.message)
      } else {
        return
        navigate('/login')
      }
    } catch (err) {
      console.log(err)
      alert('error!')
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
        sx={{ padding: '25px', maxWidth: '500px', display: 'flex', alignItems: 'center', flexDirection: 'column' }}
        variant="elevation"
      >
        <Typography variant="h3">Sign Up</Typography>
        <Typography variant="h6">for Binotify Premium App</Typography>
        <Typography variant="subtitle2" marginTop={2}>
          Have an account? <Link href="/login">Sign In</Link> instead.
        </Typography>
        <Box component="form" sx={{ width: '80%' }}>
          <TextField required margin="normal" fullWidth id="name" label="Name" name="name" inputRef={nameRef} />
          <TextField
            required
            margin="normal"
            fullWidth
            id="username"
            label="Username"
            name="username"
            inputRef={usernameRef}
            onChange={onUsernameChange}
            error={error.usernameError}
            helperText={error.usernameError ? 'Invalid username format' : ''}
          />
          <TextField
            required
            margin="normal"
            fullWidth
            id="email"
            label="Email"
            name="email"
            type="email"
            inputRef={emailRef}
            onChange={onEmailChange}
            error={error.emailError}
            helperText={error.emailError ? 'Invalid email' : ''}
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
          <TextField
            required
            margin="normal"
            fullWidth
            id="confirm-password"
            label="Confirm Password"
            name="confirm-password"
            type="password"
            inputRef={confirmPasswordRef}
          />
          <Button
            variant="contained"
            sx={{ marginTop: '15px', float: 'right', minWidth: '120px' }}
            type="submit"
            onClick={(e) => {
              e.preventDefault()
              onSubmit()
            }}
            disabled={error.emailError || error.usernameError}
          >
            Submit
          </Button>
        </Box>
      </Paper>
    </Grid>
  )
}

export default Register
