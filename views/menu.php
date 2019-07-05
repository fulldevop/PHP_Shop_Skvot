<header>
  <div class="top-menu">
    <div class="auth">
      <? if ($auth): ?>
      <? if ($user == 'admin'): ?>
        <a href="/lk" class="my-orders">Заказы</a>
      <? else: ?>
        <a href="/lk" class="my-orders">Мои заказы</a>
      <? endif; ?>
        <span class="welcome"><?= $user; ?>, добро пожаловать на сайт</span>
        <a href="/users/logout" id="logout">Выход</a>
      <? else: ?>
        <a id="login">Войти</a>
      <? endif; ?>
    </div>
  </div>
  <div class="menu">
    <div class="container">
      <ul>
        <li>
          <a href="/">
            <img class="logo-img" src="/img/logo.svg" alt="logo">
          </a>
        </li>
        <li class="menu-li-basket">
          <a href="/basket" class="menu-a-bask"></a>
          <div class="wrap-icon-cart">
            <div class="wrap-icon-bask">
              <div class="icon-count-cart">
                <div class="icon-count">
                  <? if ($count): ?>
                  <span class="count"><?= $count; ?></span>
                  <? else: ?>
                  <span class="count">0</span>
                  <? endif; ?>
                </div>
              </div>
              <img class="cart-icon" src="/img/cart-white.svg" alt="cart-icon">
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>

<? if (!$auth): ?>
  <div class="auth-block">
    <div class="auth-block-content">
      <div class="auth-form">
        <div class="auth-form-title">Авторизация:</div>
        <div class="error-auth">Неправильная пара логин-пароль!
          Проверьте раскладку клавиатуры, не нажата ли клавиша «Caps Lock» и попробуйте ввести логин и пароль еще раз.</div>
        <form id="form-auth" action="" method="post">
          <input type="text" name="login" id="auth-login" placeholder="Логин"><br>
          <input type="password" name="pass" id="auth-pass" placeholder="Пароль"><br>
          <div class="auth-save">
            <input type="checkbox" name="save" id="save"> <label for="save">Сохранить пароль</label>
          </div>
          <input class="blue-btn auth-btn" type="submit" id="auth-send" name="send" value="Войти">
        </form>
      </div>
      <div class="close-auth-btn"></div>
    </div>
  </div>
<? endif; ?>