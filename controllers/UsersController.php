<?php

namespace app\controllers;

use app\engine\App;

class UsersController extends Controller
{
  //admin 123, user 1234

  public function actionLogin() {
    $auth = App::call()->userRepository->authSend();
    if ($auth) {
      App::call()->basketRepository->loginBasket();
      echo json_encode(['response' => 'success']);
    } else {
      echo json_encode(['response' => 'error']);
    }
  }
  public function actionLogout() {
    session_destroy();
    setcookie('hash', '', 0, '/');
    header("Location: /");
  }
}