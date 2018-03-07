<?php
require_once "init.php";
require_once "getwinner.php";

$lots = [];
$selected_category_alias = null;
$limit = 9;
$offset = 0;
$current_page = 0;
$pages = 1;

if (isset($_GET["category"])) {
  $selected_category_alias = mysqli_real_escape_string($link, $_GET["category"]);

  $sql = "SELECT * FROM lots l JOIN categories c ON c.id = l.category_id WHERE NOW() < l.completion_date AND c.alias = '" . $selected_category_alias . "'";

  $result = mysqli_query($link, $sql);

  if ($result) {
    $total_rows = mysqli_num_rows($result);
    $pages = intval(round($total_rows / $limit));

    if (isset($_GET["page"])) {
      $page = intval($_GET["page"]);
      $current_page = $page > 0 && $page <= $pages - 1 ? $page : 0;
    }

    $offset = $current_page * $limit;

    $condition = "LIMIT " . $limit . " OFFSET " . $offset;

    $sql = "SELECT
      l.id,
      l.name,
      l.starting_price,
      l.image_url,
      c.name AS 'category',
      l.completion_date
    FROM lots l
      JOIN categories c ON c.id = l.category_id
    WHERE NOW() < l.completion_date AND c.alias = '" . $selected_category_alias . "'" .
    " ORDER BY l.creation_date DESC "  . $condition;

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
  } else {
    $error = mysqli_error($link);
    show_error($error, [
      "categories" => $categories,
      "is_auth" => $is_auth,
      "user_name" => $user_name,
      "user_avatar" => $user_avatar
    ]);
  }
} else {
  $sql = "SELECT
    l.id,
    l.name,
    l.starting_price,
    l.image_url,
    c.name AS 'category',
    l.completion_date
  FROM lots l
    JOIN categories c ON c.id = l.category_id
  WHERE NOW() < l.completion_date
    ORDER BY l.creation_date DESC";

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

$page_content = include_template("templates/index.php", [
  "lots" => $lots,
  "categories" => $categories,
  "selected_category" => get_category_by_alias($selected_category_alias, $categories),
  "pages" => $pages,
  "current_page" => $current_page
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
