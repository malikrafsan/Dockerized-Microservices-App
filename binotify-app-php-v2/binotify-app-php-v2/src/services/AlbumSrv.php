<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseSrv.php";
require_once PROJECT_ROOT_PATH . "/src/models/AlbumModel.php";
require_once PROJECT_ROOT_PATH . "/src/models/SongModel.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/AlbumRepository.php";

class AlbumSrv extends BaseSrv {
  protected static $instance;
  protected $repository;

  private function __construct($repo) {
    parent::__construct();
    $this->repository = $repo;
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        AlbumRepository::getInstance()
      );
    }
    return self::$instance;
  }

  public function create($judul, $penyanyi, $total_duration,  $image_path, $genre, $tanggal_terbit)
  {
    $album = new AlbumModel();
    $album->set('judul', $judul);
    $album->set('penyanyi', $penyanyi);
    $album->set('total_duration', $total_duration);
    $album->set('image_path', $image_path);
    $album->set('genre', $genre);
    $album->set('tanggal_terbit', $tanggal_terbit);

    $lastId = $this->repository->insert($album, array(
      'judul' => PDO::PARAM_STR,
      'penyanyi' => PDO::PARAM_STR,
      'total_duration' => PDO::PARAM_STR,
      'image_path' => PDO::PARAM_STR,
      'genre' => PDO::PARAM_STR,
      'tanggal_terbit' => PDO::PARAM_STR
    ));
    $albumSQL = $this->repository->getById($lastId);
    $album = new AlbumModel();
    return $album->constructFromArray($albumSQL);
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

  public function getAllAlbums($where = [])
  {
    $albumsSQL = $this->repository->findAll($where);
    $albums = [];
    foreach ($albumsSQL as $albumSQL) {
      $album = new AlbumModel();
      $albums[] = $album->constructFromArray($albumSQL);
    }

    return $albums;
  }

  public function getAll($judul, $genre, $order, $pageNo, $pageSize, $isDesc = false) {
    $where = [];
    if ($judul) {
      $where['judul'] = [$judul, PDO::PARAM_STR, 'LIKE'];
    }
    if ($genre) {
      $where['genre'] = [$genre, PDO::PARAM_STR];
    }

    $albumsSQL = $this->repository->findAll($where, $order, $pageNo, $pageSize, $isDesc);

    $albums = [];
    foreach ($albumsSQL as $albumSQL) {
      $album = new AlbumModel();
      $albums[] = $album->constructFromArray($albumSQL);
    }

    return $albums;
  }

  public function populateSongsFromAlbums($albumModel) {
    $songs = $this->repository->getAllSongsFromAlbum($albumModel->get('album_id'));
    $songModels = array_map(function($song) {
      $songModel = new SongModel();
      return $songModel->constructFromArray($song);
    }, $songs);

    $albumModel->set('songs', $songModels);
    return $albumModel;
  }

  public function getAllGenres() {
    return $this->repository->getAllGenres();
  }

  public function getById($id) {
    $albumSQL = $this->repository->getById($id);
    $album = new AlbumModel();
    return $album->constructFromArray($albumSQL);
  }

  public function update($album_id, $judul, $penyanyi, $genre, $tanggal_terbit, $image_path) {
    $model = $this->getById($album_id);
    $model->set('judul', $judul);
    $model->set('penyanyi', $penyanyi);
    $model->set('genre', $genre);
    $model->set('tanggal_terbit', $tanggal_terbit);
    $model->set('image_path', $image_path);

    $this->repository->update($model, array(
      'judul' => PDO::PARAM_STR,
      'penyanyi' => PDO::PARAM_STR,
      'genre' => PDO::PARAM_STR,
      'tanggal_terbit' => PDO::PARAM_STR,
      'image_path' => PDO::PARAM_STR,
    ), array(
      'album_id' => PDO::PARAM_INT,
    ));

    $model = $this->getById($album_id);
    return $model;
  }

  public function delete($album_id) {
    $model = $this->getById($album_id);
    $model = $this->populateSongsFromAlbums($model);
    
    $songs = $model->get('songs');
    
    foreach ($songs as $song) {
      SongSrv::getInstance()->moveSong($song->get('song_id'), null);
    }
    return $this->repository->delete($model);
  }

  public function fetchAll() {
    $albumsSQL = $this->repository->getAll();
    $albums = [];
    foreach ($albumsSQL as $albumSQL) {
      $album = new AlbumModel();
      $albums[] = $album->constructFromArray($albumSQL);
    }

    return $albums;
  }

  public function getAllColumnWithFilter($filter = []) {

  }
}

