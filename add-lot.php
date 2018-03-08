<?php
require_once "init.php";

if (!$is_auth) {
  header("HTTP/1.0 403 Forbidden");
  show_error("Эта страница доступна только для зарегистрированных пользователей", [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
  die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $lot = $_POST;

  $required = ["name", "category_id", "message", "starting_price", "rate_step", "completion_date"];
  $number = ["starting_price", "rate_step"];

  $errors = [];
  foreach ($required as $key) {
    if (empty($_POST[$key]) && $_POST[$key] !== '0') {
      $errors[$key] = "Это поле надо заполнить";
    }
  }

  foreach ($number as $key) {
    if (!is_numeric($_POST[$key])) {
      $errors[$key] = isset($errors[$key]) ? $errors[$key] : "Это поле должно быть числом";
    } else if ($_POST[$key] <= 0) {
      $errors[$key] = isset($errors[$key]) ? $errors[$key] : "Это поле должно быть больше нуля";
    }
  }

  if (!is_category_exists($lot["category_id"], $categories)) {
    $errors["category_id"] = "Данной категории не существует";
  }

  if (!is_date_format_valid($_POST["completion_date"])) {
    $errors["completion_date"] = isset($errors["completion_date"]) ? $errors["completion_date"] : "Введите дату в формате ДД.ММ.ГГГГ";
  } elseif (!is_date_valid($_POST["completion_date"])) {
    $errors["completion_date"] = "Введите корректную дату";
  } elseif (compare_dates_without_time($_POST["completion_date"], strtotime("today"), "<=")) {
    $errors["completion_date"] = "Указанная дата должна быть больше текущей даты хотя бы на один день";
  }

  if (!empty($_FILES["lot_img"]["name"])) {
    $tmp_name = $_FILES["lot_img"]["tmp_name"];
    $path = $_FILES["lot_img"]["name"];

    $file_type = mime_content_type($tmp_name);

    if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
      $errors["file"] = "Загрузите картинку в разрешенных форматах: JPG, JPEG, PNG";
    } else {
      move_uploaded_file($tmp_name, "img/" . $path);
      $lot["image_url"] = "img/" . $path;
    }
  } elseif (empty($lot["image_url"])) {
    $errors["file"] = "Вы не загрузили файл";
  }

  if (count($errors)) {
    $page_content = include_template("templates/add-lot.php", ["lot" => $lot, "errors" => $errors, "categories" => $categories]);
  } else {
    $sql = "INSERT INTO lots (
      name, 
      description, 
      image_url, 
      starting_price,
      rate_step,
      creation_date,
      completion_date,
      category_id,
      author_id
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $data = [
      $lot["name"],
      $lot["message"],
      $lot["image_url"],
      $lot["starting_price"],
      $lot["rate_step"],
      date("Y-m-d H:i:s"),
      date("Y-m-d H:i:s", strtotime($lot["completion_date"])),
      $lot["category_id"],
      $user_id
    ];

    $stmt = db_get_prepare_stmt(
      $link,
      $sql,
      $data
    );

    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      $lot_id = mysqli_insert_id($link);
      header("Location: lot.php?id=" . $lot_id);
      exit();
    } else {
      show_error(mysqli_error($link), [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    }
  }
} else {
  $page_content = include_template("templates/add-lot.php", ["categories" => $categories]);
}

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Добавление лота",
  "page_content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar
]);

print($layout_content);
