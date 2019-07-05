<div class="bg-top bg-top-basket">
  <div class="container top-contain-bask">
    <div class="head-info-product">
      <? if ($user == 'admin'): ?>
        <h1 class="basket-title">Заказы</h1>
      <? else: ?>
        <h1 class="basket-title">Мои заказы</h1>
      <? endif; ?>
    </div>
  </div>
</div>
<div class="container">
  <div class="wrap-products-basket">
    <? if ($user == 'admin'): ?>
      <h4 class="order-title-top">Заказы:</h4>
    <? else: ?>
      <h4 class="order-title-top">Мои заказы:</h4>
    <? endif; ?>
    <div class="orders-container">
      <div class="li order-id">Номер заказа</div>
      <? if ($user == 'admin'): ?>
      <div class="li order-id-user">Id клиента</div>
      <? endif; ?>
      <div class="li order-status">Статус заказа</div>
      <div class="li order-date">Дата и время оформления</div>
      <div class="li order-sum">Стоимость, руб.</div>
    </div>
    <? if ($orders): ?>
      <? foreach ($orders as $order): ?>
        <div class="my-orders-list">
          <div class="li"><?= $order['id']; ?></div>
          <? if ($user == 'admin'): ?>
            <div class="li"><?= $order['id_user']; ?></div>
            <select id="<?= $order['id']; ?>" class="li status-select">
              <? foreach ($statuses as $status): ?>
                <? if ($order['status'] == $status['name']): ?>
                  <option value="<?= $status['name']; ?>" selected><?= $status['name']; ?></option>
                <? else: ?>
                  <option value="<?= $status['name']; ?>"><?= $status['name']; ?></option>
                <? endif; ?>
              <? endforeach; ?>
            </select>
          <? else: ?>
            <div class="li"><?= $order['status']; ?></div>
          <? endif; ?>
          <div class="li"><?= $order['date']; ?></div>
          <div class="li"><?= $order['sum']; ?></div>
        </div>
      <? endforeach; ?>
    <? else: ?>
      <div class="empty-orders">Оформленных заказов нет</div>
    <? endif; ?>
  </div>
</div>