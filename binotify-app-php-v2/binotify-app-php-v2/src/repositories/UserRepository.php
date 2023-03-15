<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseRepository.php";

class UserRepository extends BaseRepository {
  protected static $instance;
  protected $tableName = 'user';

  private function __construct()
  {
    parent::__construct();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function getById($user_id) {
    return $this->findOne(['user_id' => [$user_id, PDO::PARAM_INT]]);
  }

  public function getByEmail($email) {
    return $this->findOne(['email' => [$email, PDO::PARAM_STR]]);
  }
  public function getByUsername($username) {
    return $this->findOne(['username' => [$username, PDO::PARAM_STR]]);
  }
}
