<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseModel.php";

class SongModel extends BaseModel
{
  public $song_id;
  public $judul;
  public $penyanyi;
  public $tanggal_terbit;
  public $genre;
  public $duration;
  public $audio_path;
  public $image_path;
  public $album_id;

  public function __construct()
  {
    $this->_primary_key = 'song_id';
    return $this;
  }

  public function constructFromArray($array) {
    $this->song_id = $array['song_id'];
    $this->judul = $array['judul'];
    $this->penyanyi = $array['penyanyi'];
    $this->tanggal_terbit = $array['tanggal_terbit'];
    $this->genre = $array['genre'];
    $this->duration = $array['duration'];
    $this->audio_path = $array['audio_path'];
    $this->image_path = $array['image_path'];
    $this->album_id = $array['album_id'];
    return $this;
  }

  public function toResponse()
  {
    return array(
      'song_id' => $this->song_id,
      'judul' => $this->judul,
      'penyanyi' => $this->penyanyi,
      'tanggal_terbit' => $this->tanggal_terbit,
      'genre' => $this->genre,
      'duration' => $this->duration,
      'audio_path' => $this->audio_path,
      'image_path' => $this->image_path,
      'album_id' => $this->album_id,
    );
  }
}
