import React from 'react'
import ReactDOM from 'react-dom/client'
import Routes from './routes/routes'
import './index.css'

ReactDOM.createRoot(document.getElementById('root') as HTMLElement).render(
  <React.StrictMode>
    <Routes></Routes>
  </React.StrictMode>
)
