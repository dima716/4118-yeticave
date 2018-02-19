<?php
require_once "data.php";
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $lot = $_POST;

  $required = ["lot-name", "category", "message", "lot-rate", "lot-step", "lot-date"];
  $number = ["lot-rate", "lot-step"];

  $errors = [];
  foreach ($number as $key) {
    if (!ctype_digit($_POST[$key])) {
      $errors[$key] = "Это поле должно быть числом";
    }
  }

  foreach ($required as $key) {
    if (empty($_POST[$key])) {
      $errors[$key] = "Это поле надо заполнить";
    }
  }

  if (!empty($_FILES["lot-img"]["name"])) {
    $tmp_name = $_FILES["lot-img"]["tmp_name"];
    $path = $_FILES["lot-img"]["name"];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== "image/jpeg") {
      $errors["file"] = "Загрузите картинку в формате JPEG";
    } else {
      move_uploaded_file($tmp_name, "img/" . $path);
      $lot["path"] = "img/" . $path;
    }
  } else {
    $errors["file"] = "Вы не загрузили файл";
  }

  if (count($errors)) {
    $page_content = include_template("templates/add-lot.php", ["lot" => $lot, "errors" => $errors]);
  } else {
    $page_content = include_template("templates/lot.php", ["lot" => [
      "name" => $lot["lot-name"],
      "category" => $lot["category"],
      "description" => $lot["message"],
      "price" => $lot["lot-rate"],
      "step" => $lot["lot-step"],
      "date" => $lot["lot-date"],
      "rate" => $lot["lot-rate"],
      "url" => $lot["path"]
    ]]);
  }
} else {
  $page_content = include_template("templates/add-lot.php", []);
}

$layout_content = include_template("templates/layout.php", [
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar,
  "page_title" => "Добавление лота",
  "page_content" => $page_content,
  "categories" => $categories
]);

print($layout_content);
