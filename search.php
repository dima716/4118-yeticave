<?php
require_once "init.php";

$lots = [];
$search = '';
$limit = 9;
$offset = 0;
$current_page = 0;
$pages = 1;

if (!empty($_GET["search"])) {
  $search = mysqli_escape_string($link, trim($_GET["search"]));

  $sql = "SELECT * FROM lots WHERE name LIKE '%" . $search . "%'" . " OR description LIKE '%" . $search . "%'";
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
    WHERE l.name LIKE '%" . $search . "%'" . " OR l.description LIKE '%" . $search . "%'" .
      " ORDER BY l.creation_date DESC " . $condition;

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
}

$page_content = include_template("templates/search.php", [
  "search" => $search,
  "lots" => $lots,
  "pages" => $pages,
  "current_page" => $current_page
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
