import { Request, Response } from 'express'
import prisma from '../../prisma'
import jwt from 'jsonwebtoken'
require('dotenv').config()

interface JWTPayload {
  id: string
  username: string
  isAdmin: false
}

const currentUserHandler = async (req: Request, res: Response) => {
  const authHeader = req.headers.authorization

  if (!authHeader) {
    return res.status(400).json({ isAuthenticated: false })
  }

  if (authHeader) {
    const token = authHeader.split(' ')[1]

    try {
      const payload = await jwt.verify(token, process.env.ACCESS_TOKEN_SECRET as string)
      if (typeof payload === 'string') {
        return res.status(400).json({ isAuthenticated: false })
      }

      const user = await prisma.user.findFirst({
        where: {
          username: payload.username,
        },
      })

      if (user === null) {
        return res.status(403).json({ isAuthenticated: false, message: 'not found' })
      }
      return res
        .status(200)
        .json({ username: user.username, name: user.name, isAdmin: user.isAdmin, isAuthenticated: true })
    } catch (error) {
      return res.status(403).json({ isAuthenticated: false, message: 'invalid token' })
    }
  }

  return res.sendStatus(500).json({ isAuthenticated: false })
}

export default currentUserHandler
