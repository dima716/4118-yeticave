<?php
require_once "init.php";

if (!$is_auth) {
  header("HTTP/1.0 403 Forbidden");
  print("Эта страница доступна только для зарегистрированных пользователей");
  die();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $rate = $_POST;
  $errors = [];

  if (empty($_POST["rate"]) && $_POST["rate"] !== '0') {
    $errors["rate"] = "Это поле надо заполнить";
  }

  if (!is_numeric($_POST["rate"])) {
    $errors["rate"] = isset($errors["rate"]) ? $errors["rate"] : "Это поле должно быть числом";
  } else if ($_POST["rate"] <= 0) {
    $errors["rate"] = isset($errors["rate"]) ? $errors["rate"] : "Это поле должно быть больше нуля";
  } else if ($_POST["rate"] < $_POST["current_price"] + $_POST["rate_step"]) {
    $errors["rate"] = isset($errors["rate"]) ? $errors["rate"] : "Значение должно быть больше, чем текущая цена лота + минимальная ставка";
  }

  if (count($errors)) {
    $sql = "SELECT
      l.id,
      l.name,
      l.description,
      l.starting_price,
      l.rate_step,
      l.image_url,
      l.author_id,
      c.name AS 'category',
      l.completion_date
    FROM lots l
      JOIN categories c ON c.id = l.category_id
    WHERE l.id = " . $rate["lot_id"];

    $result = mysqli_query($link, $sql);

    if ($result) {
      if (!mysqli_num_rows($result)) {
        header("HTTP/1.0 404 Not Found");
        show_error("Лот с этим идентификатором не найден", [
          "categories" => $categories,
          "is_auth" => $is_auth,
          "user_name" => $user_name,
          "user_avatar" => $user_avatar
        ]);
      } else {
        $lot = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $sql = "SELECT 
                        r.id,
                        r.placement_date, 
                        r.amount, 
                        r.user_id,
                        r.lot_id,
                        u.name AS 'user_name'
                      FROM rates r
                        JOIN users u ON u.id = r.user_id 
                      WHERE r.lot_id = " . $rate["lot_id"] .
          " ORDER BY r.placement_date DESC";

        $result = mysqli_query($link, $sql);

        if ($result) {
          $rates = mysqli_fetch_all($result, MYSQLI_ASSOC);

          $is_lot_completed = strtotime("now") > strtotime($lot["completion_date"]);
          $is_lot_created_by_current_user = $lot["author_id"] === $user_id;
          $is_current_user_made_rate = false;

          $lot["current_price"] = $lot["starting_price"];

          foreach ($rates as $rate) {
            if ($rate["user_id"] === $user_id) {
              $is_current_user_made_rate = true;
            }

            if ($rate["amount"] > $lot["current_price"]) {
              $lot["current_price"] = $rate["amount"];
            }
          }

          foreach ($rates as $rate) {
            if ($rate["user_id"] === $user_id) {
              $is_current_user_made_rate = true;
            }
          }

          $is_rates_shown = $is_auth &&
            !$is_lot_completed &&
            !$is_lot_created_by_current_user &&
            !$is_current_user_made_rate;

          $page_content = include_template("templates/lot.php",
            [
              "errors" => $errors,
              "lot" => $lot,
              "is_rates_shown" => $is_rates_shown,
              "rates" => $rates
            ]);

          $layout_content = include_template("templates/layout.php", [
            "page_title" => htmlspecialchars($lot["name"]),
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
      }
    } else {
      $error = mysqli_error($link);
      show_error($error, [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    }
  } else {
    $sql = "INSERT INTO rates (
      placement_date, 
      amount, 
      user_id,
      lot_id
    ) VALUES (?, ?, ?, ?)";

    $data = [
      date("Y-m-d H:i:s"),
      $_POST["rate"],
      $user_id,
      $rate["lot_id"]
    ];

    $stmt = db_get_prepare_stmt(
      $link,
      $sql,
      $data
    );

    $res = mysqli_stmt_execute($stmt);

    if ($res) {
      header("Location: lot.php?id=" . $rate["lot_id"]);
      exit();
    } else {
      show_error(mysqli_error($link), [
        "categories" => $categories,
        "is_auth" => $is_auth,
        "user_name" => $user_name,
        "user_avatar" => $user_avatar
      ]);
    }
  }
} else {
  header("HTTP/1.0 404 Not Found");
  show_error("Страница не найдена", [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
}
