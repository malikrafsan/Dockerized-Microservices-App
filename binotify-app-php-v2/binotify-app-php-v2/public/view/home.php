<?php
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongCard.php";

$authSrv = AuthSrv::getInstance();

$songSrv = SongSrv::getInstance();
$songs = $songSrv->getNLastSongs(10);
usort($songs, function ($a, $b) {
  
  return strtolower($a->get('judul')) > strtolower($b->get('judul'));
});
$songElmts = implode("", array_map(function ($song) {
  return SongCard($song);
}, $songs));
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/lib.css">
  <link rel="stylesheet" href="public/css/shared.css">
  <link rel="stylesheet" href="public/css/home.css">
  <title>Document</title>
</head>

<body>
  <div class="page d-flex">
    <?php
    echo Sidebar();
    ?>
    <div id="main">
      <?php
      echo Navbar();
      ?>
      <div id="content">
        <div class="song-list d-flex flex-wrap">
          <?php
          echo $songElmts;
          ?>
        </div>
      </div>
    </div>
  </div>

  <script defer async src="/public/js/lib.js"></script>
  <script defer async src="/public/js/shared.js"></script>
</body>

</html>