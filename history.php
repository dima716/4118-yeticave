<?php
require_once "init.php";

if (isset($_COOKIE["viewed_lots"])) {
  $viewed_lots_indexes = json_decode($_COOKIE["viewed_lots"]);

  $viewed_lots = [];

  $sql = "SELECT   
    l.id,
    l.name,
    l.starting_price,
    l.image_url,
    c.name AS 'category',
    l.completion_date  
    FROM lots l
      JOIN categories c ON c.id = l.category_id
    WHERE l.id IN (" . implode(",", $viewed_lots_indexes) . ")";

  $result = mysqli_query($link, $sql);

  if ($result) {
    if (!mysqli_num_rows($result)) {
      header("HTTP/1.0 404 Not Found");
      show_error("Лоты с данными идентификаторами не найдены", [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    } else {
      $viewed_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $page_content = include_template("templates/history.php", ["viewed_lots" => $viewed_lots]);
      $layout_content = include_template("templates/layout.php", [
        "page_title" => "Главная",
        "page_content" => $page_content,
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);

      print($layout_content);
    }
  } else {
    show_error(mysqli_error($link), [
      "categories" => $categories,
      "is_auth" => $is_auth,
      "user_name" => $user_name,
      "user_avatar" => $user_avatar
    ]);
  }
} else {
  show_error("Вы не просмотрели ни одного лота", [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
}
