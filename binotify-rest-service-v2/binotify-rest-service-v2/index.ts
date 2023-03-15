require('dotenv').config()
import express from 'express'
import cors from 'cors'
import { soapClient } from './src/clients'
import prisma from './src/prisma'

import { authHandler, manageSongHandler, premiumSongHandler, userHandler } from './src/handler'
import { validateJWT, validateAdmin, validatePenyanyi } from './src/middlewares'
import { handlerWrapperError, cacheHandler } from './src/utils'
import { getSubscriptionRequests } from './src/handler/user'

const app = express()
const PORT = 8000
const startDate = new Date()

app.listen(PORT, () => {
  console.log(`Server started at http://localhost:${PORT}`)
  console.log(`using database url ${process.env.DATABASE_URL}`)
})

app.use(express.json())
app.use(cors())

app.get('/', (_, res) => {
  res.send(`Server has started since ${startDate}`)
})

app.get('/subscription', validateJWT, getSubscriptionRequests)

app.put('/subscription/accept', validateJWT, async (req, res) => {
  try {
    const { creator_id, subscriber_id } = req.body
    console.log('creator_id', creator_id)
    console.log('subscriber_id', subscriber_id)

    if (!creator_id || !subscriber_id) {
      return res.status(404).json({ message: 'creator_id and subscriber_id is required' })
    }

    const response = await soapClient.acceptSubscription(creator_id, subscriber_id)
    res.send(response)
  } catch (err) {
    res.status(500).send(err)
  }
})

app.put('/subscription/reject', validateJWT, async (req, res) => {
  try {
    const { creator_id, subscriber_id } = req.body
    console.log('creator_id', creator_id)
    console.log('subscriber_id', subscriber_id)

    if (!creator_id || !subscriber_id) {
      return res.status(404).json({ message: 'creator_id and subscriber_id is required' })
    }

    const response = await soapClient.rejectSubscription(creator_id, subscriber_id)
    res.send(response)
  } catch (err) {
    res.status(500).send(err)
  }
})

// CRUD Premium Song
// Read song
app.get(
  '/manage-songs',
  validateJWT,
  validatePenyanyi,
  handlerWrapperError(manageSongHandler.getPremiumSongsByPenyanyiId)
)

// Read song
app.get(
  '/manage-songs/:id',
  validateJWT,
  validatePenyanyi,
  handlerWrapperError(manageSongHandler.getPremiumSongBySongId)
)

// Create song
app.post('/manage-songs', validateJWT, validatePenyanyi, handlerWrapperError(manageSongHandler.createPremiumSong))

// Delete song by id
app.delete(
  '/manage-songs/:id',
  validateJWT,
  validatePenyanyi,
  handlerWrapperError(manageSongHandler.deletePremiumSongById)
)

// Update song by id
app.patch(
  '/manage-songs/:id',
  validateJWT,
  validatePenyanyi,
  handlerWrapperError(manageSongHandler.updatePremiumSongById)
)

// List Penyanyi

app.get('/artists', async (req, res) => {
  try {
    const CACHE_KEY = 'LIST-PENYANYI'
    const result = await cacheHandler.handle(CACHE_KEY, async () => {
      return prisma.user.findMany({
        where: {
          isAdmin: false,
        },
      })
    })

    res.json(result).send()
  } catch (err) {
    res.status(500).send()
  }
})

app.get('/artists/:id', validateJWT, async (req, res) => {
  try {
    const { id } = req.params
    const artist = await prisma.user.findUnique({
      where: { user_id: Number(id) },
      include: { songs: true },
    })
    res.json(artist)
  } catch (err) {
    res.status(500).send
  }
})

// Authentication
app.get('/current-user', handlerWrapperError(authHandler.currentUserHandler))

app.post('/login', handlerWrapperError(authHandler.loginHandler))

app.post('/register', handlerWrapperError(authHandler.registerHandler))

// premium songs
app.get('/premium-songs', handlerWrapperError(premiumSongHandler.getPremiumSongsBySubscriberId))

// Get all Admin Emails
app.get('/admin-emails', handlerWrapperError(userHandler.getAdminEmails))
