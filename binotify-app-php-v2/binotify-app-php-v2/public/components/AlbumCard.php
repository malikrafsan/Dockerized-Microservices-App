<?php

require_once PROJECT_ROOT_PATH . '/src/models/AlbumModel.php';
require_once PROJECT_ROOT_PATH . '/src/utils/Helper.php';

function AlbumCard($album)
{
  $albumId = $album->get('album_id');
  $judul = $album->get('judul');
  $penyanyi = $album->get('penyanyi');
  $tanggalTerbit = $album->get('tanggal_terbit');
  $genre = $album->get('genre');
  $totalDuration = $album->get('total_duration');
  $image_path = $album->get('image_path');
  $image_path = $image_path ? $image_path : '/public/assets/cover-default.jpg';

  $yearReleased = Helper::getYearFromDate($tanggalTerbit);
  $totalDuration = Helper::formatDuration($totalDuration);

  $html = <<<"EOT"
  <a href="/album/$albumId" class="album-card position-relative">
    <div class="album-card-cover img-container mb-3 position-relative">
      <img src="$image_path" alt="$judul cover" />
      <div class="album-card-duration position-absolute">
        $totalDuration
      </div>
      <div class="album-card-genre position-absolute">
        $genre
      </div>
    </div>
    <div class="album-card-info">
      <div class="album-card-info-top">
        <div class="album-card-title font-weight-bold">
          $judul
        </div>
      </div>
      <div class="album-card-info-bottom d-flex">
        <div class="album-card-release-date">
          $yearReleased
        </div>
        <div class="mx-2">•</div>
        <div class="album-card-artist">
          By $penyanyi
        </div>
      </div>
    </div>
  </a>
  EOT;

  return $html;
}
