<form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : "" ?>" action="add.php" method="post"
  enctype="multipart/form-data" novalidate>
  <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?= isset($errors["name"]) ? "form__item--invalid" : "" ?>"> <!-- form__item--invalid -->
      <label for="name">Наименование</label>
      <input id="name" type="text" name="name" placeholder="Введите наименование лота"
        value="<?= isset($lot["name"]) ? $lot["name"] : "" ?>" required>
      <span class="form__error"><?= $errors["name"] ?></span>
    </div>
    <div class="form__item <?= isset($errors["category_id"]) ? "form__item--invalid" : "" ?>">
      <label for="category_id">Категория</label>
      <select id="category_id" name="category_id" required>
        <option value="">Выберите категорию</option>
        <?php foreach ($categories as $category) : ?>
          <option <?= isset($lot["category_id"]) && $lot["category_id"] == $category["id"] ? "selected" : "" ?>
            value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
        <?php endforeach; ?>
      </select>
      <span class="form__error"><?= $errors["category_id"] ?></span>
    </div>
  </div>
  <div class="form__item form__item--wide <?= isset($errors["message"]) ? "form__item--invalid" : "" ?>">
    <label for="message">Описание</label>
    <textarea id="message" name="message" placeholder="Напишите описание лота"
      required><?= isset($lot["message"]) ? htmlspecialchars($lot["message"]) : "" ?></textarea>
    <span class="form__error"><?= $errors["message"] ?></span>
  </div>
  <div class="form__item form__item--file
              <?= isset($errors["file"]) ? "form__item--invalid" : "" ?>
              <?= isset($lot["image_url"]) ? "form__item--uploaded" : "" ?>">
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img
          src="<?= isset($lot["image_url"]) ? $lot["image_url"] : "" ?>"
          width="113"
          height="113"
          alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" name="lot_img" type="file" id="lot_img" value="<?= isset($lot["image_url"]) ? $lot["image_url"] : "" ?>" required>
      <label for="lot_img">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error"><?= $errors["file"] ?></span>
  </div>
  <div class="form__container-three">
    <div class="form__item form__item--small <?= isset($errors["starting_price"]) ? "form__item--invalid" : "" ?>">
      <label for="starting_price">Начальная цена</label>
      <input id="starting_price" type="number" name="starting_price" placeholder="0"
        value="<?= isset($lot["starting_price"]) ? $lot["starting_price"] : "" ?>" required>
      <span class="form__error"><?= $errors["starting_price"] ?></span>
    </div>
    <div class="form__item form__item--small <?= isset($errors["rate_step"]) ? "form__item--invalid" : "" ?>">
      <label for="rate_step">Шаг ставки</label>
      <input id="rate_step" type="number" name="rate_step" placeholder="0"
        value="<?= isset($lot["rate_step"]) ? $lot["rate_step"] : "" ?>" required>
      <span class="form__error"><?= $errors["rate_step"] ?></span>
    </div>
    <div class="form__item <?= isset($errors["completion_date"]) ? "form__item--invalid" : "" ?>">
      <label for="completion_date">Дата окончания торгов</label>
      <input class="form__input-date" id="completion_date" type="text" name="completion_date"
        value="<?= isset($lot["completion_date"]) ? $lot["completion_date"] : "" ?>" required>
      <span class="form__error"><?= $errors["completion_date"] ?></span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Добавить лот</button>
</form>
