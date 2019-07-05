<?php
namespace app\models\repositories;
use app\engine\App;
use app\models\entities\Orders;
use app\models\Repository;

class OrdersRepository extends Repository
{
  public function createNewOrder($params)
  {
    $user_id = App::call()->userRepository->getOneWhere(['login' => $params['login']])['id'];
    $date = date('Y-m-d H:i:s');
    $order = new Orders(null, session_id(), $user_id, 1, $date);
    $is_auth = App::call()->userRepository->is_auth();
    App::call()->ordersRepository->save($order);

    if (!$is_auth) {
      $baskProd = App::call()->basketRepository->getAllWhere(['session' => session_id(), 'id_user' => 0]);
      foreach ($baskProd as $item) {
        $goodBask = App::call()->basketRepository->getOne($item['id']);
        $goodBask->setIdUser($user_id);
        App::call()->basketRepository->update($goodBask);
      }

      App::call()->userRepository->authSend();
    }
  }

  public function getOrders() {
    $id_user = App::call()->userRepository->getUserId();
    $sql = "SELECT `orders`.`id` as `id`, `orders`.`session` as `session`, 
`orders`.`id_user` as `id_user`, `status`.`name` as `status`, `orders`.`date` as `date` 
FROM `orders` INNER JOIN `status` ON `orders`.`status` = `status`.`id` WHERE `id_user` = :id_user";

    return $this->db->queryAll($sql, [':id_user' => $id_user]);
  }

  public function getOrdersAllUsers() {
    $sql = "SELECT `orders`.`id` as `id`, `orders`.`session` as `session`, 
`orders`.`id_user` as `id_user`, `status`.`name` as `status`, `orders`.`date` as `date` 
FROM `orders` INNER JOIN `status` ON `orders`.`status` = `status`.`id`";

    return $this->db->queryAll($sql);
  }

  public function getSumOrder($orders) {
    $ordersArray = $orders;

    for ($i = 0; $i < count($ordersArray); $i++) {
      $sum = App::call()->basketRepository->getTotalSum($ordersArray[$i]['session'], $ordersArray[$i]['id_user']);
      $ordersArray[$i]['sum'] = $sum;
    }

    return $ordersArray;
  }

  public function changeStatus($params) {
    $status = App::call()->statusRepository->getOneWhere(['name' => $params['status']]);
    $sql = "UPDATE `orders` SET `status` = :status WHERE `id` = :id";

    $this->db->execute($sql, [':status' => $status['id'], ':id' => $params['id']]);
  }

  public function getEntityClass()
  {
    return Orders::class;
  }

  public function getTableName()
  {
    return "orders";
  }
}