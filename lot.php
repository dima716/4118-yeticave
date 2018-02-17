<?php
require_once "data.php";
require_once "functions.php";


if (isset($_GET)) {
  if (array_key_exists($_GET['id'], $ads)) {
    $lot = $ads[$_GET['id']];
    $page_content = include_template("templates/lot.php", ["lot" => $lot]);
    $layout_content = include_template("templates/layout.php", [
      "is_auth" => $is_auth,
      "user_name" => $user_name,
      "user_avatar" => $user_avatar,
      "page_title" => htmlspecialchars($lot["name"]),
      "page_content" => $page_content,
      "categories" => $categories
    ]);
    print($layout_content);
  } else {
    header("HTTP/1.0 404 Not Found");
    print("Lot does not exist");
  }
}
