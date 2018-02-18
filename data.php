<?php
date_default_timezone_set('Europe/Moscow');

$is_auth = (bool)rand(0, 1);
$user_name = "Константин";
$user_avatar = "img/user.jpg";

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
$ads = [
  [
    "name" => "2014 Rossignol District Snowboard",
    "category" => $categories[0],
    "price" => 10999,
    "url" => "img/lot-1.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "DC Ply Mens 2016/2017 Snowboard",
    "category" => $categories[0],
    "price" => 159999,
    "url" => "img/lot-2.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
    "category" => $categories[1],
    "price" => 8000,
    "url" => "img/lot-3.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Ботинки для сноуборда DC Mutiny Charocal",
    "category" => $categories[2],
    "price" => 10999,
    "url" => "img/lot-4.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Куртка для сноуборда DC Mutiny Charocal",
    "category" => $categories[3],
    "price" => 7500,
    "url" => "img/lot-5.jpg",
    "description" => "Здесь будет описание лота"
  ],
  [
    "name" => "Маска Oakley Canopy",
    "category" => $categories[5],
    "price" => 5400,
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
