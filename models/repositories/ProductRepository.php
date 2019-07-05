<?php
namespace app\models\repositories;
use app\engine\App;
use app\models\entities\Basket;
use app\models\Repository;
use app\models\entities\Products;

class ProductRepository extends Repository
{
  public function addProductInBasket() {
    if (App::call()->userRepository->is_auth()) {
      $id_good = App::call()->request->getParams()['id'];
      $user_id = App::call()->userRepository->getUserId();
      $good = App::call()->basketRepository->getOneGood(['session' => session_id(), 'id_good' => $id_good, 'id_user' => $user_id]);

      if ($good) {
        $product = new Basket($good->id, $good->session, $good->id_good, $good->quantity, $good->id_user);
        $quantity = $product->getQuantity();
        $product->setQuantity($quantity + 1);
        $good->save($product);
      } else {
        $basket = new Basket(null, session_id(), $id_good, 1, $user_id);
        App::call()->basketRepository->save($basket);
      }

    } else {
      $id_good = App::call()->request->getParams()['id'];
      $good = App::call()->basketRepository->getOneGood(['session' => session_id(), 'id_user' => 0, 'id_good' => $id_good]);
      if ($good) {
        $product = new Basket($good->id, $good->session, $good->id_good, $good->quantity, 0);
        $quantity = $product->getQuantity();
        $product->setQuantity($quantity + 1);
        $good->save($product);
      } else {
        $basket = new Basket(null, session_id(), $id_good, 1, 0);
        App::call()->basketRepository->save($basket);
      }
    }
  }

  public function formatPrice($price) {
    return number_format($price, 0, '', ' ');
  }

  public function getEntityClass() {
    return Products::class;
  }

  public function getTableName() {
    return "products";
  }
}