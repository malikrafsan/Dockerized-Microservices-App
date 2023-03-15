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

$album_id = $_GLOBALS['__urlParams'][0];
$albumSrv = AlbumSrv::getInstance();
$album = $albumSrv->getById($album_id);

if (is_null($album->get('album_id'))) {
  header("Location: /albums");
  die();
}

$albumWithSongs = $albumSrv->populateSongsFromAlbums($album);

$album_id = $albumWithSongs->get('album_id');
$judul = $albumWithSongs->get('judul');
$penyanyi = $albumWithSongs->get('penyanyi');
$total_duration = $albumWithSongs->get('total_duration');
$image_path = $albumWithSongs->get('image_path');
$image_path = $image_path ? $image_path : '/public/assets/cover-default.jpg';
$tanggal_terbit = $albumWithSongs->get('tanggal_terbit');
$genre = $albumWithSongs->get('genre');
$songs = $albumWithSongs->get('songs');

$albums = $albumSrv->getAllAlbums(['penyanyi' => [$penyanyi, PDO::PARAM_STR]]);

$totalDurationFormatted = Helper::formatLongDuration($total_duration);
$songList = implode("", array_map(function ($song, $idx) {
  return SongList($song, $idx + 1);
}, $songs, array_keys($songs)));
$songOptionList = implode("", array_map(function ($song) {
  $id = $song->get('song_id');
  $title = $song->get('judul');
  return "<option value=$id>$title</option>";
}, $songs));
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
  <link rel="stylesheet" href="/public/css/album-detail.css">
  <title>Document</title>
</head>

<body>
  <div class="d-none" id="album_id">
    <?php echo $album_id; ?>
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
        <div class="album-detail-top-container d-block d-sm-flex align-items-end px-3 pb-3 px-md-4 pb-md-4 pt-5 pl-5">
          <div class="album-cover img-container mr-4 position-relative ml-auto ml-md-0">
            <img <?php
                  echo "src='$image_path' ";
                  echo "alt='$judul cover' ";
                  ?> class="album-detail-cover">
            <input type="file" hidden class="position-absolute input-cover-album" name="cover_album" accept="image/*">
          </div>
          <div class="album-info">
            <div class="album-info-type font-weight-bold">ALBUM</div>
            <div class="album-info-name font-weight-bold">
              <?php echo $judul ?>
            </div>
            <div class="album-info-bottom d-flex align-items-center flex-wrap">
              <div class="album-info-artist font-weight-bold">
                <?php echo $penyanyi ?>
              </div>
              <div class="mx-2">•</div>
              <div class="album-info-year">
                <?php echo $tanggal_terbit ?>
              </div>
              <div class="mx-2">•</div>
              <div class="album-info-count-songs font-weight-bold">
                <?php echo count($songs) ?> songs
              </div>
              <div class="mx-2">•</div>
              <div class="album-info-total-duration">
                <?php echo $totalDurationFormatted ?>
              </div>
            </div>
          </div>
        </div>
        <div class="album-detail-bottom-container">
          <?php
          if (AuthSrv::getInstance()->isAdmin()) {
            $editBtns = <<<"EOT"
                <div class="d-flex justify-content-between">
                  <div class="d-flex album-detail-admin-btn-group align-items-center">
                    <button
                      class="album-detail-cancel-btn btn btn-primary"
                      hidden onclick="onCancel()"
                    >Cancel</button>
                    <button 
                      class="album-detail-edit-btn btn btn-primary" 
                      onclick="onEdit()"
                    >Edit</button>
                    <button 
                      class="album-detail-save-btn btn btn-primary"
                      hidden onclick="onSave()"
                    >Save</button>
                    <button
                      class="album-detail-delete-btn btn btn-danger"
                      onclick="onDelete()"
                    >Delete</button>
                  </div>
                  <div hidden class="album-detail-change-album-wrapper">
                    <div class="album-detail-change-album-container d-flex flex-column justify-content-end d-none">
                      Move Song to Other Album
                      <select name="song" class="album-detail-select album-detail-select-song">
                        <option value="">Choose Song</option>
                        $songOptionList
                      </select>
                      <select name="album" class="album-detail-select album-detail-select-album">
                        <option value="">Choose Album</option>
                        <option value="-1">No Album</option>
                        $albumOptionList
                      </select>
                    </div>
                  </div>
                </div>
              EOT;

            echo $editBtns;
          }
          ?>
          <div class="d-flex align-items-center">
            <div class="album-detail-header-song-list song-list-item d-flex align-items-center mb-3 mt-3 flex-grow-1">
              <div class="song-list-item-index">
                #
              </div>
              <div class="song-list-item-body">
                TITLE
              </div>
              <div class="song-list-item-duration d-flex justify-content-center align-items-center">
                <div class="img-container">
                  <img src="/public/assets/clock-icon.svg" alt="">
                </div>
              </div>
            </div>
            <div class="song-list-delete-btn-container text-center" hidden>
              Delete
            </div>
          </div>
          <?php echo $songList ?>
        </div>
      </div>
    </div>
  </div>
  <script defer async src="/public/js/lib.js"></script>
  <script defer async src="/public/js/shared.js"></script>
  <script defer async src="/public/js/randombgcolor.js"></script>
  <?php
  if (AuthSrv::getInstance()->isAdmin()) {
    echo "<script defer async src='/public/js/album-detail.js'></script>";
  }
  ?>
</body>

</html>