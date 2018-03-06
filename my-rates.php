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

$sql = "SELECT r.amount, 
               r.placement_date,
               l.id AS 'lot_id',
               l.name AS 'lot_name',
               l.image_url AS 'lot_image_url', 
               l.winner_id,
               l.completion_date,
               c.name AS 'category',
               u.contacts AS 'author_contacts'
        FROM rates r
          JOIN lots l ON l.id = r.lot_id
          JOIN categories c ON c.id = l.category_id
          JOIN users u ON u.id = l.author_id
        WHERE r.user_id = " . $user_id .
        " ORDER BY l.winner_id, r.placement_date DESC";

$result = mysqli_query($link, $sql);

if ($result) {
  $rates = mysqli_fetch_all($result, MYSQLI_ASSOC);

  foreach($rates as &$rate) {
    $rate["is_winner"] = $rate["winner_id"] === $user_id;
    $rate["is_completed"] = compare_dates_without_time("today", $rate["completion_date"], ">=");
  }

  $page_content = include_template("templates/my-rates.php", [
    "rates" => $rates
  ]);

  $layout_content = include_template("templates/layout.php", [
    "page_title" => "Мои лоты",
    "page_content" => $page_content,
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);

  print($layout_content);
} else {
  $error = mysqli_error($link);
  show_error($error, [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
}

