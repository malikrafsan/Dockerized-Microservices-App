import { Request, Response } from 'express';
import prisma from '../../prisma';
import { hasher, cacheHandler } from '../../utils';

const registerHandler = async (req: Request, res: Response) => {
  const { email, password, username, name } = req.body;

  if (!email || !password || !username || !name) {
    return res.status(400).json({ message: 'Bad Request' });
  }

  const user = await prisma.user.findFirst({
    where: {
      username,
    },
  });

  if (user) {
    return res
      .status(400)
      .json({ message: 'Username is already registered' });
  }

  const hashedPassword = await hasher(password);
  const newUser = await prisma.user.create({
    data: {
      email,
      password: hashedPassword,
      username,
      name,
      isAdmin: false,
    },
  });
  cacheHandler.put("LIST-PENYANYI", null);

  return res.json(newUser);
};

export default registerHandler;