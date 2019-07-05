<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\Repository;
use app\models\entities\Basket;

class BasketRepository extends Repository
{
  public function loginBasket()
  {
    $userId = App::call()->userRepository->getUserId();
    $goodsCurrentSession = $this->getAllWhere(['session' => session_id(), 'id_user' => 0]);

    foreach ($goodsCurrentSession as $item) {
      $goodBask = App::call()->basketRepository->getOne($item['id']);
      $goodBask->setIdUser($userId);
      App::call()->basketRepository->update($goodBask);
    }

    $this->unitGoodsBasket();
  }

  public function logoutBasket()
  {
    $userId = App::call()->userRepository->getUserId();
    $goodsCurrentUser = $this->getAllWhere(['id_user' => $userId]);

    foreach ($goodsCurrentUser as $item) {
      $goodBask = App::call()->basketRepository->getOne($item['id']);
      App::call()->basketRepository->delete($goodBask);
    }
  }

  /**
   * При авторизации пользователя могут появиться дубли строк одного товара.
   * Метод находит эти дубли и вместо нескольких строк одного и того же товара
   * создает одну строку с необходимым количеством товара
   */
  public function unitGoodsBasket()
  {
    $session = session_id();
    $userId = App::call()->userRepository->getUserId();
    $this->getAllWhere(['session' => session_id(), 'id_user' => $userId]);

    // Находим повторяющиеся товары
    $sql = "SELECT `id_good`, count(*) FROM `basket` WHERE `session` = :session AND 
`id_user` = :id_user GROUP BY `id_good` HAVING count(*) > 1 ORDER BY count(*)";

    $res = $this->db->queryAll($sql, [':session' => $session, ':id_user' => $userId]);

    foreach ($res as $item) {
      // Находим суммарное количество по каждому товару
      $sql = "SELECT SUM(`quantity`) as sum FROM `basket` WHERE `session` = :session AND 
`id_user` = :id_user AND `id_good` = {$item['id_good']} GROUP BY `id_good`";
      $sum = $this->db->queryOne($sql, [':session' => $session, ':id_user' => $userId])['sum'];

      // Удаляем все строки, где были повторяющиеся товары
      $sqlDel = "DELETE FROM `basket` WHERE `session` = :session AND `id_user` = :id_user AND `id_good` = :id_good";
      $this->db->execute($sqlDel, [':session' => $session, ':id_good' => $item['id_good'], ':id_user' => $userId]);

      // Создаем единственную строку с данным товаром
      $sqlInsert = "INSERT INTO `basket`
(`session`, `id_good`, `quantity`, `id_user`) VALUES 
(:session, :id_good, :quantity, :id_user)";
      $this->db->execute($sqlInsert, [
          ':session' => $session,
          ':id_good' => $item['id_good'],
          ':quantity' => $sum,
          ':id_user' => $userId
      ]);
    }
  }

  public function getCount()
  {
    $res = $this->getQuantityGoodsBasket();
    return $res;
  }

  public function getOneGood(array $params)
  {
    $paramsStr = '';
    $paramsQuery = [];

    end($params);
    $lastKeyArr = key($params);

    foreach ($params as $key => $value) {

      $paramsStr .= "`{$key}` = :{$key}";
      $paramsQuery[":{$key}"] = $value;

      if ($key != $lastKeyArr) {
        $paramsStr .= " AND ";
      }
    }
    $sql = "SELECT * FROM `basket` WHERE {$paramsStr}";
    return $this->db->queryObject($sql, $paramsQuery, static::class);
  }

  public function getBasket()
  {

    if (App::call()->userRepository->is_auth()) {
      $userId = App::call()->userRepository->getUserId();

      $sql = "SELECT `basket`.`id`, `basket`.`id_good`, `basket`.`quantity`, `products`.`name`,
 `products`.`description`, `products`.`price` FROM `basket` INNER JOIN `products` 
 ON `basket`.`id_good` = `products`.`id` AND `basket`.`session` = :session AND `basket`.`id_user` = :id_user";

      $params = [':id_user' => $userId, ':session' => session_id()];
    } else {
      $sql = "SELECT `basket`.`id`, `basket`.`id_good`, `basket`.`quantity`, `products`.`name`,
 `products`.`description`, `products`.`price` FROM `basket` INNER JOIN `products` 
 ON `basket`.`id_good` = `products`.`id` AND `basket`.`session` = :session AND `basket`.`id_user` = 0";

      $params = [':session' => session_id()];
    }

    return $this->db->queryAll($sql, $params);
  }

  public function getQuantityGoodsBasket()
  {
    if (App::call()->userRepository->is_auth()) {
      $userId = App::call()->userRepository->getUserId();
      $sql = "SELECT SUM(`quantity`) as count FROM `basket` WHERE `session` = :session AND `id_user` = :id_user";
      $params = [':session' => session_id(), ':id_user' => $userId];
    } else {
      $sql = "SELECT SUM(`quantity`) as count FROM `basket` WHERE `session` = :session AND `id_user` = 0";
      $params = [':session' => session_id()];
    }

    return $this->db->queryOne($sql, $params)['count'];
  }

  public function getTotalSum($session, $userId)
  {
    $sql = "SELECT SUM(`basket`.`quantity` * `products`.`price`) as sum 
FROM `basket` INNER JOIN `products` 
ON `basket`.`id_good` = `products`.`id` 
WHERE `basket`.`session` = :session AND `basket`.`id_user` = :id_user";

    $sum = $this->db->queryOne($sql, [':session' => $session, ':id_user' => $userId])['sum'];

    return number_format($sum, 0, '', ' ');
  }

  public function updateQuantityGood($params) {
    $id = $params['id'];
    $quantity = $params['quantity'];
    $userId = App::call()->userRepository->getUserId();

    $basket = App::call()->basketRepository->getOneGood(['id' => $id]);
    $product = new Basket($basket->id, $basket->session, $basket->id_good, $basket->quantity, $basket->id_user);

    if (session_id() == $product->getSession()) {
      $product->setQuantity($quantity);
      $basket->update($product);
      header('Content-Type: application/json');

      echo json_encode(['count' => App::call()->basketRepository->getCount(),
          'total' => App::call()->basketRepository->getTotalSum(session_id(), $userId)]);
    }
  }

  public function deleteProductBasket($id) {
    $userId = App::call()->userRepository->getUserId();
    $basket = App::call()->basketRepository->getOneGood(['id' => $id]);
    $product = new Basket($basket->id, $basket->session, $basket->id_good, $basket->quantity, $basket->id_user);
    $quantity = $product->getQuantity();

    if (session_id() == $product->getSession()) {
      if ($quantity == 1) {
        $basket->delete($product);
        $quantity = 0;
      } else {
        $product->setQuantity($quantity - 1);
        $basket->update($product);
        $quantity = $product->getQuantity();
      }

      header('Content-Type: application/json');

      echo json_encode(['count' => App::call()->basketRepository->getCount(), 'id' => $id,
          'quantity' => $quantity, 'total' => App::call()->basketRepository->getTotalSum(session_id(), $userId)]);
    }
  }

  public function getEntityClass()
  {
    return Basket::class;
  }

  public function getTableName()
  {
    return "basket";
  }
}