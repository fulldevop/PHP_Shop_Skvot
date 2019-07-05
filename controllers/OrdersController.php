<?php
namespace app\controllers;
use app\engine\App;
use app\models\Log;

class OrdersController extends Controller
{
  public function actionSend()
  {
    $params = App::call()->request->getParams();
    $response = App::call()->userRepository->userRegistration($params);
    if ($response['registration']) {
      App::call()->ordersRepository->createNewOrder($params);
      session_regenerate_id();
    }
    echo $response['json'];
  }

  public function actionFormalize()
  {
    $id_user = App::call()->userRepository->getUserId();
    $row_user = App::call()->userRepository->getOneWhere(['id' => $id_user]);
    App::call()->ordersRepository->createNewOrder($row_user);
    session_regenerate_id();
  }

  public function actionStatusChange()
  {
    $params = App::call()->request->getParams();
    App::call()->ordersRepository->changeStatus($params);
  }
}