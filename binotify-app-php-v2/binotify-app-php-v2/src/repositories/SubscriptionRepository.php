<?php

require_once PROJECT_ROOT_PATH . "/src/bases/BaseRepository.php";

class SubscriptionRepository extends BaseRepository{
  protected static $instance;

  private function __construct() {
    parent::__construct();
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function getAllSubscriptions() {
    $sql = "SELECT * FROM subscription";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getSubscription($creatorId, $subscriberId) {
    $sql = "SELECT * FROM subscription WHERE creator_id = :creator_id AND subscriber_id = :subscriber_id";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':creator_id', $creatorId, PDO::PARAM_INT);
    $stmt->bindParam(':subscriber_id', $subscriberId, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getAcceptedSubscriptionsBySubcriberId($subscriberId) {
    $sql = "SELECT * FROM subscription WHERE subscriber_id = :subscriber_id and status = 'ACCEPTED'";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':subscriber_id', $subscriberId, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function updateSubscription($creatorId, $subscriberId, $status) {
    $sql = "UPDATE subscription SET status = :status WHERE creator_id = :creator_id AND subscriber_id = :subscriber_id";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':creator_id', $creatorId, PDO::PARAM_INT);
    $stmt->bindParam(':subscriber_id', $subscriberId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function insertSubscription($creatorId, $subscriberId, $status) {
    $sql = "INSERT INTO subscription (creator_id, subscriber_id, status) VALUES (:creator_id, :subscriber_id, :status)";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':creator_id', $creatorId, PDO::PARAM_INT);
    $stmt->bindParam(':subscriber_id', $subscriberId, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function getPendingSubscriptions() {
    $sql = "SELECT * FROM subscription WHERE status = 'PENDING'";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}

