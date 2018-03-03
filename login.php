<?php
require_once "init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_data = $_POST;

  $required = ["email", "password"];
  $errors = [];
  $user = [];

  foreach ($required as $key) {
    if (empty($_POST[$key])) {
      $errors[$key] = "Это поле надо заполнить";
    }
  }

  if (!count($errors)) {
    $sql = "SELECT id, email, name, registration_date, password, avatar, contacts FROM users WHERE email = \"" . mysqli_real_escape_string($link, $user_data["email"]) . "\"";

    if ($result = mysqli_query($link, $sql)) {
      if (!mysqli_num_rows($result)) {
        $errors["email"] = "Такой пользователь не найден";
      } elseif (!password_verify($user_data["password"], ($user = mysqli_fetch_array($result, MYSQLI_ASSOC))["password"])) {
        $errors["password"] = "Вы ввели неверный пароль";
      }
    } else {
      $error = mysqli_error($link);
      show_error($error, [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    }
  }

  if (count($errors)) {
    $page_content = include_template("templates/login.php", ["user_data" => $user_data, "errors" => $errors]);
  } else {
    $_SESSION["user"] = $user;
    header("Location: index.php");
    exit();
  }
} else {
  if ($is_auth) {
    header("Location: index.php");
    exit();
  } else {
    $page_content = include_template("templates/login.php", []);
  }
}

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Главная",
  "page_content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar
]);

print($layout_content);
