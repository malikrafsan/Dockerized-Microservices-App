<?php

require_once PROJECT_ROOT_PATH . "/src/exceptions/BadRequestException.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

class CheckAdmin {
  private static $instance;

  private function __construct() {}

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function __invoke($path, $method) {
    $isAdmin = AuthSrv::getInstance()->isAdmin();
    if (!$isAdmin) {
      throw new BadRequestException("You must be admin to access this page");
    }

    return true;
  }
}
