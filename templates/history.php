<section class="lots">
  <h2>История просмотров</h2>
  <ul class="lots__list">
    <?php foreach ($viewed_lots as $viewed_lot) : ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $viewed_lot["image_url"] ?>" width="350" height="260"
            alt="<?= htmlspecialchars($viewed_lot["name"]) ?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $viewed_lot["category"] ?></span>
          <h3 class="lot__title"><a class="text-link"
              href="lot.php?id=<?= $viewed_lot["id"] ?>"><?= htmlspecialchars($viewed_lot["name"]) ?></a></h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= format_price($viewed_lot["starting_price"]) ?></span>
            </div>
            <div class="lot__timer timer">
              <?= count_time_until_end($viewed_lot["completion_date"]) ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
<ul class="pagination-list">
  <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
  <li class="pagination-item pagination-item-active"><a>1</a></li>
  <li class="pagination-item"><a href="#">2</a></li>
  <li class="pagination-item"><a href="#">3</a></li>
  <li class="pagination-item"><a href="#">4</a></li>
  <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
</ul>
