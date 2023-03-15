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
  header("Location: /search");
  die();
}

$song_id = $song->get('song_id');
$judul = $song->get('judul');
$penyanyi = $song->get('penyanyi');
$tanggal_terbit = $song->get('tanggal_terbit');
$genre = $song->get('genre');
$duration = $song->get('duration');
$audio_path = $song->get('audio_path');
$image_path = $song->get('image_path');
$image_path = $image_path ? $image_path : '/public/assets/cover-default.jpg';

$albums = $albumSrv->getAllAlbums(['penyanyi' => [$penyanyi, PDO::PARAM_STR]]);

$album_id = $song->get('album_id');
$album = $albumSrv->getById($album_id);

$album_judul = $album->get('judul');

$formattedDuration = Helper::formatDuration($duration);

$albumOptionList = implode("", array_map(function ($album) {
  $id = $album->get('album_id');
  $title = $album->get('judul');
  return "<option value=$id>$title</option>";
}, $albums));
$albumOptionList = "<option value=-1>No Album</option>" . $albumOptionList;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/song-detail-rev.css">
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
      <div id="content" class="d-flex align-items-center justify-content-center">
        <div class="song-detail-content d-flex flex-column flex-lg-row justify-content-center song-detail-content pb-5">
          <div class="song-cover-container">
            <div class="song-cover img-container mr-4 position-relative ml-auto ml-md-0">
              <img <?php
                    echo "src='$image_path' ";
                    echo "alt='$judul cover' ";
                    ?> class="song-detail-cover">
              <input type="file" hidden class="position-absolute input-cover-song" name="cover_song" accept="image/*">
            </div>
          </div>
          <div class="song-right-container d-flex flex-column justify-content-between">
            <div class="song-right-top-container">
              <div class="song-info-container">
                <div class="song-detail-info-attr">
                  Judul:
                  <div class="song-info-name font-weight-bold">
                    <?php echo $judul ?>
                  </div>
                </div>
                <div class="song-detail-info-attr">
                  Penyanyi:
                  <div class="song-info-artist font-weight-bold">
                    <?php echo $penyanyi ?>
                  </div>
                </div>
                <div class="song-detail-info-attr">
                  Album:
                  <a <?php
                      echo "href='/album/$album_id' ";
                      ?> class="song-detail-album-btn <?php if ($album_judul) echo "text-underline" ?> ">
                    <div class="song-info-song-judul">
                      <?php echo $album_judul ? $album_judul : "No Album" ?>
                    </div>
                  </a>
                  <div class="song-detail-change-album-container" hidden>
                    <select name="album" class="song-detail-select song-detail-select-album">
                      <option value="">Choose Album</option>
                      <?php echo $albumOptionList ?>
                    </select>
                  </div>
                </div>
                <div class="song-detail-info-attr">
                  Tanggal Terbit:
                  <div class="song-info-year">
                    <?php echo $tanggal_terbit ?>
                  </div>
                </div>
                <div class="song-detail-info-attr">
                  Genre:
                  <div class="song-info-genre">
                    <?php echo $genre ?>
                  </div>
                </div>
                <div class="song-detail-info-attr">
                  Durasi:
                  <div class="song-info-duration">
                    <?php echo $formattedDuration ?>
                  </div>
                </div>
              </div>
              <div class="song-detail-change-song-container" hidden>
                <div class="song-detail-info-attr">
                  Ubah Lagu:
                </div>
                <input class="input-audio-song" type="file" onchange="updateAudio()" name="file-song" id="input-file" accept="audio/*">
              </div>
            </div>
            <?php
            if (AuthSrv::getInstance()->isAdmin()) {
              $editBtns = <<<"EOT"
                <div class="d-flex justify-content-between song-detail-admin-btn-group">
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
                </div>
              EOT;

              echo $editBtns;
            }
            ?>
          </div>
          <div class="audio-container d-flex p-3 justify-content-between flex-column flex-md-row" id="audio-player-container">
            <audio <?php
                    echo "src='$audio_path' ";
                    ?> class="song-detail-audio" preload="metadata" loop onplay="onPlayCallback()">
            </audio>
            <div class="audio-left-container d-none d-md-flex align-items-center">
              <div class="img-container audio-icon-container">
                <img <?php
                      echo "src='$image_path' ";
                      echo "alt='$judul cover' ";
                      ?>>
              </div>
              <div class="audio-left-info ml-3">
                <div class="audio-title">
                  <?php echo $judul ?>
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
      </div>
    </div>
    <script defer async src="/public/js/lib.js"></script>
    <script defer async src="/public/js/shared.js"></script>
    <script defer async src="/public/js/update-audio.js"></script>
    <?php
    if (AuthSrv::getInstance()->isAdmin()) {
      echo "<script defer async src='/public/js/song-detail-rev.js'></script>";
    }
    ?>
</body>

</html>