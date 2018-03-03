<section class="lot-item container">
  <h2><?= htmlspecialchars($lot["name"]) ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?= $lot["image_url"] ?>" width="730" height="548" alt="<?= htmlspecialchars($lot["name"]) ?>">
      </div>
      <p class="lot-item__category">Категория: <span><?= $lot["category"] ?></span></p>
      <p class="lot-item__description"><?= htmlspecialchars($lot["description"]) ?></p>
    </div>
    <div class="lot-item__right">
      <?php if ($is_auth) : ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?= count_time_until_end($lot["completion_date"]) ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= format_price($lot["starting_price"]) ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?= format_price($lot["starting_price"] + $lot["rate_step"]) ?></span>
            </div>
          </div>
          <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
            <p class="lot-item__form-item">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="number" name="cost" placeholder="<?= $lot["starting_price"] + $lot["rate_step"] ?>">
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span>10</span>)</h3>
        <table class="history__list">
          <?php foreach ($bets as $bet) : ?>
            <tr class="history__item">
              <td class="history__name"><?= $bet["name"] ?></td>
              <td class="history__price"><?= format_price($bet["price"]) ?></td>
              <td class="history__time"><?= date("d.m.y", $bet["ts"]) . " в " . date("H:i", $bet["ts"]) ?></td>
            </tr>
          <?php endforeach ?>
        </table>
      </div>
    </div>
  </div>
</section>
