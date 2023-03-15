<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";

class CreateSongController extends BaseController {
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

  public function post($urlParams) {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $penyanyi = $_POST['penyanyi'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $audio_path = $_POST['audio_path'];
    $image_path = $_POST['image_path'];
    $album_id = $_POST['album_id'];

    $song = $this->srv->create($judul, $penyanyi, $genre, $duration, $audio_path, $image_path, $album_id, $tanggal_terbit);
    $response = new BaseResponse(true, $song, "successfully created song", 200);

    return $response->toJSON();
  }
}
