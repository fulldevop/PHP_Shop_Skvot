<?php

namespace app\engine;

class Db
{
  private $config;
  private $connection = null;

  public function __construct($driver, $host, $port, $login, $password, $database, $charset)
  {
    $this->config['driver'] = $driver;
    $this->config['host'] = $host;
    $this->config['port'] = $port;
    $this->config['login'] = $login;
    $this->config['password'] = $password;
    $this->config['database'] = $database;
    $this->config['charset'] = $charset;
  }

  private function getConnection()
  {
    if (is_null($this->connection)) {
      $this->connection = new \PDO($this->prepareDSNstr(),
          $this->config['login'],
          $this->config['password']
      );
      $this->connection->setAttribute(
          \PDO::ATTR_DEFAULT_FETCH_MODE,
          \PDO::FETCH_ASSOC);
    }
    return $this->connection;
  }

  private function prepareDSNstr()
  {
    return sprintf("%s:host=%s;port=%s;dbname=%s;charset=%s",
        $this->config['driver'],
        $this->config['host'],
        $this->config['port'],
        $this->config['database'],
        $this->config['charset']
    );
  }

  private function query($sql, $params) {
    $pdoStatement = $this->getConnection()->prepare($sql);
    $pdoStatement->execute($params);
    return $pdoStatement;
  }

  public function queryObject($sql, $params, $class) {
    $pdoStatement = $this->query($sql, $params);
    $pdoStatement->setFetchMode(\PDO::FETCH_CLASS |
        \PDO::FETCH_PROPS_LATE, $class);
    $obj = $pdoStatement->fetch();
    return $obj;
  }

  public function execute($sql, $params) {
    $this->query($sql, $params);
    return true;
  }

  public function queryOne($sql, $params = [])
  {
    return $this->queryAll($sql, $params)[0];
  }

  public function queryAll($sql, $params = [])
  {
    return $this->query($sql, $params)->fetchAll();
  }

  public function lastInsertId() {
    return $this->connection->lastInsertId();
  }
}