<?php
session_start();
require_once __DIR__ . "/../vendor/autoload.php";
$config = include __DIR__ . "/../config/config.php";
//include __DIR__ . "/../engine/Autoload.php";

use app\engine\App;

//spl_autoload_register([new Autoload(), 'loadClass']);

try {

  App::call()->run($config);

} catch (\Exception $e) {
  echo $e->getMessage() . "<br>";
  var_dump($e->getTrace());
}