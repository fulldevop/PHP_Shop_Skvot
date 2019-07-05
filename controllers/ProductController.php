<?php
namespace app\controllers;
use app\engine\App;

class ProductController extends Controller
{
  public function actionIndex() {
    $catalog = App::call()->productRepository->getAll();
    echo $this->render("catalog", ['catalog' => $catalog]);
  }

  public function actionCard() {
    $id = (int)$_GET['id'];
    $product = App::call()->productRepository->getOne($id);
    echo $this->render("card", ['product' => $product]);
  }

  public function actionAddBasket() {
    App::call()->productRepository->addProductInBasket();
    echo json_encode(App::call()->basketRepository->getCount());
  }
}