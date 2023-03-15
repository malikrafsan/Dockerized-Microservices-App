import { Request, Response, NextFunction } from 'express';

const validateAdmin = (
  _: Request,
  res: Response,
  next: NextFunction,
) => {
  if (!res.locals.user.is_admin) {
    return res.status(401).json({ message: 'User is not admin' });
  }

  next();
};

export default validateAdmin;
