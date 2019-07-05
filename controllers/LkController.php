<?php
namespace app\controllers;
use app\engine\App;

class LkController extends Controller
{
  public function actionIndex()
  {
    $user = App::call()->userRepository->getUserName();
    $statuses = App::call()->statusRepository->getAll();

    if ($user == 'admin') {
      $orders = App::call()->ordersRepository->getOrdersAllUsers();
    } else {
      $orders = App::call()->ordersRepository->getOrders();
    }
    $ordersArray = App::call()->ordersRepository->getSumOrder($orders);
    echo $this->render("lk", ['orders' => $ordersArray, 'user' => $user, 'statuses' => $statuses]);
  }
}