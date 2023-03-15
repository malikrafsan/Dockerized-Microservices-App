<?php

require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongCard.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongList.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Helper.php";

$song_id = $_GLOBALS['__urlParams'][0];
$songSrv = SongSrv::getInstance();
$albumSrv = AlbumSrv::getInstance();
$song = $songSrv->getById($song_id);

if (is_null($song->get('song_id'))) {
  header("Location: /");
  die();
}

$albums = $albumSrv->fetchAll();

$song_id = $song->get('song_id');
$judul = $song->get('judul');
$penyanyi = $song->get('penyanyi');
$tanggal_terbit = $song->get('tanggal_terbit');
$genre = $song->get('genre');
$duration = $song->get('duration');
$audio_path = $song->get('audio_path');
$image_path = $song->get('image_path');
$image_path = $image_path ? $image_path : '/public/assets/cover-default.jpg';

$album_id = $song->get('album_id');
$album = $albumSrv->getById($album_id);

$album_judul = $album->get('judul');

$formattedDuration = Helper::formatDuration($duration);

$albumOptionList = implode("", array_map(function ($album) {
  $id = $album->get('album_id');
  $title = $album->get('judul');
  return "<option value=$id>$title</option>";
}, $albums));


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/song-detail.css">
  <title>Document</title>
</head>

<body>
  <div class="d-none" id="album_id">
    <?php echo $album_id; ?>
  </div>
  <div class="d-none" id="song_id">
    <?php echo $song_id; ?>
  </div>
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
        <div class="song-detail-top-container d-block d-sm-flex align-items-end px-3 pb-3 px-md-4 pb-md-4 pt-5 pl-5">
          <div class="song-cover img-container mr-4 position-relative ml-auto ml-md-0">
            <img <?php
                  echo "src='$image_path' ";
                  echo "alt='$judul cover' ";
                  ?> class="song-detail-cover">
            <input type="file" hidden class="position-absolute input-cover-song" name="cover_song" accept="image/*">
          </div>
          <div class="song-info">
            <div class="song-info-type font-weight-bold">SONG</div>
            <div class="song-info-name font-weight-bold">
              <?php echo $judul ?>
            </div>
            <div class="song-info-bottom d-flex align-items-center flex-wrap">
              <div class="song-info-artist font-weight-bold">
                <?php echo $penyanyi ?>
              </div>
              <div class="mx-2">•</div>
              <a <?php
                  echo "href='/album/$album_id' ";
                  ?> class="text-underline">
                <div class="song-info-album-judul">
                  <?php echo $album_judul ?>
                </div>
              </a>
              <div class="mx-2">•</div>
              <div class="song-info-year">
                <?php echo $tanggal_terbit ?>
              </div>
              <div class="mx-2">•</div>
              <div class="song-info-genre">
                <?php echo $genre ?>
              </div>
              <div class="mx-2">•</div>
              <div class="song-info-duration">
                <?php echo $formattedDuration ?>
              </div>
            </div>
          </div>
        </div>
        <div class="song-detail-bottom-container">
          <div>
            <input class="input-audio-song" hidden type="file" onchange="updateAudio()" name="file-song" id="input-file" accept="audio/*">
            <audio <?php
                    echo "src='$audio_path' ";
                    ?> class="song-detail-audio" controls preload="metadata" onplay="onPlayCallback()">
            </audio>
          </div>
          <?php
          if (AuthSrv::getInstance()->isAdmin()) {
            $editBtns = <<<"EOT"
                <div class="d-flex justify-content-between">
                  <div class="d-flex song-detail-admin-btn-group">
                    <button
                      class="song-detail-cancel-btn btn btn-primary"
                      hidden onclick="onCancel()"
                    >Cancel</button>
                    <button 
                      class="song-detail-edit-btn btn btn-primary" 
                      onclick="onEdit()"
                    >Edit</button>
                    <button 
                      class="song-detail-save-btn btn btn-primary"
                      hidden onclick="onSave()"
                    >Save</button>
                    <button
                      class="song-detail-delete-btn btn btn-danger"
                      onclick="onDelete()"
                    >Delete</button>
                  </div>
                  <div class="song-detail-change-album-container" hidden>
                    <select name="album" class="song-detail-select song-detail-select-album">
                      <option value="">Choose Album</option>
                      $albumOptionList
                    </select>
                  </div>
                </div>
              EOT;

            echo $editBtns;
          }
          ?>
        </div>
      </div>
      <!-- <div id="audio-player-container">
        <audio <?php
                echo "src='$audio_path' ";
                ?> class="song-detail-audio" preload="metadata">
        </audio>
        <p>audio player ish</p>
        <button id="play-icon"></button>
        <span id="current-time" class="time">0:00</span>
        <input type="range" id="seek-slider" max="100" value="0">
        <span id="duration" class="time">0:00</span>
        <output id="volume-output">100</output>
        <input type="range" id="volume-slider" max="100" value="100">
        <button id="mute-icon"></button>
      </div> -->
    </div>
  </div>
  <script defer async src="/public/js/lib.js"></script>
  <script defer async src="/public/js/update-audio.js"></script>
  <?php
  if (AuthSrv::getInstance()->isAdmin()) {
    echo "<script defer async src='/public/js/song-detail.js'></script>";
  }
  ?>
</body>

</html>