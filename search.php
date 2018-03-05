<?php
require_once "init.php";

$lots = [];
$search = '';

if (!empty($_GET["search"])) {
  $search = mysqli_escape_string($link, $_GET["search"]);

  $sql = "SELECT
    l.id,
    l.name,
    l.starting_price,
    l.image_url,
    c.name AS 'category',
    l.completion_date
  FROM lots l
    JOIN categories c ON c.id = l.category_id
  WHERE MATCH(l.name, l.description) AGAINST('" . $search . "')";

  $result = mysqli_query($link, $sql);

  if ($result) {
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
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

$page_content = include_template("templates/search.php", [
  "search" => $search,
  "lots" => $lots
]);

$layout_content = include_template("templates/layout.php", [
  "page_title" => "Поиск " . $search,
  "page_content" => $page_content,
  "categories" => $categories,
  "is_auth" => $is_auth,
  "user_name" => $user_name,
  "user_avatar" => $user_avatar,
]);

print($layout_content);
