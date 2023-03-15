<?php

function PremiumSongList($song, $idx)
{
 
  $songId = $song->song_id;
  $judul = $song->judul;

  $audio_path = $song->audio_path;

  $html = <<<"EOT"
  <div>
    <div class="song-list-item song-list-item-clickable d-flex align-items-center flex-grow-1" id="$audio_path">
      <div class="song-list-item-index">
        $idx
      </div>
      <div class="song-list-item-body">
        <div class="song-list-item-title">
          $judul
        </div>
      </div>
      <div class="song-list-icon-play img-container" onclick="onPlay('$judul', '$audio_path', '$songId')">
      <img src="/public/assets/play-icon.svg" alt="" />
      </div>
    </div>
  </div>

  EOT;

  return $html;
}
