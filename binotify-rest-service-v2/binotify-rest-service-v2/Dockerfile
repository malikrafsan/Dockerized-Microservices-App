FROM node:16-alpine

WORKDIR /usr/src/app

COPY package*.json ./

RUN rm -rf node_modules
RUN npm install
COPY . .
EXPOSE 8000

RUN npx prisma generate
# RUN npx prisma migrate deploy

CMD [ "npm", "run", "dev" ]

# CMD ["npm", "i", "-g", "prisma"]
