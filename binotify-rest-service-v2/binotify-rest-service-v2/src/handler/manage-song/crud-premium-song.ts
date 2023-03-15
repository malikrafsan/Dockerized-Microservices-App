import { Request, Response } from "express";
import prisma from "../../prisma";

// READ
export const getPremiumSongsByPenyanyiId = async (req: Request, res: Response) => {
  try {
    const user = await prisma.user.findFirst({
      where: { username: res.locals.user.username }
    })

    const songs = await prisma.song.findMany({
      where: {
        penyanyi_id: Number(user?.user_id),
      },
    })

    res.json(songs);
  } catch (error) {
    console.log(error);
    const msg = (error as Error).message;
    res.send({
      status: "error",
      error: JSON.stringify(msg),
    });
  }
}

export const getPremiumSongBySongId = async (req: Request, res: Response) => {
  try {
    const user = await prisma.user.findFirst({
      where: { username: res.locals.user.username }
    })

    const { id } = req.params

    const song = await prisma.song.findFirst({
      where: {
        song_id: Number(id),
        penyanyi_id: Number(user?.user_id),
      },
    })

    res.status(200).json({ status: 'success', data: song });
  } catch (error) {
    console.log(error);
    const msg = (error as Error).message;
    res.send({
      status: "error",
      error: JSON.stringify(msg),
    });
  }
}

// CREATE
export const createPremiumSong = async (req: Request, res: Response) => {
  try {
    const user = await prisma.user.findFirst({
      where: { username: res.locals.user.username }
    })

    const { judul, audio_path } = req.body;
    if (!judul || !audio_path) {
      throw new Error("judul and audio_path is required");
    }

    console.log({
      judul, audio_path
    })

    const song = await prisma.song.create({
      data: {
        judul,
        penyanyi_id : Number(user?.user_id),
        audio_path,
      },
    });

    res.send({
      status: "success",
      data: song,
    });
  } catch (err) {
    res.status(500).send
  }
};

// DELETE
export const deletePremiumSongById = async (req: Request, res: Response) => {
  try {
    const user = await prisma.user.findFirst({
      where: { username: res.locals.user.username }
    })

    const { id } = req.params;
    const song = await prisma.song.findFirst({
      where: { song_id: Number(id) },
    });

    if (song?.penyanyi_id !== user?.user_id) {
      throw new Error("penyanyi_id does not match");
    }

    const deletedSong = await prisma.song.delete({
      where: { song_id: Number(id) }
    });

    res.status(200).json({ status: 'success', data: deletedSong});
  } catch (err) {
    res.status(500).json({ status: 'error', message: 'server error' })
  }
};

// UPDATE
export const updatePremiumSongById = async (req: Request, res: Response) => {
  try {
    const user = await prisma.user.findFirst({
      where: { username: res.locals.user.username }
    })

    const { id } = req.params;
    const song = await prisma.song.findFirst({
      where: { song_id: Number(id) },
    });

    if (song?.penyanyi_id !== user?.user_id) {
      throw new Error("penyanyi_id does not match");
    }

    const { judul, audio_path } = req.body;
    const updatedSong = await prisma.song.update({
      where: { song_id: Number(id) },
      data: {
        judul,
        audio_path,
      },
    });


    res.status(200).json({ status: 'success', data: updatedSong});
  } catch (err) {
    res.status(500).send({ status: 'error', message: 'server error'})
  }
};
