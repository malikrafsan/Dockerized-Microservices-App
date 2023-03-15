<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseSrv.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/SongRepository.php";
require_once PROJECT_ROOT_PATH . "/src/models/SongModel.php";

class SongSrv extends BaseSrv {
  protected static $instance;
  protected $repository;

  private function __construct($repository)
  {
    parent::__construct();
    $this->repository = $repository;
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        SongRepository::getInstance()
      );
    }
    return self::$instance;
  }

  public function countRow($judul, $genre) {
    $where = [];
    if ($judul) {
      $where['judul'] = [$judul, PDO::PARAM_STR, 'LIKE'];
    }
    if ($genre) {
      $where['genre'] = [$genre, PDO::PARAM_STR];
    }
    return $this->repository->countRow($where);
  }

  public function getAll($judul, $genre, $sort, $pageNo, $pageSize, $isDesc = false) {
    $where = [];
    if ($judul) {
      $where['judul'] = [$judul, PDO::PARAM_STR, 'LIKE'];
    }
    if ($genre) {
      $where['genre'] = [$genre, PDO::PARAM_STR];
    }

    $songsSQL = $this->repository->findAll($where, $sort, $pageNo, $pageSize, $isDesc);

    $songs = [];
    foreach ($songsSQL as $songSQL) {
      $song = new SongModel();
      $songs[] = $song->constructFromArray($songSQL);
    }
    return $songs;
  }

  public function create($judul, $penyanyi, $genre, $duration, $audio_path, $image_path, $album_id, $tanggal_terbit)
  {
    $song = new SongModel();
    $song->set('judul', $judul);
    $song->set('penyanyi', $penyanyi);
    $song->set('genre', $genre);
    $song->set('duration', $duration);
    $song->set('audio_path', $audio_path);
    $song->set('image_path', $image_path);
    $song->set('album_id', $album_id);
    $song->set('tanggal_terbit', $tanggal_terbit);


    $lastId = $this->repository->insert($song, array(
      'judul' => PDO::PARAM_STR,
      'penyanyi' => PDO::PARAM_STR,
      'genre' => PDO::PARAM_STR,
      'duration' => PDO::PARAM_INT,
      'audio_path' => PDO::PARAM_STR,
      'image_path' => PDO::PARAM_STR,
      'album_id' => PDO::PARAM_INT,
      'tanggal_terbit' => PDO::PARAM_STR,
    ));
    $songSQL = $this->repository->getById($lastId);
    $resSong = new SongModel();
    $resSong->constructFromArray($songSQL);

    return $resSong;
  }

  public function update($song_id, $judul, $penyanyi, $tanggal_terbit, $genre, $duration, $audio_path, $image_path, $album_id){
    $model = $this->getById($song_id);
    $model->set('judul', $judul);
    $model->set('penyanyi', $penyanyi);
    $model->set('tanggal_terbit', $tanggal_terbit);
    $model->set('genre', $genre);
    $model->set('duration', $duration);
    $model->set('audio_path', $audio_path);
    $model->set('image_path', $image_path);
    $model->set('album_id', $album_id);
    
    $this->repository->update($model, array(
      'judul' => PDO::PARAM_STR,
      'penyanyi' => PDO::PARAM_STR,
      'tanggal_terbit' => PDO::PARAM_STR,
      'genre' => PDO::PARAM_STR,
      'duration' => PDO::PARAM_INT,
      'audio_path' => PDO::PARAM_STR,
      'image_path' => PDO::PARAM_STR,
      'album_id' => PDO::PARAM_INT,
    ), array(
      'song_id' => PDO::PARAM_INT,
    ));

    $model = $this->getById($song_id);
    return $model;
  }

  public function getAllGenres() {
    return $this->repository->getAllGenres();
  }

  public function getById($id) {
    $songSQL = $this->repository->getById($id);
    $song = new SongModel();
    return $song->constructFromArray($songSQL);
  }

  public function getNLastSongs($N) {
    $songsSQL = $this->repository->getNLastRow($N);
    $songs = [];
    foreach ($songsSQL as $songSQL) {
      $song = new SongModel();
      $songs[] = $song->constructFromArray($songSQL);
    }
    return $songs;
  }

  public function delete($song_id) {
    $model = new SongModel();
    $model->set('song_id', $song_id);
    return $this->repository->delete($model);
  }

  public function moveSong($song_id, $album_id)
  {
    $song = $this->getById($song_id);
    if (!$song) {
      throw new BadRequestException("Song not found");
    }

    $song->set('album_id', $album_id);
    $this->repository->update($song, array(
      'album_id' => PDO::PARAM_INT,
    ));
    $song = $this->getById($song_id);
    return $song;
  }

  public function setNullAlbumId($song_id) {
    return $this->repository->setNullAlbumId($song_id);
  }
}
