<?php
namespace app\models\entities;

class Orders extends DataEntity
{
  protected $id;
  protected $session;
  protected $id_user;
  protected $status;
  protected $date;
  public $properties = [
      'id' => false,
      'session' => false,
      'id_user' => false,
      'status' => false,
      'date' => false
  ];

  public function __construct($id = null, $session = null, $id_user = null, $status = null, $date = null)
  {
    $this->id = $id;
    $this->session = $session;
    $this->id_user = $id_user;
    $this->status = $status;
    $this->date = $date;
  }


  public function getId()
  {
    return $this->id;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function getIdUser()
  {
    return $this->id_user;
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function getDate()
  {
    return $this->date;
  }

  public function getProperties(): array
  {
    return $this->properties;
  }

  public function setId($id): void
  {
    $this->properties['id'] = true;
    $this->id = $id;
  }

  public function setSession($session): void
  {
    $this->properties['session'] = true;
    $this->session = $session;
  }

  public function setIdUser($id_user): void
  {
    $this->properties['id_user'] = true;
    $this->id_user = $id_user;
  }

  public function setStatus($status): void
  {
    $this->properties['status'] = true;
    $this->status = $status;
  }

  public function setDate($date): void
  {
    $this->properties['date'] = true;
    $this->date = $date;
  }

  public function setProperties(array $properties): void
  {
    $this->properties = $properties;
  }
}