<?php

namespace app\engine;
use app\models\repositories\BasketRepository;
use app\models\repositories\ProductRepository;
use app\models\repositories\StatusRepository;
use app\models\repositories\UserRepository;
use app\models\repositories\OrdersRepository;
use app\traits\TSingleton;


/**
 * Class App
 * @property Request $request
 * @property BasketRepository $basketRepository
 * @property UserRepository $userRepository
 * @property ProductRepository $productRepository
 * @property OrdersRepository $ordersRepository
 * @property StatusRepository $statusRepository
 * @property Db $db
 */
class App
{
  use TSingleton;

  public $config;

  /** @var  Storage */
  private $components;


  private $controller;
  private $action;

  /**
   * @return static
   */
  public static function call()
  {
    return static::getInstance();
  }

  public function run($config)
  {
    $this->config = $config;

    $this->components = new Storage();
    $this->runController();
  }

  public function createComponent($name)
  {
    if (isset($this->config['components'][$name])) {
      $params = $this->config['components'][$name];
      $class = $params['class'];
      if (class_exists($class)) {
        unset($params['class']);
        $reflection = new \ReflectionClass($class);
        return $reflection->newInstanceArgs($params);

      }
    }
    return null;
  }

  public function runController()
  {
    $this->controller = $this->request->getControllerName() ?: 'product';
    $this->action = $this->request->getActionName();

    $controllerClass = $this->config['controllers_namespaces'] . ucfirst($this->controller) . "Controller";

    if (class_exists($controllerClass)) {
      $controller = new $controllerClass(new Renderer());
      $controller->runAction($this->action);
    }
  }

  function __get($name)
  {
    return $this->components->get($name);
  }


}