#!/bin/sh

npm i -g prisma
npx prisma generate
npx prisma migrate deploy
npm run dev
