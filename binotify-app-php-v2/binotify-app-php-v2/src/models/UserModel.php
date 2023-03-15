<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseModel.php";

class UserModel extends BaseModel {
  public $user_id;
  public $email;
  public $password;
  public $isAdmin;
  public $username;

  public function __construct() {
    $this->_primary_key = 'user_id';
    return $this;
  }

  public function constructFromArray($array) {
    $this->user_id = $array['user_id'];
    $this->nama = $array['nama'];
    $this->email = $array['email'];
    $this->password = $array['password'];
    $this->isAdmin = $array['isAdmin'];
    $this->username = $array['username'];
    return $this;
  }

  public function toResponse() {
    return array(
      'user_id' => $this->user_id,
      'nama' => $this->nama,
      'email' => $this->email,
      'username' => $this->username,
      'isAdmin' => $this->isAdmin,
    );
  }
}
