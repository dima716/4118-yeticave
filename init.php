<?php
require_once "functions.php";

date_default_timezone_set("Europe/Moscow");

session_start();

$is_auth = isset($_SESSION["user"]);
$user_name = null;
$user_avatar = null;

if ($is_auth) {
  $user_name = $_SESSION["user"]["name"];
  $user_avatar = $_SESSION["user"]["avatar"];
}

$db = require_once "config/db.php";

$link = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
mysqli_set_charset($link, "utf8");

$categories = [];

if (!$link) {
  $error = mysqli_connect_error();
  show_error($error, [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name
  ]);
} else {
  $sql = "SELECT id, name, alias FROM categories";
  $result = mysqli_query($link, $sql);

  if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
  } else {
    $error = mysqli_error($link);
    show_error($error, [
      "categories" => $categories,
      "is_auth" => $is_auth,
      "user_name" => $user_name
    ]);
  }
}

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
  ["name" => "Иван", "price" => 11500, "ts" => strtotime("-" . rand(1, 50) . " minute")],
  ["name" => "Константин", "price" => 11000, "ts" => strtotime("-" . rand(1, 18) . " hour")],
  ["name" => "Евгений", "price" => 10500, "ts" => strtotime("-" . rand(25, 50) . " hour")],
  ["name" => "Семён", "price" => 10000, "ts" => strtotime("last week")]
];
