<section class="promo">
  <h2 class="promo__title">Нужен стафф для катки?</h2>
  <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
    снаряжение.</p>
  <ul class="promo__list">
    <?php foreach ($categories as $category) : ?>
      <li class="promo__item promo__item--<?= $category["alias"] ?>">
        <a class="promo__link" href="index.php?category=<?= $category["alias"] ?>"><?= $category["name"] ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
<section class="lots">
  <div class="lots__header">
    <?php if (!empty($selected_category)) : ?>
      <h2>Все лоты в категории «<?= $selected_category["name"] ?>»</h2>
    <?php else: ?>
      <h2>Открытые лоты</h2>
    <?php endif; ?>
  </div>
  <ul class="lots__list">
    <?php foreach ($lots as $lot) : ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $lot["image_url"] ?>" width="350" height="260" alt="<?= htmlspecialchars($lot["name"]) ?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $lot["category"] ?></span>
          <h3 class="lot__title"><a class="text-link"
              href="lot.php?id=<?= $lot["id"] ?>"><?= htmlspecialchars($lot["name"]) ?></a></h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= format_price($lot["starting_price"]) ?></span>
            </div>
            <div class="lot__timer timer"><?= count_time_until_end($lot["completion_date"]) ?></div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
    <?php if (count($lots) === 0) : ?>
      <div class="message">В данной категории товаров нет</div>
    <?php endif; ?>
  </ul>
  <?php if ($pages > 1): ?>
    <ul class="pagination-list">
      <?php if ($current_page !== 0): ?>
        <li class="pagination-item pagination-item-prev"><a
            href="index.php?category=<?= $selected_category["alias"] ?>&page=<?= $current_page - 1 ?>">Назад</a></li>
      <?php endif; ?>

      <?php for ($i = 0; $i < $pages; $i++) : ?>
        <li class="pagination-item <?= $current_page === $i ? "pagination-item-active" : "" ?>"><a
            href="index.php?category=<?= $selected_category["alias"] ?>&page=<?= $i ?>"><?= $i + 1 ?></a>
        </li>
      <?php endfor; ?>

      <?php if ($current_page !== $pages - 1): ?>
        <li class="pagination-item pagination-item-next"><a
            href="index.php?category=<?= $selected_category["alias"] ?>&page=<?= $current_page + 1 ?>">Вперед</a></li>
      <?php endif; ?>
    </ul>
  <?php endif; ?>
</section>
