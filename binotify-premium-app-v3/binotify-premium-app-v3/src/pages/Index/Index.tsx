import { Container, Typography } from '@mui/material'
import { Navigate, useNavigate } from 'react-router-dom'
import { useEffect } from 'react'

import { getToken, getUser } from '../../lib/user'
import { fetchApi } from '../../lib/fetchApi'
import FullPageLoader from '../FullPageLoader/FullPageLoader'

const Index = () => {
  const navigate = useNavigate()

  const fetchData = async () => {
    try {
      const url = import.meta.env.VITE_SERVER_URL + '/current-user'
      const res = await fetchApi(url, 'GET', { Authorization: 'Bearer ' + getToken() || '' })
      const data = await res.json()

      if (data.isAdmin) {
        navigate('/subscription-request')
      } else {
        navigate('/manage-song')
      }
    } catch (error) {
      console.log(error)
      alert('ERROR', error)
    }
  }

  useEffect(() => {
    fetchData()
  }, [])

  return <FullPageLoader />
}

export default Index
