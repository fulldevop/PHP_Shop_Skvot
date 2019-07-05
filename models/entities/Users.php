<?php
namespace app\models\entities;

class Users extends DataEntity
{
  protected $id;
  protected $login;
  protected $email;
  protected $phone;
  protected $address;
  protected $role;
  protected $pass;
  protected $hash;
  public $properties = [
      'id' => false,
      'login' => false,
      'email' => false,
      'phone' => false,
      'address' => false,
      'role' => false,
      'pass' => false,
      'hash' => false
  ];

  //admin 123, user 1234
  public function __construct($id = null, $login = null, $email = null, $phone = null,
                              $address = null, $role = null, $pass = null, $hash = null)
  {
    $this->id = $id;
    $this->login = $login;
    $this->email = $email;
    $this->phone = $phone;
    $this->address = $address;
    $this->role = $role;
    $this->pass = $pass;
    $this->hash = $hash;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPhone()
  {
    return $this->phone;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function getRole()
  {
    return $this->role;
  }

  public function getPass()
  {
    return $this->pass;
  }

  public  function getHash()
  {
    return $this->hash;
  }

  public function getProperties()
  {
    return $this->properties;
  }

  public function setId($id)
  {
    $this->properties['id'] = true;
    $this->id = $id;
  }

  public function setLogin($login)
  {
    $this->properties['login'] = true;
    $this->login = $login;
  }

  public function setEmail($email)
  {
    $this->properties['email'] = true;
    $this->email = $email;
  }

  public function setPhone($phone)
  {
    $this->properties['phone'] = true;
    $this->phone = $phone;
  }

  public function setAddress($address)
  {
    $this->properties['address'] = true;
    $this->address = $address;
  }

  public function setRole($role)
  {
    $this->properties['role'] = true;
    $this->role = $role;
  }

  public function setPass($pass)
  {
    $this->properties['pass'] = true;
    $this->pass = $pass;
  }

  public function setHash($hash)
  {
    $this->properties['hash'] = true;
    $this->hash = $hash;
  }

  public function setProperties($properties)
  {
    $this->properties = $properties;
  }
}
