<?php

require_once PROJECT_ROOT_PATH . "/src/db/PDOInstance.php";

abstract class BaseRepository
{
  protected static $instance;
  protected $pdo;
  protected $tableName = '';

  protected function __construct()
  {
    $this->pdo = PDOInstance::getInstance()->getPDO();
  }

  public static function getInstance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  public function getPDO()
  {
    return $this->pdo;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM $this->tableName";
    return $this->pdo->query($sql);
  }

  public function countRow($where = []) {
    $sql = "SELECT COUNT(*) FROM $this->tableName";

    if (count($where) > 0) {
      $sql .= " WHERE ";
      $sql .= implode(" AND ", array_map(function ($key, $value) {
        if ($value[2] == 'LIKE') {
          return "$key LIKE :$key";
        }

        return "$key = :$key";
      }, array_keys($where), array_values($where)));
    }
    $stmt = $this->pdo->prepare($sql);
    foreach ($where as $key => $value) {
      $stmt->bindValue(":$key", $value[0], $value[1]);
      if ($value[2] == 'LIKE') {
        $stmt->bindValue(":$key", "%$value[0]%", $value[1]);
      } else {
        $stmt->bindValue(":$key", $value[0], $value[1]);
      }
    }

    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function findAll(
    $where = [],
    $order = null,
    $pageNo = null,
    $pageSize = null,
    $isDesc = false,
  ) {
    $sql = "SELECT * FROM $this->tableName ";

    if (count($where) > 0) {
      $sql .= "WHERE ";
      $sql .= implode(" AND ", array_map(function ($key, $value) {
        if ($key == "judul") {
          return "(judul LIKE :$key OR penyanyi LIKE :$key OR YEAR(tanggal_terbit) LIKE :$key)";
        }

        if ($value[2] == 'LIKE') {
          return "$key LIKE :$key";
        }

        return "$key = :$key";
      }, array_keys($where), array_values($where)));
    }

    if ($order) {
      $sql .= " ORDER BY $order";
    }

    if ($isDesc) {
      $sql .= " DESC";
    }

    if ($pageSize && $pageNo) {
      $sql .= " LIMIT :pageSize";
      $sql .= " OFFSET :offset";
    }

    $stmt = $this->pdo->prepare($sql);
    foreach ($where as $key => $value) {
      if ($value[2] == 'LIKE') {
        $stmt->bindValue(":$key", "%$value[0]%", $value[1]);
      } else {
        $stmt->bindValue(":$key", $value[0], $value[1]);
      }
    }

    if ($pageSize && $pageNo) {
      $offset = ($pageNo - 1) * $pageSize;

      $stmt->bindValue(":pageSize", $pageSize, PDO::PARAM_INT);
      $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    }

    
    
    

    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function findOne($arrParams)
  {
    $sql = "SELECT * FROM $this->tableName WHERE ";
    $i = 0;
    foreach ($arrParams as $key => $value) {
      $sql .= "$key = :$key";
      if ($i < count($arrParams) - 1) {
        $sql .= " AND ";
      }
      $i++;
    }

    $stmt = $this->pdo->prepare($sql);
    foreach ($arrParams as $key => $value) {
      $stmt->bindValue(":$key", $value[0], $value[1]);
    }

    $stmt->execute();
    return $stmt->fetch();
  }

  public function insert($model, $arrParams)
  {
    $sql = "INSERT INTO $this->tableName (";
    $i = 0;
    foreach ($arrParams as $key => $value) {
      $sql .= "$key";
      if ($i < count($arrParams) - 1) {
        $sql .= ", ";
      }
      $i++;
    }
    $sql .= ") VALUES (";
    $i = 0;
    foreach ($arrParams as $key => $value) {
      $sql .= ":$key";
      if ($i < count($arrParams) - 1) {
        $sql .= ", ";
      }
      $i++;
    }
    $sql .= ")";

    $stmt = $this->pdo->prepare($sql);
    foreach ($arrParams as $key => $value) {
      $stmt->bindValue(":$key", $model->get($key), $value);
    }

    $stmt->execute();
    return $this->pdo->lastInsertId();
  }

  public function update($model, $arrParams)
  {
    $sql = "UPDATE $this->tableName SET ";
    $i = 0;
    foreach ($arrParams as $key => $value) {
      $sql .= "$key = :$key";
      if ($i < count($arrParams) - 1) {
        $sql .= ", ";
      }
      $i++;
    }
    $primaryKey = $model->get('_primary_key');
    $sql .= " WHERE $primaryKey = :primaryKey";

    $stmt = $this->pdo->prepare($sql);
    foreach ($arrParams as $key => $value) {
      $stmt->bindValue(":$key", $model->get($key), $value);
    }
    $stmt->bindValue(":primaryKey", $model->get($primaryKey), PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function delete($model)
  {
    $sql = "DELETE FROM $this->tableName WHERE ";
    $primaryKey = $model->get('_primary_key');
    $sql .= "$primaryKey = :primaryKey";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":primaryKey", $model->get($primaryKey), PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->rowCount();
  }

  public function getNLastRow($N)
  {
    $sql = "SELECT COUNT(*) FROM $this->tableName";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count < $N) {
      $N = $count;
    }

    $offset = $count - $N;
    $sql = "SELECT * FROM $this->tableName LIMIT :limit OFFSET :offset";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(":limit", $N, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }
}
