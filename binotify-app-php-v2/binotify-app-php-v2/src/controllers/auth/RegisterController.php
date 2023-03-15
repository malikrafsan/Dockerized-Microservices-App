<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/AuthSrv.php";

class RegisterController extends BaseController
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
        AuthSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams)
  {
    $name = $_POST["nama"];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    $user = $this->srv->register($name, $username, $email, $password, $confirm_password);
    $response = new BaseResponse(true, $user->toResponse(), "successfully inserted", 200);

    return $response->toJSON();
  }
}
