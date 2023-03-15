<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseModel.php";

class Status {
  const PENDING = "PENDING";
  const ACCEPTED = "ACCEPTED";
  const REJECTED = "REJECTED";

  private $value;

  private function __construct($value) {
    $this->value = $value;
  }

  public static function fromStatusCode($key) {
    switch ($key) {
      case Status::PENDING:
        return new Status(Status::PENDING);
      case Status::ACCEPTED:
        return new Status(Status::ACCEPTED);
      case Status::REJECTED:
        return new Status(Status::REJECTED);
      default:
        throw new Exception("Invalid status code");
    }
  }

  public function toStatusCode() {
    return $this->value;
  }

  public static function isValid($status) {
    return in_array($status, [self::PENDING, self::ACCEPTED, self::REJECTED]);
  }
}

class SubscriptionModel extends BaseModel
{
  public $creator_id;
  public $subscriber_id;
  public $status;

  public function __construct()
  {
    $this->_primary_key = ["creator_id", "subscriber_id"];
    return $this;
  }

  public function constructFromArray($array)
  {
    $this->creator_id = $array["creator_id"];
    $this->subscriber_id = $array["subscriber_id"];
    $this->status = Status::fromStatusCode($array["status"]);
    return $this;
  }

  public function toResponse()
  {
    return array(
      "creator_id" => $this->creator_id,
      "subscriber_id" => $this->subscriber_id,
      "status" => $this->status->toStatusCode(),
    );
  }
}
