<?php

namespace app\engine;
class Autoload
{
  private $fileExtension = ".php";

  public function loadClass($className)
  {
    $className = str_replace(['app\\', '\\'], ['', DIRECTORY_SEPARATOR], $className);
    $file = __DIR__ . "/../{$className}";
    $file .= $this->fileExtension;

    if (file_exists($file)) {
      include $file;
    }
  }
}