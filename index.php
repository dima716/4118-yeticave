<?php
require_once "init.php";

$ads = [];
$category = null;

if (isset($_GET["category"])) {
  $category = mysqli_real_escape_string($link, $_GET["category"]);
}

$condition = is_null($category) ? "" : "AND c.alias = \"" . $category . "\"";

$sql = "SELECT
  l.id,
  l.name,
  l.starting_price,
  l.image_url,
  c.name AS 'category',
  l.completion_date
FROM lots l
  JOIN categories c ON c.id = l.category_id
WHERE NOW() < l.completion_date " . $condition .
  " ORDER BY l.creation_date DESC";

$result = mysqli_query($link, $sql);

if ($result) {
  $ads = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
  $error = mysqli_error($link);
  show_error($error, [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
}

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
