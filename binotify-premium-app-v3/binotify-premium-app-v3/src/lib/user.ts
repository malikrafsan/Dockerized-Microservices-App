export const getUser = () => {
  const name = localStorage.getItem('name')
  const username = localStorage.getItem('username')
  const role = localStorage.getItem('role')
  const isAuthenticated = !!username

  return { name, username, role, isAuthenticated }
}

export const setUser = (name: string, username: string, role: string) => {
  localStorage.setItem('name', name)
  localStorage.setItem('username', username)
  localStorage.setItem('role', role)
}

export const logoutUser = () => {
  localStorage.removeItem('name')
  localStorage.removeItem('username')
  localStorage.removeItem('role')
}

export const setToken = (token: string) => {
  localStorage.setItem('token', token)
}

export const getToken = () => {
  return localStorage.getItem('token')
}

export const clearToken = () => {
  localStorage.removeItem('token')
}

export const getName = () => {
  return localStorage.getItem('name')
}

export const setName = (name: string) => {
  localStorage.setItem('name', name)
}

export default { getUser, setUser, logoutUser, setToken, getToken, clearToken }
