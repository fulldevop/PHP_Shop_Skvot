<?php
namespace app\models;
use app\engine\App;
use app\models\entities\DataEntity;

abstract class Repository
{
  protected $db;

  public function __construct()
  {
    $this->db = App::call()->db;
  }

  public function getOne($id)
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM `{$tableName}` WHERE `id` = :id";
    return $this->db->queryObject($sql, [':id' => $id], $this->getEntityClass());
  }

  public function getAll()
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM `{$tableName}`";
    return $this->db->queryAll($sql);
  }

  public function getOneWhere(array $params)
  {
    $paramsStr = '';
    $paramsQuery = [];

    end($params);
    $lastKeyArr = key($params);

    foreach ($params as $key => $value) {
      $paramsStr .= "`{$key}` = :{$key}";
      $paramsQuery[":{$key}"] = $value;

      if ($key != $lastKeyArr) {
        $paramsStr .= " AND ";
      }
    }

    $tableName = $this->getTableName();
    $sql = "SELECT * FROM `{$tableName}` WHERE {$paramsStr}";
    return $this->db->queryOne($sql, $paramsQuery);
  }

  public function getAllWhere(array $params)
  {
    $paramsStr = '';
    $paramsQuery = [];

    end($params);
    $lastKeyArr = key($params);

    foreach ($params as $key => $value) {
      $paramsStr .= "`{$key}` = :{$key}";
      $paramsQuery[":{$key}"] = $value;

      if ($key != $lastKeyArr) {
        $paramsStr .= " AND ";
      }
    }

    $tableName = $this->getTableName();
    $sql = "SELECT * FROM `{$tableName}` WHERE {$paramsStr}";
    return $this->db->queryAll($sql, $paramsQuery);
  }

// CRUD блок

  public function save(DataEntity $entity)
  {
    is_null($entity->getId()) ? $this->insert($entity) : $this->update($entity);
  }


  public function insert(DataEntity $entity)
  {
    $tableName = $this->getTableName();

    $columns = [];
    $params = [];
    $keysProperties = [];
    $keysForGetters = [];

    foreach ($entity->getProperties() as $key => $value) {
      if ($key == 'id') continue;
      $keysProperties[] = $key;
      $keysForGetters[] =  explode('_', $key);
    }

    for ($i = 0; $i < count($keysForGetters); $i++) {
      $getter = "get";
      for ($j = 0; $j < count($keysForGetters[$i]); $j++) {
        $getter .=  ucfirst($keysForGetters[$i][$j]);
      }

      $params[":{$keysProperties[$i]}"] = $entity->$getter();
      $columns[] = $keysProperties[$i];
    }

    $columns = "`" . implode('`, `', $columns) . "`";
    $values = implode(', ', array_keys($params));

    $sql = "INSERT INTO `{$tableName}` ({$columns}) VALUES ({$values})";

    $this->db->execute($sql, $params);

    $entity->setId($this->db->lastInsertId());

    $this->propertiesAllFalse($entity);
  }

  public function update(DataEntity $entity)
  {
    $tableName = $this->getTableName();

    $params = [];
    $alter = [];
    $keysProperties = [];
    $keysForGetters = [];

    foreach ($entity->getProperties() as $key => $value) {
      if ($key == 'id') continue;
      $keysProperties[] = $key;
      $keysForGetters[] =  explode('_', $key);
    }

    for ($i = 0; $i < count($keysForGetters); $i++) {
      $getter = "get";
      for ($j = 0; $j < count($keysForGetters[$i]); $j++) {
        $getter .=  ucfirst($keysForGetters[$i][$j]);
      }

      $params[":{$keysProperties[$i]}"] = $entity->$getter();
      $alter[] .= "`" . $keysProperties[$i] . "` = :" . $keysProperties[$i];
    }

    $alter = implode(", ", $alter);
    $params[':id'] = $entity->getId();

    $sql = "UPDATE `{$tableName}` SET {$alter} WHERE `id` = :id";

    $this->db->execute($sql, $params);
    $this->propertiesAllFalse($entity);
  }

  public function delete(DataEntity $entity)
  {
    $tableName = $this->getTableName();
    $sql = "DELETE FROM `{$tableName}` WHERE `id` = :id";
    return $this->db->execute($sql, [':id' => $entity->getId()]);
  }

  public function propertiesAllFalse($entity)
  {
    $propKeys = array_keys($entity->getProperties());
    $newProperties = [];

    foreach ($propKeys as $key) {
      $newProperties[$key] = false;
    }

    $entity->setProperties($newProperties);
  }

  abstract public function getTableName();

  abstract public function getEntityClass();
}