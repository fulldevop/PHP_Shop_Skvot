<?php
namespace app\engine;
use app\interfaces\IRenderer;

class TwigRenderer implements IRenderer
{
  private $twig;
// TODO продублировать все шаблоны на твиге
  public function __construct()
  {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../twig/");
    $this->twig = new \Twig\Environment($loader);
  }
  public function renderTemplate($template, $params = [])
  {
    $templateFile = $template . ".twig";
    return $this->twig->render($templateFile, $params);
  }
}