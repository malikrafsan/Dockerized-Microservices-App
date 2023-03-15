<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/utils/FileUploader.php";
require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";
require_once PROJECT_ROOT_PATH . "/src/services/SongSrv.php";

class DetailAlbumController extends BaseController {
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        AlbumSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function put($urlParams)
  {
    parse_str(file_get_contents('php://input'), $_PUT);

    $album_id = $urlParams[0];
    $judul = $_PUT['judul'];
    $penyanyi = $_PUT['penyanyi'];
    $genre = $_PUT['genre'];
    $tanggal_terbit = $_PUT['tanggal_terbit'];
    $image_path = $_PUT['image_path'];
    $updateSongId = $_PUT['update_song_id'];
    $updateAlbumId = $_PUT['update_album_id'];

    
    Logger::debug(json_encode($_PUT));
    Logger::debug(json_encode($_FILES));

    if ($updateAlbumId == -1) {
      SongSrv::getInstance()->setNullAlbumId($updateSongId);
      $updateAlbumId = null;
    }
    
    $res = $this->srv->update($album_id, $judul, $penyanyi, $genre, $tanggal_terbit, $image_path);

    if (isset($updateSongId) && isset($updateAlbumId)) {
      $updatedSong = SongSrv::getInstance()->moveSong($updateSongId, $updateAlbumId);
      $res = [
        'album' => $res,
        'updated_song' => $updatedSong
      ];
    }

    $response = new BaseResponse(true, $res, "successfully retrieved albums", 200);

    return $response->toJSON();
  }

  public function delete($urlParams) {
    $album_id = $urlParams[0];

    $res = $this->srv->delete($album_id);
    $response = new BaseResponse(true, $res, "successfully deleted album", 200);
    return $response->toJSON();
  }
}
