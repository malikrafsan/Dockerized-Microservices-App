<?php

require_once PROJECT_ROOT_PATH . "/src/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/src/utils/Helper.php";

function PremiumArtistList($user, $idx)
{
  $penyanyi_id = $user['creator_id'];
  $penyanyi = $user['name'];
  $status = $user['status'];

  if (!isset($status)) {
    $html = <<<"EOT"
    <div class="artist-list-item d-flex align-items-center d-flex align-items-center">
        <div class
        <div class="artist-list-item-index">
          $idx
        </div>
        <div class="artist-list-item-body">
          <div class="artist-list-item-title">
            $penyanyi
          </div>
        </div>
        <div class="artist-list-item-subscribe">
          <button class="btn btn-primary btn-sm" onclick="((e) => subscribe($penyanyi_id))()">Subscribe</button>
        </div>
    </div>
    EOT;
  } elseif ($status == 'PENDING' || $status == 'REJECTED') {
    $html = <<<"EOT"
    <div class="artist-list-item d-flex align-items-center d-flex align-items-center">
        <div class
        <div class="artist-list-item-index">
          $idx
        </div>
        <div class="artist-list-item-body">
          <div class="artist-list-item-title">
            $penyanyi
          </div>
        </div>
        <div class="artist-list-item">
          $status
        </div>
    </div>
    EOT;
  // ACCEPTED
  } else {
    $html = <<<"EOT"
    <div>
      <a href="/premium-songs/$penyanyi_id" class="artist-list-item artist-list-item-clickable d-flex align-items-center flex-grow-1">
        <div class="artist-list-item-index">
          $idx
        </div>
        <div class="artist-list-item-body">
          <div class="artist-list-item-title">
            $penyanyi
          </div>
        </div>
        <div class="artist-list-item">
          $status
        </div>
      </a>
    </div>
    EOT;
  }

  return $html;
}
