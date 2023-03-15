<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SubscriptionSrv.php";
require_once PROJECT_ROOT_PATH . "/src/clients/BinotifyRestClient.php";

class PremiumSongController extends BaseController
{
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        null
      );
    }
    return self::$instance;
  }

  public function get($urlParams)
  {
    $user_id = $_SESSION['user_id'];
    $creator_id = $_GET['creator_id'];

    

    $premiumSongs = BinotifyRestClient::getPremiumSong($user_id, $creator_id);

    

    return $premiumSongs;
  }
}
