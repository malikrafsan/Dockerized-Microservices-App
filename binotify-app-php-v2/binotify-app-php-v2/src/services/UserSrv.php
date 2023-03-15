<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseSrv.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/UserRepository.php";
require_once PROJECT_ROOT_PATH . "/src/models/UserModel.php";
require_once PROJECT_ROOT_PATH . "/src/exceptions/BadRequestException.php";

class UserSrv extends BaseSrv
{
  protected static $instance;

  private function __construct($repository)
  {
    parent::__construct();
    $this->repository = $repository;
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        UserRepository::getInstance()
      );
    }
    return self::$instance;
  }

  public function getAllUser()
  {
    $usersSQL = $this->repository->findAll();
    $users = [];
    foreach ($usersSQL as $userSQL) {
      $user = new UserModel();
      $users[] = $user->constructFromArray($userSQL);
    }
    return $users;
  }

  public function register($nama, $username, $email, $password, $confirm_password)
  {
    if ($password !== $confirm_password) {
      throw new BadRequestException("Password and confirm password do not match");
    }

    $user = (new UserModel())->set('nama', $nama)->set('username', $username)->set('email', $email)->set('password', password_hash($password, PASSWORD_DEFAULT));

    $id = $this->repository->insert($user, array(
      'nama' => PDO::PARAM_STR,
      'username' => PDO::PARAM_STR,
      'email' => PDO::PARAM_STR,
      'password' => PDO::PARAM_STR,
    ));
    $sqlRes = $this->repository->getById($id);
    $user = new UserModel();

    return $user->constructFromArray($sqlRes);
  }

  public function login($email_uname, $password)
  {
    $user = null;

    $userByEmail = $this->getByEmail($email_uname);
    if ($userByEmail && !is_null($userByEmail->get('user_id'))) {
      $user = $userByEmail;
    }

    if (is_null($user)) {
      $userByUsername = $this->getByUsername($email_uname);
      if ($userByUsername && !is_null($userByUsername->get('user_id'))) {
        $user = $userByUsername;
      }
    }

    if (is_null($user)) {
      throw new BadRequestException("User not found");
    }

    if (!password_verify($password, $user->get('password'))) {
      throw new BadRequestException("Password do not match");
    }

    $_SESSION["user_id"] = $user->get('user_id');
    $_SESSION["isAdmin"] = $user->get('isAdmin');

    return $user;
  }

  public function create($nama, $username, $email, $password)
  {
    $user = (new UserModel())->set('nama', $nama)->set('username', $username)->set('email', $email)->set('password', password_hash($password, PASSWORD_DEFAULT));

    $id = $this->repository->insert($user, array(
      'nama' => PDO::PARAM_STR,
      'username' => PDO::PARAM_STR,
      'email' => PDO::PARAM_STR,
      'password' => PDO::PARAM_STR,
    ));
    $sqlRes = $this->repository->getById($id);
    $user = new UserModel();
    $userArray = $user->constructFromArray($sqlRes);

    $_SESSION["user_id"] = $userArray->user_id;
    $_SESSION["isAdmin"] = $userArray->isAdmin;

    return $userArray;
  }

  public function getByEmail($email)
  {
    $user = new UserModel();
    $sqlRes = $this->repository->getByEmail($email);
    if ($sqlRes) {
      $user->constructFromArray($sqlRes);
    }

    return $user;
  }

  public function getByUsername($username)
  {
    $user = new UserModel();
    $sqlRes = $this->repository->getByUsername($username);
    if ($sqlRes) {
      $user->constructFromArray($sqlRes);
    }

    return $user;
  }

  public function isUsernameExist($username)
  {
    $user = $this->getByUsername($username);
    return !is_null($user->get('user_id'));
  }

  public function isEmailExist($email)
  {
    $user = $this->getByEmail($email);
    return !is_null($user->get('user_id'));
  }

  public function getById($id) {
    $user = $this->repository->getById($id);
    if (!$user) {
      return null;
    }

    $userModel = new UserModel();
    $userModel->constructFromArray($user);

    return $userModel;
  }
}
