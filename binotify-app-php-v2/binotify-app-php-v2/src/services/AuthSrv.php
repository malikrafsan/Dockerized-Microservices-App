<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseSrv.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/UserRepository.php";
require_once PROJECT_ROOT_PATH . "/src/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/src/exceptions/BadRequestException.php";
require_once PROJECT_ROOT_PATH . "/src/services/UserSrv.php";


class AuthSrv extends BaseSrv {
  protected static $instance;
  private $userSrv;

  private function __construct()
  {
    parent::__construct();
    $this->userSrv = UserSrv::getInstance();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function isAdmin() {
    return $this->isLogin() && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
  }

  public function isLogin() {
    return isset($_SESSION['user_id']);
  }

  public function register($nama, $username, $email, $password, $confirm_password)
  {
    if ($password !== $confirm_password) {
      throw new BadRequestException("Password and confirm password do not match");
    }

    $userModel = $this->userSrv->create($nama, $username, $email, $password);    
    
    return $userModel;
  }

  public function login($email_uname, $password)
  {
    $user = null;

    $userByEmail = $this->userSrv->getByEmail($email_uname);
    if ($userByEmail && !is_null($userByEmail->get('user_id'))) {
      $user = $userByEmail;
    }

    if (is_null($user)) {
      $userByUsername = $this->userSrv->getByUsername($email_uname);
      if ($userByUsername && !is_null($userByUsername->get('user_id'))) {
        $user = $userByUsername;
      }
    }

    if (is_null($user)) {
      throw new BadRequestException("User not found");
    }

    if (!password_verify($password, $user->get('password'))) {
      throw new BadRequestException("Password not match");
    }

    $_SESSION["user_id"] = $user->get('user_id');
    $_SESSION["isAdmin"] = $user->get('isAdmin');

    return $user;
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['isAdmin']);
  }

  public function getCurrentUser()
  {
    if (!isset($_SESSION['user_id'])) {
      return null;
    }

    return $this->userSrv->getById($_SESSION['user_id']);
  }
}
