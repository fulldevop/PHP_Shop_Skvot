<?php
namespace app\engine;

class Request
{
  protected $requestString;
  protected $method;
  protected $controllerName;
  protected $actionName;
  protected $params;
  protected $quantity;

  public function __construct()
  {
    $this->requestString = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->parseRequest();
  }

  private function parseRequest() {
    $url = explode('/', $this->requestString);
    $this->controllerName = $url[1];
    $this->actionName = $url[2];
    $this->params = $_REQUEST;
  }

  public function getRequestString()
  {
    return $this->requestString;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function getControllerName()
  {
    return $this->controllerName;
  }

  public function getActionName()
  {
    return $this->actionName;
  }

  public function getParams()
  {
    return $this->params;
  }

}