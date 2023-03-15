import { Navigate } from "react-router-dom"
// import { logoutUser } from "../../lib/user"
import { clearToken } from "../../lib/user"

const Logout = () => {
  clearToken()

  return (
    <Navigate to="/login" />
  )
}

export default Logout