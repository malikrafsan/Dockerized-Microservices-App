import { Navigate, useNavigate } from 'react-router-dom'
import { useState, useEffect } from 'react'
import { getToken, getUser, setName } from '../lib/user'
import FullPageLoader from '../pages/FullPageLoader/FullPageLoader'

type ProtectedRouteProps = {
  roles: string[]
  children: JSX.Element
}

const ProtectedRoute = ({ roles, children }: ProtectedRouteProps) => {
  const [loading, setLoading] = useState(true)
  const token = getToken()
  const navigate = useNavigate()

  const fetchData = async () => {
    try {
      const res = await fetch(`${import.meta.env.VITE_SERVER_URL}/current-user`, {
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + token || '',
        },
      })
      const data = await res.json()

      if (!data.isAuthenticated) {
        navigate('/login')
        return
      }

      if (roles.includes('artist') && data.isAdmin) {
        navigate('/')
        return
      }

      if (roles.includes('admin') && !data.isAdmin) {
        navigate('/')
        return
      }

      setName(data.name)

      setLoading(false)
    } catch (error) {
      console.log(error)
      alert('ERROR', error)
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  if (loading) {
    return <FullPageLoader />
  }

  return children
}

export default ProtectedRoute
