<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseModel.php";

class AlbumModel extends BaseModel {
  public $album_id;
  public $judul;
  public $penyanyi;
  public $total_duration;
  public $image_path;
  public $tanggal_terbit;
  public $genre;
  public $songs;

  public function __construct() {
    $this->_primary_key = 'album_id';
    return $this;
  }

  public function constructFromArray($array) {
    $this->album_id = $array['album_id'];
    $this->judul = $array['judul'];
    $this->penyanyi = $array['penyanyi'];
    $this->total_duration = $array['total_duration'];
    $this->image_path = $array['image_path'];
    $this->tanggal_terbit = $array['tanggal_terbit'];
    $this->genre = $array['genre'];
    $this->songs = $array['songs'];
    return $this;
  }

  public function toResponse() {
    return array(
      'album_id' => $this->album_id,
      'judul' => $this->judul,
      'penyanyi' => $this->penyanyi,
      'total_duration' => $this->total_duration,
      'image_path' => $this->image_path,
      'tanggal_terbit' => $this->tanggal_terbit,
      'genre' => $this->genre,
      'songs' => $this->songs,
    );
  }
}
