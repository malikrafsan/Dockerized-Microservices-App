<?php

require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SubscriptionSrv.php";
require_once PROJECT_ROOT_PATH . "/public/components/Sidebar.php";
require_once PROJECT_ROOT_PATH . "/public/components/SongCard.php";
require_once PROJECT_ROOT_PATH . "/public/components/PremiumArtistList.php";
require_once PROJECT_ROOT_PATH . "/public/components/SidebarControl.php";
require_once PROJECT_ROOT_PATH . "/public/components/UserProfile.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Helper.php";
require_once PROJECT_ROOT_PATH . "/src/clients/BinotifyRestClient.php";

header("Cache-Control: public, max-age=0, stale-while-revalidate=300");

$user_id = $_SESSION['user_id'];

if (is_null($user_id)) {
  header("Location: /");
}

$users = SubscriptionSrv::getInstance()->getPremiumArtist();


$userList = implode("", array_map(function ($user, $idx) {
  return PremiumArtistList($user, $idx + 1);
}, $users, array_keys($users)));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/public/css/lib.css">
  <link rel="stylesheet" href="/public/css/shared.css">
  <link rel="stylesheet" href="/public/css/premium-artists.css">
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
        <div class="premium-artists-top-container d-block d-sm-flex align-items-end px-3 pb-3 px-md-4 pb-md-4 pt-5 pl-5">
          <div class="premium-artists-info">
            <br>
            <div class="premium-artists-info-name font-weight-bold">
              PREMIUM ARTISTS
            </div>
          </div>
        </div>
        <div class="premium-artists-bottom-container">
          <div class="d-flex align-items-center">
            <div class="premium-artists-header-artist-list artist-list-item d-flex align-items-center mb-3 mt-3 flex-grow-1">
              <div class="artist-list-item-index">
                #
              </div>
              <div class="artist-list-item-body">
                TITLE
              </div>
              <div class="artist-list-item-subs d-flex justify-content-center align-items-center">
                SUBSCRIBE
              </div>
            </div>
          </div>
          <?php echo $userList ?>
        </div>
      </div>
    </div>
    <script defer async src="/public/js/lib.js"></script>
    <script defer async src="/public/js/shared.js"></script>
    <script defer async src="/public/js/randombgcolor.js"></script>
    <script defer async src="/public/js/subscription.js"></script>
  </div>
</body>

</html>