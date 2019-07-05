<?php
namespace app\models\entities;

class Status extends DataEntity
{
  protected $id;
  protected $name;
  public $properties = [
      'id' => false,
      'name' => false
  ];

  public function __construct($id = null, $name = null)
  {
    $this->id = $id;
    $this->name = $name;
  }
}