<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseSrv.php";
require_once PROJECT_ROOT_PATH . "/src/utils/SoapWrapper.php";
require_once PROJECT_ROOT_PATH . "/src/clients/BinotifySoapClient.php";
require_once PROJECT_ROOT_PATH . "/src/models/SubscriptionModel.php";
require_once PROJECT_ROOT_PATH . "/src/repositories/SubscriptionRepository.php";

class SubscriptionSrv extends BaseSrv {
  protected static $instance;
  private $client;
  
  private function __construct($client) {
    parent::__construct();
    $this->client = $client;
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static(
        BinotifySoapClient::getInstance()
      );
    }
    return self::$instance;
  }

  public function getAcceptedSubscriptionsBySubcriberId($subscriberId) {
    $subsSQL = SubscriptionRepository::getInstance()->getAcceptedSubscriptionsBySubcriberId($subscriberId);

    $subs = [];
    foreach ($subsSQL as $subSQL) {
      $sub = new SubscriptionModel();
      $subs[] = $sub->constructFromArray($subSQL);
    }
    return $subs;
  }

  public function saveOrUpdate($creatorId, $subscriberId, $status) {
    
    $res = SubscriptionRepository::getInstance()->getSubscription($creatorId, $subscriberId);

    
    
    if (count($res) > 0) {
      
      return SubscriptionRepository::getInstance()
      ->updateSubscription($creatorId, $subscriberId, $status);
    } else {
      
      return SubscriptionRepository::getInstance()
      ->insertSubscription($creatorId, $subscriberId, $status);
    }
  }

  public function update($creatorId, $subscriberId, $status) {
    return SubscriptionRepository::getInstance()
            ->updateSubscription($creatorId, $subscriberId, $status);
  }

  public function subscribe($creatorId, $subscriptionId) {
    $resp = $this->client->subscribe($creatorId, $subscriptionId);
    SubscriptionRepository::getInstance()->insertSubscription($creatorId, $subscriptionId, "PENDING");

    return $resp;
  }

  public function getSoapSubscriptions() {
    return $this->client->getSubscriptions();
  }

  public function getSubscriptions() {
    $sqlRes = SubscriptionRepository::getInstance()->getAllSubscriptions();

    $subs = [];
    foreach ($sqlRes as $subSQL) {
      $sub = new SubscriptionModel();
      $subs[] = $sub->constructFromArray($subSQL);
    }

    return $subs;
  }

  public function acceptSubscription($creatorId, $subscriptionId) {
    return $this->client->acceptSubscription($creatorId, $subscriptionId);
  }

  public function rejectSubscription($creatorId, $subscriptionId) {
    return $this->client->rejectSubscription($creatorId, $subscriptionId);
  }

  public function checkSubscription($creatorId, $subscriberId) {
    $res = SubscriptionRepository::getInstance()->getSubscription($creatorId, $subscriberId);

    

    if (count($res) > 0) {
      return $res[0]["status"];
    } else {
      return null;
    }
  }

  public function getPremiumArtist() {
    self::revalidateSubs();

    $artists = BinotifyRestClient::getPremiumArtist();
    $premiumArtist = [];

    
    
    foreach ($artists as $artist) {
      $check = self::checkSubscription($artist->{"user_id"}, $_SESSION["user_id"]);
      $status = isset($check) ? $check : null;

      $premiumArtist[] = [
        "creator_id" => $artist->{"user_id"},
        "name" => $artist->{"name"},
        "status" => $status
      ];
    }

    return $premiumArtist;
  }

  public function revalidateSubs() {
    
    $pendingSubs = SubscriptionRepository::getInstance()->getPendingSubscriptions();
    if (count($pendingSubs) <= 0) {
      return;
    }
    

    $creatorIds = [];
    $subscriberIds = [];
    foreach ($pendingSubs as $pendingSub) {
      $creatorIds[] = $pendingSub["creator_id"];
      $subscriberIds[] = $pendingSub["subscriber_id"];
    }
    $joinedCreatorIds = join(",", $creatorIds);
    $joinedSubscriberIds = join(",", $subscriberIds);

    $res = json_decode($this->client->checkStatus($joinedCreatorIds, $joinedSubscriberIds), true)["return"];
    if (isset($res["status"])) {
      $res = [$res];
    }

    // 
    foreach ($res as $sub) {
      
      $status = $sub["status"];
      $creatorId = $sub["creatorId"];
      $subscriberId = $sub["subscriberId"];
      self::update($creatorId, $subscriberId, $status);
    }
  }
}
