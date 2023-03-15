<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";
require_once PROJECT_ROOT_PATH . "/src/bases/BaseResponse.php";

class CheckUsernameController extends BaseController {
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

  public function post($urlParams) {
    $username = $_POST['username'];
    $user = $this->srv->isUsernameExist($username);
    $response = new BaseResponse(true, $user, "successfully checked", 200);
    return $response->toJSON();
  }
}
