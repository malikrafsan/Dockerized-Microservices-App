<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseController.php";
require_once PROJECT_ROOT_PATH . "/src/services/SubscriptionSrv.php";

class SubscriptionCallbackController extends BaseController{
  protected static $instance;

  private function __construct($srv) {
    parent::__construct($srv);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        SubscriptionSrv::getInstance()
      );
    }
    return self::$instance;
  }

  public function post($urlParams) {
    
    $creatorId = $_POST['creator_id'];
    $subscriberId = $_POST['subscriber_id'];
    $status = $_POST['status'];

    

    return $this->srv->saveOrUpdate($creatorId, $subscriberId, $status);
  }
}
