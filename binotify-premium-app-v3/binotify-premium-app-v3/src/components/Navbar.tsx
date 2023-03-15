import {
  AppBar,
  Box,
  Typography,
  Toolbar,
  ListItem,
  ListItemButton,
  ListItemText,
  Divider,
  List,
  IconButton,
  Button,
  Drawer,
} from '@mui/material'
import MenuIcon from '@mui/icons-material/Menu'
import { useState } from 'react'
import { getName } from '../lib/user'
import { useNavigate } from 'react-router-dom'

const Navbar = () => {
  const [mobileOpen, setMobileOpen] = useState(false)
  const loggedInName = getName()
  const navigate = useNavigate()

  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen)
  }

  const handleLogout = () => {
    navigate('/logout')
  }

  const drawer = (
    <Box onClick={handleDrawerToggle} sx={{ textAlign: 'center' }}>
      <Typography variant="h6" sx={{ my: 2 }}>
        Binotify Premium App
      </Typography>
      <Divider />
      <List>
        <ListItem disablePadding>
          <ListItemButton sx={{ textAlign: 'center' }} disabled>
            <ListItemText primary={loggedInName} />
          </ListItemButton>
        </ListItem>
        <ListItem disablePadding>
          <ListItemButton sx={{ textAlign: 'center' }} onClick={handleLogout}>
            <ListItemText primary={'Logout'} />
          </ListItemButton>
        </ListItem>
      </List>
    </Box>
  )

  return (
    <>
      <AppBar component="nav">
        <Toolbar>
          <IconButton
            color="inherit"
            aria-label="open drawer"
            edge="start"
            onClick={handleDrawerToggle}
            sx={{ mr: 2, display: { sm: 'none' } }}
          >
            <MenuIcon />
          </IconButton>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1, display: { xs: 'none', sm: 'block' } }}>
            Binotify Premium App
          </Typography>
          <Box sx={{ display: { xs: 'none', sm: 'block' } }}>
            <Button sx={{ color: '#fff', marginRight: 4 }}>{loggedInName}</Button>
            <Button sx={{ color: '#fff' }} onClick={handleLogout}>
              Logout
            </Button>
          </Box>
        </Toolbar>
      </AppBar>
      <Box component="nav">
        <Drawer
          variant="temporary"
          open={mobileOpen}
          onClose={handleDrawerToggle}
          ModalProps={{
            keepMounted: true,
          }}
          sx={{
            display: { xs: 'block', sm: 'none' },
            '& .MuiDrawer-paper': { boxSizing: 'border-box', width: 240 },
          }}
        >
          {drawer}
        </Drawer>
      </Box>
    </>
  )
}

export default Navbar
