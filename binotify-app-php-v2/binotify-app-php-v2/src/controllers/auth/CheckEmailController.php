<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";
require_once PROJECT_ROOT_PATH . "/src/bases/BaseResponse.php";

class CheckEmailController extends BaseController
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
        UserSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams)
  {
    $email = $_POST['email'];
    $user = $this->srv->isEmailExist($email);
    $response = new BaseResponse(true, $user, "successfully checked", 200);
    return $response->toJSON();
  }
}
