<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";

class CheckHealthController extends BaseController
{
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        null
      );
    }
    return self::$instance;
  }

  public function post($urlParams)
  {
    
    return json_encode($_POST);
  }

  public function get($urlParams) {
    return "OK";
  }
}
