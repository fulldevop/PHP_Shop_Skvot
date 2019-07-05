<div class="bg-top bg-top-basket">
  <div class="container top-contain-bask">
    <div class="head-info-product">
      <h1 class="basket-title">Корзина</h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="wrap-products-basket">
    <? if ($basket): ?>
      <? foreach ($basket as $item): ?>
        <div class="basket-block-good" id="cart-good_<?= $item['id'] ?>">
          <div class="bask-img-good">
            <a href="/product/card/?id=<?= $item['id_good']; ?>">
              <img src="/img/products/small/prod-<?= $item['id_good']; ?>.jpg" alt="img-good">
            </a>
          </div>
          <div class="bask-text-good">
            <div class="text">
              <a href="/product/card/?id=<?= $item['id_good']; ?>">
                <?= $item['name']; ?>
              </a>
            </div>
          </div>
          <div class="bask-quantity-price-good">
            <div class="price price-good" id="price-good_<?= $item['id'] ?>"
                 data-price="<?= $item['price']; ?>"><?= number_format($item['price'], 0, '', ' '); ?> &#8381;
            </div>
            <div class="quantity-good">
              <input class="count-input" type="number" min="1" max="99"
                     value="<?= $item['quantity'] ?>" id="count-input_<?= $item['id'] ?>" data-id="<?= $item['id'] ?>">
            </div>
            <div class="price sum-good"><span class="sum-product" id="sum-good_<?= $item['id'] ?>"></span> &#8381;</div>
          </div>
          <div class="bask-remove-good">
            <a class="delete-good" id="<?= $item['id'] ?>">Удалить</a>
          </div>
        </div>
      <? endforeach; ?>

    <div class="total-sum">Итого: <span id="total-sum"></span><span> &#8381;</span></div>


    <div class="order-block">
      <? if ($auth): ?>
        <div class="blue-btn order-btn" id="order-btn">Оформить заказ</div>
      <? else: ?>
      <div class="order-text-form">
        <div class="text">
          <p>Если вы зарегистрированы на нашем сайте - можете <a id="open-login">войти в свой аккаунт</a>.</p>
          <p>Если не зарегистрированы - заполнить форму справа. <br>
            Запомните логин и пароль, по ним вы сможете входить в свой аккаунт
            и отслеживать изменения своего заказа.</p>
          <div id="error-order-registr">
            Аккаунт с таким логином уже существует, выберите другой логин.
          </div>
        </div>
        <div class="form">
          <form action="" method="post" class="order-form" id="order-form">
            <input type="email" name="email" id="order-form-email" placeholder="Email адрес"><br>
            <input type="text" name="phone" id="order-form-phone" placeholder="Номер телефона"><br>
            <input type="text" name="address" id="order-form-address" placeholder="Адрес"><br>
            <input type="text" name="login" id="order-form-login" placeholder="Логин"><br>
            <input type="password" name="pass" id="order-form-pass" placeholder="Пароль"><br>
            <input class="blue-btn order-send-btn" id="order-form-send" type="submit" name="send" value="Отправить">
          </form>
        </div>
      </div>
      <? endif; ?>
    </div>

    <? else: ?>
    <? if($_GET['message'] == 'ok'): ?>
    <div class="success-order">
      Ваш заказ успешно оформлен!
    </div>
    <? endif; ?>
      <div class="empty-basket">
        <div class="img-empty-cart">
          <img src="/img/cartempty.png" alt="cartempty">
        </div>
        <div class="content">
          <p>К сожалению, ваша корзина пока пуста.<br>
            Но есть отличная возможность её наполнить! Например, начните с <a href="/">главной страницы</a>.<br>
            Далее нажмите на кнопку <i>Купить</i>, и товары появятся здесь!</p>
        </div>
      </div>
    <? endif; ?>
  </div>
</div>