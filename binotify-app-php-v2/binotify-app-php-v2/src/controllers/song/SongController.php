<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";
require_once PROJECT_ROOT_PATH . "/src/bases/BaseResponse.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/SongRepository.php";

class SongController extends BaseController {
  protected static $instance;

  private function __construct($srv) {
    parent::__construct($srv);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        SongSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function get($urlParams) {
    $judul = $_GET['judul'];
    $genre = $_GET['genre'];
    $sort = $_GET['sort'];
    $pageNo = $_GET['pageNo'];
    $pageSize = $_GET['pageSize'];
    $isDesc = $_GET['isDesc'];

    $songs = $this->srv->getAll($judul, $genre, $sort, $pageNo, $pageSize, $isDesc);
    $responseSongs = array_map(function($song) {
      return $song->toResponse();
    }, $songs);
    $response = new BaseResponse(true, $responseSongs, "successfully retrieved songs", 200);

    return $response->toJSON();
  }
}
