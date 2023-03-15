<?php

$routes = array(
  '/' => PROJECT_ROOT_PATH . "/public/view/home.php",
  '/login' => PROJECT_ROOT_PATH . '/public/view/login.php',
  '/register' => PROJECT_ROOT_PATH . '/public/view/register.php',
  '/search' => PROJECT_ROOT_PATH . '/public/view/search.php',
  '/albums' => PROJECT_ROOT_PATH . '/public/view/albums.php',
  '/logout' => PROJECT_ROOT_PATH . '/public/view/logout.php',
  '/userlist' => PROJECT_ROOT_PATH . '/public/view/userlist.php',
  '/album-detail' => PROJECT_ROOT_PATH . '/public/view/album-detail.php',
  '/album/*' => PROJECT_ROOT_PATH . '/public/view/album-detail.php',
  '/insert-album' => PROJECT_ROOT_PATH . '/public/view/insert-album.php',
  '/insert-song' => PROJECT_ROOT_PATH . '/public/view/insert-song.php',
  // '/song/*' => PROJECT_ROOT_PATH . '/public/view/song-detail.php',
  '/test-audio' => PROJECT_ROOT_PATH . '/public/view/test-audio.php',
  '/song/*' => PROJECT_ROOT_PATH . '/public/view/song-detail-rev.php',
  '/premium-artists' => PROJECT_ROOT_PATH . '/public/view/premium-artists.php',
  '/premium-songs/*' => PROJECT_ROOT_PATH . '/public/view/premium-songs.php',
  '/subscription' => PROJECT_ROOT_PATH . '/public/view/subscription.php',
);
