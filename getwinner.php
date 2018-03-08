<?php

require_once "init.php";

// Getting winners
$sql = "SELECT u.name, u.email, l.id AS 'lot_id', l.name AS 'lot_name'
            FROM lots AS l
              JOIN rates AS r ON r.lot_id = l.id
              JOIN users AS u ON u.id = r.user_id
            WHERE DATE(l.completion_date) <= DATE(NOW()) AND l.winner_id IS NULL AND r.amount = (SELECT amount FROM rates WHERE lot_id = l.id             ORDER BY id DESC LIMIT 1)";

$result = mysqli_query($link, $sql);

if ($result) {
  $winners = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (count($winners)) {
    // Update lots with their winners
    $sql = "UPDATE lots AS T1,
              (SELECT r.user_id, l.id
                FROM lots AS l
                  JOIN rates AS r ON r.lot_id = l.id
                WHERE DATE(l.completion_date) <= DATE(NOW()) AND l.winner_id IS NULL AND r.amount = (SELECT amount FROM rates WHERE lot_id = l.id             ORDER BY id DESC LIMIT 1)) AS T2
            SET T1.winner_id = T2.user_id
            WHERE T1.id = T2.id";

    $result = mysqli_query($link, $sql);

    if ($result) {
      foreach ($winners as $winner) {
        $body = include_template("templates/email.php", ["winner" => $winner]);

        $transport = new Swift_SmtpTransport('smtp.mail.ru', 465, "ssl");
        $transport -> setUsername("dima716@bk.ru");
        $transport -> setPassword("v3xhf#x!lmAf");

        $message = new Swift_Message("Ваша ставка победила");
        $message->setTo([$winner["email"] => $winner["name"]]);
        $message->setBody($body, "text/html");
        $message->setFrom("dima716@bk.ru", "YetiCave");

        $mailer = new Swift_Mailer($transport);
        $mailer->send($message);
      }
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
  show_error(mysqli_error($link), [
    "categories" => $categories,
    "is_auth" => $is_auth,
    "user_name" => $user_name,
    "user_avatar" => $user_avatar
  ]);
}
