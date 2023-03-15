<?php

require_once PROJECT_ROOT_PATH . "/src/exceptions/BadRequestException.php";

class CheckLogin {
  private static $instance;

  private function __construct() {}

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function __invoke($path, $method) {
    if (!isset($_SESSION['user_id'])) {
      throw new BadRequestException("You must login first");
    }
    return true;
  }
}
