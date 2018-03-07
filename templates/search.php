<?php if (empty($search)) : ?>
  <div class="message">Вы ввели пустой поисковый запрос</div>
<?php else: ?>
  <?php if (count($lots) == 0): ?>
    <div class="message">Ничего не найдено по вашему запросу</div>
  <?php else: ?>
    <section class="lots">
      <h2>Результаты поиска по запросу «<span><?= $search ?></span>»</h2>
      <ul class="lots__list">
        <?php foreach ($lots as $lot): ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= $lot["image_url"] ?>" width="350" height="260" alt="<?= $lot["name"] ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $lot["category"] ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot["id"] ?>"><?= $lot["name"] ?></a>
              </h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= format_price($lot["starting_price"]) ?></span>
                </div>
                <div class="lot__timer timer">
                  <?= count_time_until_end($lot["completion_date"]) ?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php if ($pages > 1): ?>
      <ul class="pagination-list">
        <?php if ($current_page !== 0): ?>
          <li class="pagination-item pagination-item-prev"><a
              href="search.php?search=<?= $search ?>&page=<?= $current_page - 1 ?>">Назад</a></li>
        <?php endif; ?>

        <?php for ($i = 0; $i < $pages; $i++) : ?>
          <li class="pagination-item <?= $current_page === $i ? "pagination-item-active" : "" ?>"><a href="search.php?search=<?= $search ?>&page=<?= $i ?>"><?= $i + 1 ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($current_page !== $pages - 1): ?>
          <li class="pagination-item pagination-item-next"><a
              href="search.php?search=<?= $search ?>&page=<?= $current_page + 1 ?>">Вперед</a></li>
        <?php endif; ?>
      </ul>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>
