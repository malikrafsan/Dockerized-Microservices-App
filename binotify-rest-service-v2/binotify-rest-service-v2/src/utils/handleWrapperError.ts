import { Request, Response } from 'express';

const handlerWrapperError = (
  handler: (req: Request, res: Response) => void,
) => {
  return async (req: Request, res: Response) => {
    try {
      handler(req, res);
    } catch (err) {
      console.log(err);
      return res
        .status(500)
        .json({ message: 'Internal Server Error' });
    }
  };
};

export default handlerWrapperError;