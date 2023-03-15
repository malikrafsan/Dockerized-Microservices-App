<?php

require_once PROJECT_ROOT_PATH . '/src/models/SongModel.php';
require_once PROJECT_ROOT_PATH . '/src/utils/Helper.php';

function SongCard($song)
{
  $songId = $song->get('song_id');
  $judul = $song->get('judul');
  $penyanyi = $song->get('penyanyi');
  $tanggalTerbit = $song->get('tanggal_terbit');
  $genre = $song->get('genre');
  $duration = $song->get('duration');
  $image_path = $song->get('image_path');
  $image_path = $image_path ? $image_path : '/public/assets/cover-default.jpg';

  $yearReleased = Helper::getYearFromDate($tanggalTerbit);
  $duration = Helper::formatDuration($duration);

  $html = <<<"EOT"
  <a href="/song/$songId" class="song-card position-relative">
    <div class="song-card-cover img-container mx-auto mb-3 position-relative">
      <img src="$image_path" alt="$judul cover" />
      <div class="song-card-duration position-absolute">
        $duration
      </div>
      <div class="song-card-genre position-absolute">
        $genre
      </div>
    </div>
    <div class="song-card-info">
      <div class="song-card-info-top">
        <div class="song-card-title font-weight-bold">
          $judul
        </div>
      </div>
      <div class="song-card-info-bottom d-flex">
        <div class="song-card-release-date">
          $yearReleased
        </div>
        <div class="mx-2">•</div>
        <div class="song-card-artist">
          By $penyanyi
        </div>
      </div>
    </div>
    <div class="song-card-icon-play img-container position-absolute">
      <img src="/public/assets/play-icon.svg" alt="" />
    </div>
  </a>

  EOT;

  return $html;
}
