<?php

require_once PROJECT_ROOT_PATH . "/src/models/SongModel.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Helper.php";

function SongList($song, $idx)
{
  $songId = $song->get("song_id");
  $judul = $song->get('judul');
  $penyanyi = $song->get('penyanyi');
  $duration = $song->get('duration');

  $duration = Helper::formatDuration($duration);

  $html = <<<"EOT"
  <div class="d-flex align-items-center">
    <a href="/song/$songId" class="song-list-item song-list-item-clickable d-flex align-items-center flex-grow-1">
      <div class="song-list-item-index">
        $idx
      </div>
      <div class="song-list-item-body">
        <div class="song-list-item-title">
          $judul
        </div>
        <div class="song-list-item-artist">
          $penyanyi
        </div>
      </div>
      <div class="song-list-item-duration">
        $duration
      </div>
    </a>
    <div class="song-list-delete-btn-container" hidden>
      <div class="d-flex justify-content-center align-items-center img-container m-auto" onclick="((e) => onDeleteSong($songId))()">
        <img src="/public/assets/icons/trash.svg" alt="" />
      </div>
    </div>
  </div>

  EOT;

  return $html;
}
