<form class="form container <?= isset($errors) ? "form--invalid" : "" ?>" action="sign-up.php" method="post"
  enctype="multipart/form-data" novalidate> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>
  <div class="form__item <?= isset($errors["email"]) ? "form__item--invalid" : "" ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail"
      value="<?= isset($user_data["email"]) ? $user_data["email"] : "" ?>" required>
    <span class="form__error"><?= $errors["email"] ?></span>
  </div>
  <div class="form__item <?= isset($errors["password"]) ? "form__item--invalid" : "" ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль"
      value="<?= isset($user_data["password"]) ? $user_data["password"] : "" ?>" required>
    <span class="form__error"><?= $errors["password"] ?></span>
  </div>
  <div class="form__item <?= isset($errors["name"]) ? "form__item--invalid" : "" ?>">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="name" placeholder="Введите имя"
      value="<?= isset($user_data["name"]) ? $user_data["name"] : "" ?>" required>
    <span class="form__error"><?= $errors["name"] ?></span>
  </div>
  <div class="form__item <?= isset($errors["message"]) ? "form__item--invalid" : "" ?>">
    <label for="message">Контактные данные*</label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required><?= isset($user_data["message"]) ? $user_data["message"] : "" ?></textarea>
    <span class="form__error"><?= $errors["message"] ?></span>
  </div>
  <div
    class="form__item form__item--file form__item--last <?= isset($errors["file"]) ? "form__item--invalid" : "" ?> <?= isset($user_data["avatar"]) ? "form__item--uploaded" : "" ?>">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="<?= isset($user_data["avatar"]) ? $user_data["avatar"] : "" ?>" width="113" height="113"
          alt="Ваш аватар">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" name="avatar" type="file" id="avatar" value="" required>
      <label for="avatar">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error"><?= $errors["file"] ?></span>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
