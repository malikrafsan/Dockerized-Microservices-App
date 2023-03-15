<?php 

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";

class AlbumController extends BaseController {
  protected static $instance;

  private function __construct($srv) {
    parent::__construct($srv);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        AlbumSrv::getInstance()
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

    $albums = $this->srv->getAll($judul, $genre, $sort, $pageNo, $pageSize);
    $responseAlbums = array_map(function($album) {
      return $album->toResponse();
    }, $albums);
    $response = new BaseResponse(true, $responseAlbums, "successfully retrieved albums", 200);

    return $response->toJSON();
  }
}
