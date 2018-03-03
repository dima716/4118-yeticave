<?php
require_once "init.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user_data = $_POST;
  $required = ["email", "password", "name", "message"];
  $errors = [];

  foreach ($required as $key) {
    if (empty($_POST[$key])) {
      $errors[$key] = "Это поле надо заполнить";
    }
  }

  if (!count($errors)) {
    if (!filter_var($user_data["email"], FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = "Введите корректный email";
    } elseif ($result = mysqli_query($link, "SELECT id FROM users WHERE email = \"" . mysqli_real_escape_string($link, $user_data["email"]) . "\"")) {
      if (mysqli_num_rows($result)) {
        $errors["email"] = "Пользователь с таким email уже существует. Введите другой email";
      }
    } else {
      show_error(mysqli_error($link), [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    }
  }

  if (!empty($_FILES["avatar"]["name"])) {
    $tmp_name = $_FILES["avatar"]["tmp_name"];
    $path = $_FILES["avatar"]["name"];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
      $errors["file"] = "Загрузите картинку в разрешенных форматах: JPG, JPEG, PNG";
    } else {
      move_uploaded_file($tmp_name, "img/" . $path);
      $user_data["avatar"] = "img/" . $path;
    }
  }

  if (count($errors)) {
    $page_content = include_template("templates/sign-up.php", ["user_data" => $user_data, "errors" => $errors, "categories" => $categories]);
  } else {
    if ($user_data["avatar"]) {
      $sql = "INSERT INTO users (email, name, password, avatar, contacts) VALUES (?, ?, ?, ?, ?)";
      $data = [
        $user_data["email"],
        $user_data["name"],
        password_hash($user_data["password"], PASSWORD_BCRYPT),
        $user_data["avatar"],
        $user_data["message"]
      ];
    } else {
      $sql = "INSERT INTO users (email, name, password, contacts) VALUES (?, ?, ?, ?)";
      $data = [
        $user_data["email"],
        $user_data["name"],
        password_hash($user_data["password"], PASSWORD_BCRYPT),
        $user_data["message"]
      ];
    }

    $stmt = db_get_prepare_stmt(
      $link,
      $sql,
      $data
    );

    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      header("Location: login.php");
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
  $page_content = include_template("templates/sign-up.php", []);
}

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Регистрация",
  "page_content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar
]);

print($layout_content);
