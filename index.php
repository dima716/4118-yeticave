<?php
require_once "data.php";
require_once "functions.php";

session_start();

$page_content = include_template("templates/index.php", ["ads" => $ads, "categories" => $categories]);

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Главная",
  "page_content" => $page_content,
  "categories" => $categories
]);

print($layout_content);
