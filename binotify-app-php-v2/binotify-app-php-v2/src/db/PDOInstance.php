<?php

class PDOInstance {
  private static $instance;
  private $pdo;

  private function __construct()
  {
    $DB_HOST = $_ENV['DB_HOST'] ? $_ENV['DB_HOST'] :"db";
    $DB_USERNAME = $_ENV['MYSQL_USER'];
    $DB_PASSWORD = $_ENV['MYSQL_PASSWORD'];
    $DB_NAME = $_ENV['MYSQL_DATABASE'];

    try {
      $this->pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("ERROR: Could not connect. " . $e . " >>>");
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new PDOInstance();
    }
    return self::$instance;
  }

  public function __destruct() {
    $this->pdo = null;
  }

  public function getPDO()
  {
    return $this->pdo;
  }
}
