import { Request, Response } from 'express';
import prisma from '../../prisma';
import bcryptjs from 'bcryptjs';
import jwt from 'jsonwebtoken';
require('dotenv').config()

const loginHandler = async (req: Request, res: Response) => {
  const { username, password } = req.body;
  const user = await prisma.user.findFirst({
    where: {
      username,
    },
  });

  if (user) {
    
    const validPassword = await bcryptjs.compare(
      password,
      user.password,
    );

    if (!validPassword) {
      return res.status(400).json({ message: 'Invalid Password' });
    }

    const { username, isAdmin } = user;
    const accessToken = jwt.sign(
      { username, isAdmin },
      process.env.ACCESS_TOKEN_SECRET as string,
    );
    return res.status(200).json({
      token: accessToken,
      isAdmin,
    });
  }

  return res.status(401).json({ message: 'User does not exist' });
};

export default loginHandler;