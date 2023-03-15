import { Request, Response } from 'express'
import { soapClient } from '../../clients'
import prisma from '../../prisma'

const getSubscriptionRequests = async (req: Request, res: Response) => {
  try {
    const subscriptions = await soapClient.getSubscriptions()
    console.log('subscriptions', subscriptions)
    if (subscriptions == null) {
      return res.status(500).json({ message: 'cannot get soap subscriptions' })
    }

    const artists = await prisma.user.findMany({
      where: { isAdmin: false },
      select: { user_id: true, name: true },
    })
    const artistsMap = new Map()
    artists.forEach((item) => {
      artistsMap.set(item.user_id.toString(), item.name)
    })

    const values = Object.values(subscriptions).filter((item) => item.status === 'PENDING')
    const data = values.map((item) => ({ ...item, creatorName: artistsMap.get(item['creatorId']) || '' }))

    res.status(200).json(data)
  } catch (err) {
    res.status(500).send({
      err,
    })
  }
}

export default getSubscriptionRequests
