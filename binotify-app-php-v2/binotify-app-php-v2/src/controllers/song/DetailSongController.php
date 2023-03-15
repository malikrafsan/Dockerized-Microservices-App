<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/utils/FileUploader.php";
require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";

class DetailSongController extends BaseController {
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

  public function put($urlParams)
  {
    parse_str(file_get_contents('php://input'), $_PUT);

    $song_id = $urlParams[0];
    $judul = $_PUT['judul'];
    $penyanyi = $_PUT['penyanyi'];
    $tanggal_terbit = $_PUT['tanggal_terbit'];
    $genre = $_PUT['genre'];
    $duration = $_PUT['duration'];
    $audio_path = $_PUT['audio_path'];
    $image_path = $_PUT['image_path'];
    $album_id = $_PUT['album_id'];

    
    Logger::debug(json_encode($_PUT));
    Logger::debug(json_encode($_FILES));

    if ($album_id == -1) {
      $this->srv->setNullAlbumId($song_id);
      $album_id = null;
    }

    $res = $this->srv->update($song_id, $judul, $penyanyi, $tanggal_terbit, $genre, $duration, $audio_path, $image_path, $album_id);

    $response = new BaseResponse(true, $res, "successfully retrieved song", 200);

    return $response->toJSON();
  }

  public function delete($urlParams) {
    $song_id = $urlParams[0];

    $res = $this->srv->delete($song_id);
    $response = new BaseResponse(true, $res, "successfully deleted song", 200);
    return $response->toJSON();
  }
}
