<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/AlbumSrv.php";

class CreateAlbumController extends BaseController
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
        AlbumSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams)
  {
    $judul = $_POST['judul'];
    $genre = $_POST['genre'];
    $total_duration = $_POST['total_duration'];
    $penyanyi = $_POST['penyanyi'];
    $image_path = $_POST['image_path'];
    $tanggal_terbit = $_POST["tanggal_terbit"];

    $album = $this->srv->create($judul, $penyanyi, $total_duration, $image_path, $genre, $tanggal_terbit);
    $response = new BaseResponse(true, $album, "successfully created album", 200);

    return $response->toJSON();
  }
}
