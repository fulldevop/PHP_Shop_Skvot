<?php
namespace app\controllers;
use app\engine\App;

class BasketController extends Controller
{
  public function actionIndex()
  {
    $userId = App::call()->userRepository->getUserId();
    $basket = App::call()->basketRepository->getBasket();
    $total = App::call()->basketRepository->getTotalSum(session_id(), $userId);
    $auth = App::call()->userRepository->is_auth();
    echo $this->render("basket", [
        'basket' => $basket,
        'total' => $total,
        'auth' => $auth]);
  }

  public function actionDelete()
  {
    $id = App::call()->request->getParams()['id'];
    App::call()->basketRepository->deleteProductBasket($id);
  }

  public function actionUpdateQuantity()
  {
    $params = App::call()->request->getParams();
    App::call()->basketRepository->updateQuantityGood($params);
  }
}