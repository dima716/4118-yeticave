<?php
require_once "vendor/autoload.php";
require_once "functions.php";

date_default_timezone_set("Europe/Moscow");

session_start();

$is_auth = isset($_SESSION["user"]);
$user_name = null;
$user_avatar = null;
$user_id = null;

if ($is_auth) {
  $user_name = $_SESSION["user"]["name"];
  $user_avatar = $_SESSION["user"]["avatar"];
  $user_id = $_SESSION["user"]["id"];
}

if (file_exists("config/db.php")) {
  $db = require_once "config/db.php";
} else {
  $dbmessage = include_template("templates/db.php", []);
  print($dbmessage);
  die();
}

$link = mysqli_connect($db["host"], $db["user"], $db["password"], $db["database"]);
mysqli_set_charset($link, "utf8");

$categories = [];

if (!$link) {
  $error = mysqli_connect_error();
  show_error($error, [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
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
      "user_name" => $user_name,
      "user_avatar" => $user_avatar
    ]);
  }
}
