import { PrismaClient, User } from "@prisma/client";
import { hasher } from "../src/utils";
import { faker } from "@faker-js/faker";

const prisma = new PrismaClient();

const SIZE_GENERATED_USERS = 6;
const MAX_SIZE_GENERATED_SONGS = 4;

const adminData = [
  {
    name: "Malik Akbar",
    username: "malik",
    password: "123",
    isAdmin: true,
    email: "13520105@std.stei.itb.ac.id",
  },
  {
    name: "Hashemi",
    username: "hashemi",
    password: "123",
    isAdmin: true,
    email: "edu.malikakbar2357@gmail.com",
  },
];

const userData = Array(SIZE_GENERATED_USERS)
  .fill({})
  .map((_) => {
    const name = faker.name.fullName();
    const email = faker.internet.email();
    const password = "123";
    const username = faker.internet.userName();

    return {
      name,
      username,
      password,
      email,
      isAdmin: false,
    };
  });

const createSongOnUser = (user: User) => {
  if (user.isAdmin) {
    return [];
  }

  return Array(Math.floor(Math.random() * MAX_SIZE_GENERATED_SONGS))
    .fill({})
    .map((_) => {
      return {
        judul: faker.lorem.words(),
        penyanyi_id: user.user_id,
        audio_path: "/files/audio.wav",
      };
    });
};

const main = async () => {
  console.log("start seeding");
  const data = [...adminData, ...userData];

  await prisma.song.deleteMany();
  await prisma.user.deleteMany();

  const createdUser = await Promise.all(
    data.map(async (_user) => {
      _user.password = await hasher(_user.password);
      console.log("create user", _user);
      const user = await prisma.user.create({
        data: {
          email: _user.email,
          password: _user.password,
          username: _user.username,
          name: _user.name,
          isAdmin: _user.isAdmin,
        },
      });
      console.log(`Created user with id: ${user.user_id}`);

      return user;
    })
  );
  const songData = createdUser.map((user) => {
    return createSongOnUser(user);
  });
  const resultSong = await Promise.all(
    songData.map(async (songs) => {
      return await Promise.all(
        songs.map(async (song) => {
          console.log("create song", song);
          const result = await prisma.song.create({
            data: {
              judul: song.judul,
              penyanyi_id: song.penyanyi_id,
              audio_path: song.audio_path,
            },
          });
          console.log(`Created song with id: ${result.song_id}`);
          return result;
        })
      );
    })
  );

  console.log("seeding finished");
  console.log(createdUser);
  console.log(resultSong);
};

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
