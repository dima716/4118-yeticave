<?php
require_once "init.php";

$page_content = include_template("templates/index.php", [
  "ads" => $ads,
  "categories" => $categories
]);

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Главная",
  "page_content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar
]);

print($layout_content);
