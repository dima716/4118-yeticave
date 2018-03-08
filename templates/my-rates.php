<section class="rates container">
  <h2>Мои ставки</h2>
  <?php if (count($rates)) : ?>
    <table class="rates__list">
      <?php foreach ($rates as $rate): ?>
        <tr
          class="rates__item <?= $rate["is_winner"] ? "rates__item--win" : "" ?> <?= $rate["is_completed"] ? "rates__item--end" : "" ?>">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?= $rate["lot_image_url"] ?>" width="54" height="40" alt="<?= htmlspecialchars($rate["lot_name"]) ?>">
            </div>
            <div>
              <h3 class="rates__title"><a href="lot.php?id=<?= $rate["lot_id"] ?>"><?= htmlspecialchars($rate["lot_name"]) ?></a>
              </h3>
              <?php if ($rate["is_winner"]): ?>
                <p><?= htmlspecialchars($rate["author_contacts"]) ?></p>
              <?php endif; ?>
            </div>
          </td>
          <td class="rates__category">
            <?= $rate["category"] ?>
          </td>
          <?php if ($rate["is_winner"]) : ?>
            <td class="rates__timer">
              <div class="timer timer--win">Ставка выиграла</div>
            </td>
          <?php else : ?>
            <td class="rates__timer">
              <div class="timer timer--finishing"><?= count_time_until_end($rate["completion_date"]) ?></div>
            </td>
          <?php endif; ?>
          <td class="rates__price">
            <?= format_price($rate["amount"]) ?>
          </td>
          <td class="rates__time">
            <?= date("d.m.y", strtotime($rate["placement_date"])) . " в " . date("H:i", strtotime($rate["placement_date"])) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else : ?>
    <div class="message">Вы еще не сделали ни одной ставки</div>
  <?php endif; ?>
</section>
