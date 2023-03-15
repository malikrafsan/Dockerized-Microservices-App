import { createBrowserRouter, redirect, RouterProvider } from 'react-router-dom'

import Register from '../pages/Register/Register'
import Login from '../pages/Login/Login'
import NotFound from '../pages/NotFound/NotFound'
import Index from '../pages/Index/Index'
import ManageSong from '../pages/ManageSong/ManageSong'
import SubRequest from '../pages/SubRequest/SubRequest'
import AuthDummy from '../pages/AuthDummy/AuthDummy'
import EditSong from '../pages/ManageSong/EditSong'
import CreateSong from '../pages/ManageSong/CreateSong'
import ProtectedRoute from '../components/ProtectedRoute'
import Logout from '../pages/Logout/Logout'

const routesList = createBrowserRouter([
  {
    path: '/',
    element: <Index />,
  },
  {
    path: '/register',
    element: <Register />,
  },
  {
    path: '/login',
    element: <Login />,
  },
  {
    path: '/manage-song',
    element: (
      <ProtectedRoute roles={['artist']} >
        <ManageSong />
      </ProtectedRoute>
    ),
  },
  {
    path: '/subscription-request',
    element: (
      <ProtectedRoute roles={['admin']} >
        <SubRequest />
      </ProtectedRoute>
    ),
  },
  {
    path: '/auth-dummy',
    element: <AuthDummy />,
  },
  {
    path: '/edit/:id',
    element: (
      <ProtectedRoute roles={['artist']} >
        <EditSong />
      </ProtectedRoute>
    ),
  },
  {
    path: '/create',
    element: (
      <ProtectedRoute roles={['artist']} >
        <CreateSong />
      </ProtectedRoute>
    ),
  },
  {
    path: '/logout',
    element: <Logout />,
  },
  {
    path: '*',
    element: <NotFound />,
  },
])

const Routes = () => {
  return <RouterProvider router={routesList} />
}

export default Routes
