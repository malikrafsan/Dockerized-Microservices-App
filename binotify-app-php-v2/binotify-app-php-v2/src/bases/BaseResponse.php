<?php

class BaseResponse {
  public $success;
  public $data;
  public $message;
  public $statusCode;

  public function __construct($success, $data, $message, $statusCode)
  {
    $this->success = $success;
    $this->data = $data;
    $this->message = $message;
    $this->statusCode = $statusCode;
  }

  public function toJSON() {
    return json_encode($this);
  }
}
