<?php
require_once "data.php";
require_once "functions.php";

date_default_timezone_set('Europe/Moscow');

$is_auth = (bool)rand(0, 1);
$user_name = "Константин";
$user_avatar = "img/user.jpg";

$page_content = include_template("templates/index.php", ["ads" => $ads]);

$layout_content = include_template("templates/layout.php", [
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar,
  "page_title" => "Главная",
  "page_content" => $page_content,
  "categories" => $categories
]);

print($layout_content);
