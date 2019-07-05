<?php
namespace app\models\entities;

class Products extends DataEntity
{
  protected $id;
  protected $name;
  protected $description;
  protected $price;
  public $properties = [
      'id' => false,
      'name' => false,
      'description' => false,
      'price' => false
  ];

  public function __construct($id = null, $name = null, $description = null, $price = null)
  {
    $this->id = $id;
    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getDescription()
  {
    return nl2br($this->description);
  }

  public function getPrice()
  {
    return number_format($this->price, 0, '', ' ');
  }

  public function setName($name)
  {
    $this->properties['name'] = true;
    $this->name = $name;
  }

  public function setDescription($description)
  {
    $this->properties['description'] = true;
    $this->description = $description;
  }

  public function setPrice($price)
  {
    $this->properties['price'] = true;
    $this->price = $price;
  }
}