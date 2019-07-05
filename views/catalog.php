<div class="bg-top bg-top-catalog page-head--darken">
  <div class="container top-contain">
    <h1 class="catalog-title">Каталог товаров</h1>
  </div>
</div>

<div class="container">
  <div class="catalog">
    <?php foreach ($catalog as $item): ?>
      <div class="good-block">
        <div class="photo catalog">
          <a rel='catalog' class='photo' href="/product/card/?id=<?= $item['id']; ?>">
            <img src="./img/products/small/prod-<?= $item['id']; ?>.jpg" alt="img-good"/>
          </a>
          <a class="buy-btn blue-btn catalog" id="<?= $item['id']; ?>">Купить</a>
        </div>
        <div class="good-text">
          <h4><a href="/product/card/?id=<?= $item['id']; ?>"><?= $item['name']; ?></a></h4>
          <p class="price"><?= number_format($item['price'], 0, '', ' '); ?> &#8381;</p>
        </div>
      </div>
    <?php endforeach; ?>
</div>