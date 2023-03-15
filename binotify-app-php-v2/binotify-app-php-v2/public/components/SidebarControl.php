<?php

function SidebarControl() {
  $html = <<<"EOT"
    <div class="hamburger-bars-container d-flex justify-content-center align-items-center d-md-none img-container mr-3">
      <img src="/public/assets/icons/hamburger-bars.svg" alt="open sidebar" onclick="onOpenSidebar()" class="open-sidebar-btn" />
    </div>
  EOT;

  return $html;
}
