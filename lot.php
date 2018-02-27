<?php
require_once "data.php";
require_once "functions.php";

session_start();

if (isset($_GET)) {
  $lot_id = $_GET["id"];

  if (array_key_exists($lot_id, $ads)) {
    $lot = $ads[$lot_id];
    $page_content = include_template("templates/lot.php", ["lot" => $lot, "bets" => $bets]);
    $layout_content = include_template("templates/layout.php", [
      "page_title" => htmlspecialchars($lot["name"]),
      "page_content" => $page_content,
      "categories" => $categories
    ]);

    $viewed_lots_indexes = [];

    if (isset($_COOKIE["viewed_lots"])) {
      $viewed_lots_indexes = json_decode($_COOKIE["viewed_lots"]);
    }

    $viewed_lots_indexes[] = $lot_id;
    $viewed_lots_indexes = array_unique($viewed_lots_indexes);

    setcookie("viewed_lots", json_encode($viewed_lots_indexes));
    print($layout_content);
  } else {
    header("HTTP/1.0 404 Not Found");
    print("Lot does not exist");
  }
}
