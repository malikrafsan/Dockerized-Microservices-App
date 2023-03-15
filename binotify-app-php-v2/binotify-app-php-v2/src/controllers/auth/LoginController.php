<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

class LoginController extends BaseController {
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        AuthSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams)
  {
    $email_uname = $_POST['email_uname'];
    $password = $_POST['password'];

    $user = $this->srv->login($email_uname, $password);
    $response = new BaseResponse(true, $user->toResponse(), "successfully logged in", 200);

    return $response->toJSON();
  }
}
