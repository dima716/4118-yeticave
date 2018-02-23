<form class="form form--add-lot container <?= isset($errors) ? "form--invalid" : "" ?>" action="add.php" method="post"
  enctype="multipart/form-data" novalidate>
  <!-- form--invalid -->
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?= isset($errors["lot-name"]) ? "form__item--invalid" : "" ?>"> <!-- form__item--invalid -->
      <label for="lot-name">Наименование</label>
      <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
        value="<?= isset($lot["lot-name"]) ? $lot["lot-name"] : "" ?>" required>
      <span class="form__error"><?= $errors["lot-name"] ?></span>
    </div>
    <div class="form__item <?= isset($errors["category"]) ? "form__item--invalid" : "" ?>">
      <label for="category">Категория</label>
      <select id="category" name="category" required>
        <option value="">Выберите категорию</option>
        <?php foreach ($categories as $category) : ?>
          <option <?= isset($lot["category"]) && $lot["category"] == $category ? "selected" : "" ?>
            value="<?= $category ?>"><?= $category ?></option>
        <?php endforeach; ?>
      </select>
      <span class="form__error"><?= $errors["category"] ?></span>
    </div>
  </div>
  <div class="form__item form__item--wide <?= isset($errors["message"]) ? "form__item--invalid" : "" ?>">
    <label for="message">Описание</label>
    <textarea id="message" name="message" placeholder="Напишите описание лота"
      required><?= isset($lot["message"]) ? htmlspecialchars($lot["message"]) : "" ?></textarea>
    <span class="form__error"><?= $errors["message"] ?></span>
  </div>
  <div class="form__item form__item--file <?= isset($errors["file"]) ? "form__item--invalid" : "" ?>">
    <!-- form__item--uploaded -->
    <label>Изображение</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" name="lot-img" type="file" id="photo2" value="" required>
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error"><?= $errors["file"] ?></span>
  </div>
  <div class="form__container-three">
    <div class="form__item form__item--small <?= isset($errors["lot-rate"]) ? "form__item--invalid" : "" ?>">
      <label for="lot-rate">Начальная цена</label>
      <input id="lot-rate" type="number" name="lot-rate" placeholder="0"
        value="<?= isset($lot["lot-rate"]) ? $lot["lot-rate"] : "" ?>" required>
      <span class="form__error"><?= $errors["lot-rate"] ?></span>
    </div>
    <div class="form__item form__item--small <?= isset($errors["lot-step"]) ? "form__item--invalid" : "" ?>">
      <label for="lot-step">Шаг ставки</label>
      <input id="lot-step" type="number" name="lot-step" placeholder="0"
        value="<?= isset($lot["lot-step"]) ? $lot["lot-step"] : "" ?>" required>
      <span class="form__error"><?= $errors["lot-step"] ?></span>
    </div>
    <div class="form__item <?= isset($errors["lot-date"]) ? "form__item--invalid" : "" ?>">
      <label for="lot-date">Дата окончания торгов</label>
      <input class="form__input-date" id="lot-date" type="date" name="lot-date"
        value="<?= isset($lot["lot-date"]) ? $lot["lot-date"] : "" ?>" required>
      <span class="form__error"><?= $errors["lot-date"] ?></span>
    </div>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Добавить лот</button>
</form>
