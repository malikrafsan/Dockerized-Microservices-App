<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/SubscriptionSrv.php";

class SubscriptionController extends BaseController {
  protected static $instance;

  private function __construct($srv)
  {
    parent::__construct($srv);
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        SubscriptionSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams) {
    
    $creatorId = $_POST['creator_id'];
    $subscriberId = $_SESSION['user_id'];

    

    return $this->srv->subscribe($creatorId, $subscriberId);
  }
}
