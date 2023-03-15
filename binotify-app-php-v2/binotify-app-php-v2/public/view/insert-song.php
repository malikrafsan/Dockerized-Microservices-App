<?php
// require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";

if (!AuthSrv::getInstance()->isAdmin()) {
  header("Location: /");
  exit();
}

// $albumSrv = AlbumSrv::getInstance();
// $albums = $albumSrv->getAllAlbums();

// function cmp($a, $b)
// {
//   return strcmp(strtolower($a->get('judul')), strtolower($b->get('judul')));
// }

// usort($albums, "cmp");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/insert.css">
  <title>Insert New Song - SoundClown</title>
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
      <div id="content">
        <h1>Insert New Song</h1>

        <div class="form-container">
          <form onsubmit="submitForm(event)">
            <div class="form-section">
              <label for="song-title">Song Title</label> <br>
              <input type="text" name="song-title" placeholder="Type the song title" id="input-song-title" required>
            </div>

            <div class="form-section">
              <label for="song-artist">Artist</label> <br>
              <input type="text" name="song-artist" placeholder="Type the song artist" id="input-song-artist" required>
            </div>

            <div class="form-section">
              <label for="song-album">Album</label> <br>
              <p>To choose an album, register this song and go to the corresponding song section to edit</p>
              <!-- <select name="song-album" id="input-song-album" required>
              </select> -->
            </div>

            <div class="form-section">
              <label for="song-release-date">Release Date</label> <br>
              <input type="date" name="song-release-date" id="input-song-release-date" required>
            </div>

            <div class="form-section">
              <label for="song-genre">Genre (optional)</label> <br>
              <input type="text" name="song-genre" placeholder="Rock, pop, etc." id="input-song-genre">
            </div>

            <div class="form-section">
              <label>Insert the song file here</label> <br>
              <input type="file" name="file-song" id="input-file-song" onchange="createPreview()" accept="audio/*" required>

              <audio controls id="audio-preview" preload="metadata">
              </audio>
            </div>

            <div class="form-section">
              <label>Insert the cover picture (optional)</label> <br>
              <input type="file" name="file-song" id="input-file-cover" accept="image/*">
            </div>

            <div class="form-section-submit">
              <input type="submit" value="Register Song" id="submit-button">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script defer async src="public/js/lib.js"></script>
  <script defer async src="/public/js/shared.js"></script>
  <script defer async src="public/js/insert-song.js"></script>
</body>

</html>