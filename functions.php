<?php
require_once "mysql_helper.php";

/**
 * Format a number with grouped thousands and add currency sign
 * @param integer $price price of a lot
 * @return string formatted price with grouped thousands and currency sign
 */
function format_price($price)
{
  $price = number_format(ceil($price), 0, ".",  " ");
  return $price . " " . "₽";
}

/**
 * Get content of template
 * @param string $template path to the template
 * @param array $vars all variables that will be used inside template
 * @return string html representation of template
 */
function include_template($template, $vars)
{
  if (!file_exists($template)) {
    return "";
  }

  if (is_array($vars)) {
    extract($vars);
  }

  ob_start();
  require $template;
  return ob_get_clean();
}

/**
 * Display formatted time left until midnight
 * @return string how much time left until midnight in format HH:MM:SS
 */
function count_time_until_midnight()
{
  $now = new DateTime(date(DATE_ATOM));
  $then = new DateTime(date(DATE_ATOM, mktime(24, 0, 0)));

  $difference = $then->diff($now);

  return $difference->format("%H:%I:%S");
}

function show_error($error, $vars) {
  header("HTTP/1.0 500 Internal Server Error");
  $page_content = include_template("templates/error.php", ["error" => $error]);
  $layout_content = include_template("templates/layout.php", [
    "page_title" => "Ошибка",
    "page_content" => $page_content,
    "categories" => $vars["categories"],
    "is_auth" => $vars["is_auth"],
    "user_name" => $vars["user_name"],
    "user_avatar" => $vars["user_avatar"]
  ]);
  print($layout_content);
  die();
}
