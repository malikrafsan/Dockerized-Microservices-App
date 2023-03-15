<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseRepository.php";
require_once PROJECT_ROOT_PATH . "/src/models/SongModel.php";

class SongRepository extends BaseRepository {
  protected static $instance;
  protected $tableName = 'song';
  
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

  public function getAll() {
    return $this->findAll();
  }

  public function getById($song_id) {
    return $this->findOne(['song_id' => [$song_id, PDO::PARAM_INT]]);
  }

  public function getAllGenres() {
    $sql = "SELECT DISTINCT genre FROM song";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  public function setNullAlbumId($song_id) {
    $sql = "UPDATE song SET album_id = null WHERE song_id = :song_id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':song_id', $song_id);
    $stmt->execute();
    return true;
  }
}
