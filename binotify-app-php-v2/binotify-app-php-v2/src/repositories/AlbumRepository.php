<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseRepository.php";

class AlbumRepository extends BaseRepository {
  protected static $instance;
  protected $tableName = 'album';

  private function __construct()
  {
    parent::__construct();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function getById($album_id) {
    return $this->findOne(['album_id' => [$album_id, PDO::PARAM_INT]]);
  }

  public function getAllGenres() {
    $sql = "SELECT DISTINCT genre FROM album";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  public function getAllSongsFromAlbum($album_id) {
    $sql = "SELECT * FROM song WHERE album_id = :album_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':album_id', $album_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
