<?php
require_once "data.php";
require_once "userdata.php";
require_once "functions.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_data = $_POST;

  $required = ["email", "password"];
  $errors = [];

  foreach ($required as $key) {
    if (empty($_POST[$key])) {
      $errors[$key] = "Это поле надо заполнить";
    }
  }

  if (!count($errors)) {
    if ($user = search_user_by_email($user_data["email"], $users)) {
      if (password_verify($user_data["password"], $user["password"])) {
        $_SESSION["user"] = $user;
      } else {
        $errors["password"] = "Вы ввели неверный пароль";
      }
    } else {
      $errors["email"] = "Такой пользователь не найден";
    }
  }

  if (count($errors)) {
    $page_content = include_template("templates/login.php", ["user_data" => $user_data, "errors" => $errors]);
  } else {
    header("Location: index.php");
    exit();
  }
} else {
  if(isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
  } else {
    $page_content = include_template("templates/login.php", []);
  }
}

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Главная",
  "page_content" => $page_content,
  "categories" => $categories
]);

print($layout_content);
