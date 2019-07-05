<?php

namespace app\engine;
use app\interfaces\IRenderer;

class Renderer implements IRenderer
{
  public function renderTemplate($template, $params = []) {
    ob_start();
    extract($params);
    $templatePath = __DIR__ . "/../views/" . $template . ".php";

    include $templatePath;
    return ob_get_clean();
  }
}