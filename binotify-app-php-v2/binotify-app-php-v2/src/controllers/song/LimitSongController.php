<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/bases/BaseResponse.php";

define("TIME_LIMIT", 86400);

class LimitSongController extends BaseController
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
        SongSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function get($urlParams)
  {
    if (!isset($_SESSION['user_id'])) {
      if (!isset($_SESSION['play_timestamps'])) {
        $_SESSION['play_timestamps'] = array();
        $_SESSION['play_timestamps'][] = time();
      } else {
        $new_timestamps = array_filter($_SESSION['play_timestamps'], function ($current_time) {
          return (time() - $current_time) < TIME_LIMIT;
        });
        $_SESSION['play_timestamps'] = $new_timestamps;

        if (count($_SESSION['play_timestamps']) >= 3) {
          throw new BadRequestException("guest play limit reached");
        } else {
          $_SESSION['play_timestamps'][] = time();
        }
      }
    }
    $response = new BaseResponse(true, true, "successfully played songs", 200);

    return $response->toJSON();
  }
}
