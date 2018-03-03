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

$ads = [
  [
    "name" => "2014 Rossignol District Snowboard",
    "category" => $categories[0]["name"],
    "price" => 10999,
    "rate" => 10999,
    "url" => "img/lot-1.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "DC Ply Mens 2016/2017 Snowboard",
    "category" => $categories[0]["name"],
    "price" => 159999,
    "rate" => 159999,
    "url" => "img/lot-2.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
    "category" => $categories[1]["name"],
    "price" => 8000,
    "rate" => 8000,
    "url" => "img/lot-3.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Ботинки для сноуборда DC Mutiny Charocal",
    "category" => $categories[2]["name"],
    "price" => 10999,
    "rate" => 10999,
    "url" => "img/lot-4.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Куртка для сноуборда DC Mutiny Charocal",
    "category" => $categories[3]["name"],
    "price" => 7500,
    "rate" => 7500,
    "url" => "img/lot-5.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Маска Oakley Canopy",
    "category" => $categories[4]["name"],
    "price" => 5400,
    "rate" => 5400,
    "url" => "img/lot-6.jpg",
    "description" => "Здесь будет описание лота"
  ]
];

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
  ["name" => "Иван", "price" => 11500, "ts" => strtotime("-" . rand(1, 50) . " minute")],
  ["name" => "Константин", "price" => 11000, "ts" => strtotime("-" . rand(1, 18) . " hour")],
  ["name" => "Евгений", "price" => 10500, "ts" => strtotime("-" . rand(25, 50) . " hour")],
  ["name" => "Семён", "price" => 10000, "ts" => strtotime("last week")]
];

// пользователи для аутентификации
$users = [
  [
    'email' => 'ignat.v@gmail.com',
    'name' => 'Игнат',
    'password' => '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'
  ],
  [
    'email' => 'kitty_93@li.ru',
    'name' => 'Леночка',
    'password' => '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'
  ],
  [
    'email' => 'warrior07@mail.ru',
    'name' => 'Руслан',
    'password' => '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW'
  ]
];
