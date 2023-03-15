import { Request, Response, NextFunction } from 'express';
import jwt from 'jsonwebtoken';

const validateJWT = (
  req: Request,
  res: Response,
  next: NextFunction,
) => {
  const authHeader = req.headers.authorization;

  if (authHeader) {
    const token = authHeader.split(' ')[1];

    jwt.verify(token, process.env.ACCESS_TOKEN_SECRET as string, (err: any, user: any) => {
      if (err) {
        return res.sendStatus(403);
      }
      res.locals.user = user;
      next();
    });
  } else {
    res.sendStatus(401);
  }
};

export default validateJWT;
