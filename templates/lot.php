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
      <?php if ($is_rates_shown) : ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?= count_time_until_end($lot["completion_date"]) ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= format_price($lot["current_price"]) ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка <span><?= format_price($lot["current_price"] + $lot["rate_step"]) ?></span>
            </div>
          </div>
          <form class="lot-item__form" action="add-rate.php" method="post" <?= isset($errors) ? "form--invalid" : "" ?>
          ">
          <p class="lot-item__form-item <?= isset($errors["rate"]) ? "form__item--invalid" : "" ?>">
            <label for="rate">Ваша ставка</label>
            <input id="rate" type="number" name="rate" placeholder="<?= $lot["current_price"] + $lot["rate_step"] ?>"
              value="<?= isset($lot["rate"]) ? $lot["rate"] : "" ?>">
            <span class="form__error"><?= isset($errors["rate"]) ? $errors["rate"] : "" ?></span>
            <input class="visually-hidden" name="lot_id" type="hidden" id="lot_id"
              value="<?= isset($lot["id"]) ? $lot["id"] : "" ?>" required>
            <input class="visually-hidden" name="current_price" type="hidden" id="current_price"
              value="<?= isset($lot["current_price"]) ? $lot["current_price"] : "" ?>" required>
            <input class="visually-hidden" name="rate_step" type="hidden" id="rate_step"
              value="<?= isset($lot["rate_step"]) ? $lot["rate_step"] : "" ?>" required>
          </p>
          <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок</h3>
        <table class="history__list">
          <?php foreach ($rates as $rate) : ?>
            <tr class="history__item">
              <td class="history__name"><?= $rate["user_name"] ?></td>
              <td class="history__price"><?= format_price($rate["amount"]) ?></td>
              <td class="history__time"><?= date("d.m.y", strtotime($rate["placement_date"])) . " в " . date("H:i", strtotime($rate["placement_date"])) ?></td>
            </tr>
          <?php endforeach ?>
        </table>
      </div>
    </div>
  </div>
</section>
