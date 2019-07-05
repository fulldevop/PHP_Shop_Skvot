<?php

namespace app\models\repositories;

use app\engine\App;
use app\models\entities\Users;
use app\models\Log;
use app\models\Repository;

class UserRepository extends Repository
{
  public function is_auth()
  {
    if (!isset($_SESSION['login'])) {
      if (isset($_COOKIE['hash'])) {
        $hash = $_COOKIE['hash'];
        $row = $this->getOneWhere(['hash' => $hash]);
        $user = $row['login'];
        if (!empty($user)) {
          $_SESSION['login'] = $user;
        }
      }
    }

    return isset($_SESSION['login']) ?: false;
  }

  public function authSend()
  {
    if (isset($_REQUEST['send'])) {
      $login = $_REQUEST['login'];
      $row = App::call()->userRepository->getOneWhere(['login' => $login]);
      $user = new Users;

      $user->setId($row['id']);
      $user->setLogin($row['login']);
      $user->setPass($row['pass']);

      if (!$this->auth($row)) {
        return false;
      } else {
        if (isset($_REQUEST['save'])) {
          $hash = uniqid(rand(), true);
          $user->setHash($hash);
          $this->save($user);
          $this->propertiesAllFalse($user);

          setcookie('hash', $hash, time() + 86400, '/');
        }
        $_SESSION['login'] = $login;

        return true;
      }
    } else return false;
  }

  public function auth($row)
  {
    $pass = $_REQUEST['pass'];
    return password_verify($pass, $row['pass']);
  }

  public function getUserName()
  {
    return !$this->is_auth() ?: $_SESSION['login'];
  }

  public function getUserId()
  {
    $is_auth = App::call()->userRepository->is_auth();
    if ($is_auth) {
      $sql = "SELECT `id` FROM `users` WHERE `login` = :login";
      return $this->db->queryOne($sql, [':login' => $_SESSION['login']])['id'];
    }
    return 0;
  }

  public function userRegistration($params) {
    $login = $params['login'];
    $email = $params['email'];
    $phone = $params['phone'];
    $address = $params['address'];
    $pass = password_hash($params['pass'], PASSWORD_DEFAULT, ['cost' => 11,
        'salt' => 'jd64hvnf8dgst30ghi78cvsh5ng4jgl1']);

    $isLoginDouble = App::call()->userRepository->getAllWhere(['login' => $login]);
    if ($isLoginDouble) {
      return ['json' => json_encode(['response' => 'error']), 'registration' => false];
    } else {
      $user = new Users(null, $login, $email, $phone, $address, 2, $pass, 0);
      App::call()->userRepository->save($user);
      return ['json' => json_encode(['response' => 'success']), 'registration' => true];
    }
  }

  public function getEntityClass()
  {
    return Users::class;
  }

  public function getTableName()
  {
    return "users";
  }
}