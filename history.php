<?php
require_once "data.php";
require_once "functions.php";

if (isset($_COOKIE["viewed_lots"])) {
  $viewed_lots_indexes = json_decode($_COOKIE["viewed_lots"]);
  $viewed_lots = [];

  foreach ($viewed_lots_indexes as $viewed_lot_index) {
    if (isset($ads[$viewed_lot_index])) {
      // add index property for every viewed lot to form correct link to the lot
      $ads[$viewed_lot_index]["index"] = $viewed_lot_index;
      $viewed_lots[] = $ads[$viewed_lot_index];
    }
  }

  $page_content = include_template("templates/history.php", ["viewed_lots" => $viewed_lots]);

  $layout_content = include_template("templates/layout.php", [
    "page_title" => "Главная",
    "page_content" => $page_content,
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
  ]);

  print($layout_content);
} else {
  print("You haven't viewed any lot yet.");
}
