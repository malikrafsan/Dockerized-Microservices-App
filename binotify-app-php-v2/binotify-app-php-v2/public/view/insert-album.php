<?php
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/Navbar.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";

if (!AuthSrv::getInstance()->isAdmin()) {
  header("Location: /");
  exit();
}

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
  <title>Insert New Album - SoundClown</title>
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
        <h1>Insert New Album</h1>

        <div class="form-container">
          <form onsubmit="submitForm(event)">
            <div class="form-section">
              <label for="song-title">Album Title</label> <br>
              <input type="text" name="song-title" placeholder="The title of the album" id="input-song-title" required>
            </div>

            <div class="form-section">
              <label for="song-artist">Artist</label> <br>
              <input type="text" name="song-artist" placeholder="The artist of the album" id="input-song-artist" required>
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
              <label>Insert album cover picture</label> <br>
              <input type="file" name="file-song" id="input-file-cover" accept="image/*" required>
            </div>

            <div class="form-section-submit">
              <input type="submit" value="Register Album" id="submit-button">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script defer async src="public/js/lib.js"></script>
  <script defer async src="/public/js/shared.js"></script>
  <script defer async src="public/js/insert-album.js"></script>
</body>

</html>