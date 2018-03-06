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
  print("Пожалуйста, создайте папку config в корне проекта и в ней файл db.php, указав в нем необходимые данные для доступа к бд:<br />");
  print("<br/>");
  print("host - адрес, где находится сервер<br />");
  print("user - имя пользователя для подключения<br />");
  print("password -  пароль пользователя<br />");
  print("database - имя базы данных для работы<br />");
  print("<br/>");
  print("Пример файла: <br />");
  print("<br/>");
  print("
  <code>
    &lt;?php </br>
    return [</br>
      &quot;host&quot; =&gt; &quot;localhost&quot;,</br>
      &quot;user&quot; =&gt; &quot;root&quot;,</br>
      &quot;password&quot; =&gt; &quot;password&quot;,</br>
      &quot;database&quot; =&gt; &quot;yeticave&quot;</br>
    ];
   </code>
  ");
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
