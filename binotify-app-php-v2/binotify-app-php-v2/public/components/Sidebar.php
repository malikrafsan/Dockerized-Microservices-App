<?php

require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

function SidebarElmt($elmt)
{
  $title = $elmt['title'];
  $url = $elmt['url'];
  $icon = $elmt['icon'];
  $icon_selected = $elmt['icon_selected'];

  $path = $_SERVER["REQUEST_URI"];
  $path = explode("?", $path)[0];
  $isActive = $path == $url;
  $icon = $isActive ? $icon_selected : $icon;
  $classActive = $isActive ? "sidebar-elmt-active" : "";

  $html = <<<"EOT"
  <a href="$url" class="sidebar-elmt $classActive d-flex py-2 px-4 mb-2 align-items-center">
    <div class="sidebar-elmt-icon mr-4 img-container d-flex justify-content-center align-items-center">
      <img src="$icon" alt="$title icon" />
    </div>
    <div class="sidebar-elmt-text">
      $title
    </div>
  </a>
EOT;

  return $html;
}

function Sidebar()
{
  $pages = [
    [
      "title" => "Home",
      "url" => "/",
      "icon" => "/public/assets/icons/Home.svg",
      "icon_selected" => "/public/assets/icons/Home filled.svg"
    ],
    [
      "title" => "Albums",
      "url" => "/albums",
      "icon" => "/public/assets/icons/Library small.svg",
      "icon_selected" => "/public/assets/icons/Library big.svg"
    ],
    [
      "title" => "Search Song",
      "url" => "/search",
      "icon" => "/public/assets/icons/Search small.svg",
      "icon_selected" => "/public/assets/icons/Search Big.svg"
    ],
    [
      "title" => "Premium Artists",
      "url" => "/premium-artists",
      "icon" => "/public/assets/icons/Premium artists small.svg",
      "icon_selected" => "/public/assets/icons/Premium artists big.svg"
    ],
  ];

  if (AuthSrv::getInstance()->isAdmin()) {
    $pagesAdmin = [
    [
      "title" => "Add New Song",
      "url" => "/insert-song",
      "icon" => "/public/assets/icons/Add plus.svg",
      "icon_selected" => "/public/assets/icons/Add plus filled.svg"
    ],
    [
      "title" => "Add New Album",
      "url" => "/insert-album",
      "icon" => "/public/assets/icons/Add plus.svg",
      "icon_selected" => "/public/assets/icons/Add plus filled.svg"
    ],
    [
      "title" => "User List",
      "url" => "/userlist",
      "icon" => "/public/assets/icons/users.svg",
      "icon_selected" => "/public/assets/icons/users-filled.svg"
    ]];
    $pages = array_merge($pages, $pagesAdmin);
  }

  $pagesHtml = implode("", array_map(function ($page) {
    return SidebarElmt($page);
  }, $pages));

  $html = <<<"EOT"
  <div class="sidebar">
    <div class="hamburger-bars-container d-flex justify-content-center align-items-center d-md-none img-container ml-auto mr-4 mt-4">
      <img src="/public/assets/icons/xmark.svg" alt="close sidebar" hidden onclick="onCloseSidebar()" class="close-sidebar-btn" />
    </div>
    <a href="/" class="sidebar-header pt-4 d-flex justify-content-center align-items-center mb-5">
      <div class="sidebar-header-logo img-container mr-2">
        <img src="/public/assets/SoundClownfish.png" alt="logo" />
      </div>
      <div class="sidebar-header-title">
        <p class="font-weight-bold">SoundClown</p>
      </div>
    </a>
    <div class="sidebar-body">
      $pagesHtml
    </div>
  </div>
EOT;

  return $html;
}
