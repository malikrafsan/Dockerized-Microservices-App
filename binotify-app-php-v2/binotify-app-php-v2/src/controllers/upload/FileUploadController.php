<?php

require_once PROJECT_ROOT_PATH . '/src/bases/BaseController.php';
require_once PROJECT_ROOT_PATH . '/src/utils/FileUploader.php';
require_once PROJECT_ROOT_PATH . '/src/exceptions/BadRequestException.php';

class FileUploadController extends BaseController {
  protected static $instance;
  protected $srv;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        FileUploader::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

    $fileUploader = FileUploader::getInstance();
    $path = $fileUploader->upload($_FILES['file']);
    $isSuccess = $path !== false;

    if (!$isSuccess) {
      throw new BadRequestException("Failed to upload file");
    }

    $response = new BaseResponse(true, $path, "successfully uploaded file", 200);
    return $response->toJSON();
  }
}
