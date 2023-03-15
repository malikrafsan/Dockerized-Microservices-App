import { Request, Response } from "express";
import prisma from "../../prisma";
import { soapClient } from "../../clients";
import { ISubscription } from "../../interfaces";
import { handlerWrapperError } from "../../utils";


const getPremiumSongsBySubscriberId = async (req: Request, res: Response) => {
  try {
    console.log("getPremiumSongsBySubscriberId");
    const { subscriber_id, creator_id } = req.query;
    console.log("subscriber_id", subscriber_id);
    console.log("creator_id", creator_id);

    if (!creator_id || !subscriber_id) {
      throw new Error("creator_id and subscriber_id is required");
    }

    if (typeof creator_id !== "string") {
      throw new Error("creator_id must be string");
    }

    if (typeof subscriber_id !== "string") {
      throw new Error("subscriber_id must be string");
    }

    const subscription = await soapClient.checkStatus(creator_id, subscriber_id);
    if (!subscription || subscription.status !== "ACCEPTED") {
      throw new Error(
        `subscriber_id ${subscriber_id} haven't subscribe to the creator_id ${creator_id}`
      );
    }

    const parsedCreatorId = Number(creator_id);
    const user = await prisma.user.findFirst({
      where: {
        user_id: parsedCreatorId,
      }
    })
    if (!user) {
      throw new Error(`creator_id ${creator_id} not found`);
    }

    const songs = await prisma.song.findMany({
      where: {
        penyanyi_id: parsedCreatorId,
      },
    })

    res.send({
      status: "success",
      data: { subscriber_id, creator_id, creator_name: user.name, songs },
    });
  } catch (error) {
    console.log(error);
    const msg = (error as Error).message;
    res.send({
      status: "error",
      error: JSON.stringify(msg),
    });
  }
}

export default getPremiumSongsBySubscriberId;
