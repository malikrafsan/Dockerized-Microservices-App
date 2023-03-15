<?php

require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

function UserProfile()
{
  $authSrv = AuthSrv::getInstance();
  $curUser = $authSrv->getCurrentUser();
  $nama = $curUser ? $curUser->get('nama') : "Please Login";

  $dropdownProfileContent = <<<"EOT"
  <a href="/login">
    <div class="dropdown-profile-item-navbar">
      Login
    </div>
  </a>
  EOT;

  if ($curUser) {
    $dropdownProfileContent = <<<"EOT"
    <a href="/logout">
      <div class="dropdown-profile-item-navbar">
        Logout
      </div>
    </a>
    EOT;
  }

  $html = <<<"EOF"
    <div class="user-profile d-flex justify-content-between align-items-center position-relative ml-auto"> 
      <div class="d-flex justify-content-start align-items-center">
        <div class="img-container profile-icon-navbar mr-2">
          <img src="/public/assets/icons/users-filled.svg" alt="" />
        </div>
        <div class="user-data">
          {$nama}
        </div>
      </div>
      <div class="dropdown-profile-navbar img-container d-flex justify-content-center align-items-center">
        <img src="/public/assets/icons/caret-down.svg" alt="" />
      </div>
      <div class="dropdown-profile-content-navbar position-absolute">
        $dropdownProfileContent
      </div>
    </div>
  EOF;

  return $html;
}
