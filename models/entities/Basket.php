<?php

namespace app\models\entities;

class Basket extends DataEntity
{
  protected $id;
  protected $session;
  protected $id_good;
  protected $quantity;
  protected $id_user;
  public $properties = [
      'id' => false,
      'session' => false,
      'id_good' => false,
      'quantity' => false,
      'id_user' => false
  ];

  public function __construct($id = null, $session = null, $id_good = null, $quantity = null, $id_user = null)
  {
    $this->id = $id;
    $this->session = $session;
    $this->id_good = $id_good;
    $this->quantity = $quantity;
    $this->id_user = $id_user;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function getIdGood()
  {
    return $this->id_good;
  }

  public function getQuantity()
  {
    return $this->quantity;
  }

  public function getIdUser()
  {
    return $this->id_user;
  }

  public function getProperties()
  {
    return $this->properties;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setSession($session)
  {
    $this->properties['session'] = true;
    $this->session = $session;
  }

  public function setIdGood($id_good)
  {
    $this->properties['id_good'] = true;
    $this->id_good = $id_good;
  }

  public function setQuantity($quantity)
  {
    $this->properties['quantity'] = true;
    $this->quantity = $quantity;
  }

  public function setIdUser($id_user)
  {
    $this->properties['id_user'] = true;
    $this->id_user = $id_user;
  }

  public function setProperties($properties)
  {
    $this->properties = $properties;
  }
}