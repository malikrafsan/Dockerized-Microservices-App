import { Request, Response } from 'express';

export type handlerType = (
  req: Request,
  res: Response,
) => Promise<Response<any, Record<string, any>>>;

export interface IAuthHandler {
  loginHandler: handlerType;
  registerHandler: handlerType;
  currentUserHandler: handlerType;
}

export interface ISubscription {
  subscriberId: number;
  creatorId: number;
  status: string;
}
