import { Request, Response } from "express";
import prisma from "../../prisma";

const getAdminEmails = async (req: Request, res: Response) => {
  const emails = await prisma.user.findMany({
    where: { isAdmin: true },
    select: { email: true },
  });
  const result = emails.map(e => e.email).join(",");
  res.json(result).send();
}

export default getAdminEmails;