<?php

class FileUploader
{
  private static $instance;
  private $targetDir = "/files/";

  private function __construct()
  {
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  private
  function generateRandomString($length = 10)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public function upload($file)
  {
    try {
      Logger::debug(json_encode($file));
      $relativeTarget = $this->targetDir . $this->generateRandomString() . "-" . basename($file['name']);
      $targetFile = PROJECT_ROOT_PATH . $relativeTarget;
      $uploadOk = 1;

      if (file_exists($targetFile)) {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {
        return false;
      }
      if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $relativeTarget;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      throw new Exception("Upload File Error: " . $e->getMessage());
    }
  }
}
