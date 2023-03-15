<?php

require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
// MOCK, isinya masih pake song/album biasa
require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";

require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongCard.php";
require_once PROJECT_ROOT_PATH . "/public/components/PremiumSongList.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Helper.php";

require_once PROJECT_ROOT_PATH . "/src/clients/BinotifyRestClient.php";

$creator_id = $_GLOBALS['__urlParams'][0];
$user_id = $_SESSION['user_id'];

if (is_null($user_id) || is_null($creator_id)) {
  header("Location: /premium-artists");
}

$premiumSongsJson = BinotifyRestClient::getPremiumSong($user_id, $creator_id);

$songs = json_decode($premiumSongsJson)->data->songs;
$penyanyi = json_decode($premiumSongsJson)->data->creator_name;

// If songs is empty
if (is_null($songs)) {
  header("Location: /premium-artists");
}

$songList = implode("", array_map(function ($song, $idx) {
  return PremiumSongList($song, $idx + 1);
}, $songs, array_keys($songs)));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/premium-songs.css">
  <link rel="stylesheet" href="/public/css/song-detail-rev.css">
  <title>Document</title>
</head>

<body>
  <div class="page d-flex">
    <?php
    echo Sidebar();
    ?>
    <div id="main">
      <div class="wrapper-sidebar-control">
        <?php echo SidebarControl(); ?>
      </div>
      <div class="wrapper-user-profile">
        <?php echo UserProfile() ?>
      </div>
      <div id="content" class="d-flex flex-column">
        <div class="premium-songs-top-container d-block d-sm-flex align-items-end px-3 pb-3 px-md-4 pb-md-4 pt-5 pl-5">
          <div class="premium-songs-info">
            <br>
            <div class="premium-songs-info-type font-weight-bold">PREMIUM SONGS</div>
            <div class="premium-songs-info-name font-weight-bold">
              <?php echo $penyanyi ?>
            </div>
          </div>
        </div>
        <div class="premium-songs-bottom-container">
          <div class="d-flex align-items-center">
            <div class="premium-songs-header-song-list song-list-item d-flex align-items-center mb-3 mt-3 flex-grow-1">
              <div class="song-list-item-index">
                #
              </div>
              <div class="song-list-item-body">
                TITLE
              </div>
              <div class="song-list-item-play d-flex justify-content-center align-items-center">
                PLAY
              </div>
            </div>
          </div>
          <?php echo $songList ?>
        </div>
      </div>
      
      <!-- AUDIO PLAYER -->
      <div class="audio-container d-flex p-3 justify-content-between flex-column flex-md-row" id="audio-player-container">
        <audio class="song-detail-audio" preload="metadata" loop>
        </audio>
        <div class="audio-left-container d-none d-md-flex align-items-center">
          <div class="audio-left-info ml-3">
            <div class="audio-title" id="audio-title">
              
            </div>
            <div class="audio-artist">
              <?php echo $penyanyi ?>
            </div>
          </div>
        </div>
        <div class="audio-center-container d-flex flex-column align-items-center">
          <div class="audio-btn-play-container img-container" id="play-icon">
            <div class="circle-button">
              <img src="/public/assets/icons/play-icon.svg" class="invert-color-img" alt="">
            </div>
          </div>
          <div class="d-flex justify-content-center align-items-center">
            <div class="current-time audio-time" id="current-time">0:00</div>
            <div class="audio-seek-slider-container mx-3 d-flex align-items-center">
              <input type="range" id="seek-slider" max="100" value="0">
            </div>
            <div id="duration" class="duration audio-time">0:00</div>
          </div>
        </div>
        <div class="audio-right-container d-flex align-items-center justify-content-center justify-content-md-start">
          <div class="audio-mute-btn-container img-container" id="mute-icon">
            <img src="/public/assets/icons/speaker.svg" alt="">
          </div>
          <div class="audio-volume-slider-container d-flex align-items-center mx-3">
            <input type="range" id="volume-slider" max="100" value="100">
          </div>
          <div id="volume-output">
            100
          </div>
        </div>
      </div>
      
    </div>
    <script defer async src="/public/js/lib.js"></script>
    <script defer async src="/public/js/shared.js"></script>
    <script defer async src="/public/js/update-audio.js"></script>
  </div>
</body>

</html>