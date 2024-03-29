<?php
/** @var \app\models\entities\Products $product */
?>
<div class="bg-top bg-top-catalog page-head--darken">
  <div class="container top-contain">
    <div class="head-info-product">
      <h1 class="card-title"><?= $product->getName(); ?></h1>
    </div>
  </div>
</div>
<div class="container">
  <div class="card-block">
    <div class="card-img">
      <img style="width: 428px; height: 440px" src="/img/products/big/prod-<?= $product->getId(); ?>.jpg"
           alt="img-good"/>
    </div>
    <div class="card-content">
      <div class="card-block-buy">
        <h5 class="price"><?= $product->getPrice(); ?> &#8381;</h5>
        <a class="buy-btn blue-btn" id="<?= $product->getId(); ?>">В корзину</a>
      </div>
      <div class="card-block-desc">
        <p class="card-desc-title">
          Описание товара:
        </p>
        <p class="card-desc"><?= $product->getDescription(); ?></p>
      </div>
    </div>
  </div>
</div>

