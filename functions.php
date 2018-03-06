<?php
require_once "mysql_helper.php";

/**
 * Format a number with grouped thousands and add currency sign
 * @param integer $price price of a lot
 * @return string formatted price with grouped thousands and currency sign
 */
function format_price($price)
{
  $price = number_format(ceil($price), 0, ".", " ");
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
  $result = "";

  if (file_exists($template)) {
    if (is_array($vars)) {
      extract($vars);
    }

    ob_start();
    require $template;
    $result = ob_get_clean();
  }

  return $result;
}

/**
 * Display formatted time left until end of completion date
 * @param $end_date completion date
 * @return string how much time left until end of completion date in format HH:MM:SS
 */
function count_time_until_end($end_date)
{
  $now = new DateTime("now");
  $then = new DateTime(date("Y-m-d", strtotime($end_date)));

  return $now < $then ? $then->diff($now)->format("%a д. %H:%I:%S") : "0 д. 00:00:00";
}

/**
 * Show error page template
 * @param $error string error message
 * @param $vars array list of variables to pass in template
 */
function show_error($error, $vars)
{
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

/**
 * Check if date is valid
 * @param $date date to check
 * @return bool result of checking
 */
function is_date_valid($date)
{
  $is_date_valid = false;

  if (strtotime($date)) {
    list($day, $month, $year) = explode('.', $date);
    $is_date_valid = checkdate($month, $day, $year);
  }

  return $is_date_valid;
}

/**
 * Check if date has a valid format of DD.MM.YYYY
 * @param $date date to check
 * @return bool result of checking
 */
function is_date_format_valid($date)
{
  return preg_match("/(0[1-9]|[12][0-9]|3[01])[ \.](0[1-9]|1[012])[ \.](19|20)\d\d/", $date) !== 0;
}

/**
 * @param string $date_a first date for comparing
 * @param string $date_b second date for comparing
 * @param string $operator math comparison operator
 * @return bool|null result of checking
 */
function compare_dates_without_time($date_a, $date_b, $operator)
{
  $result = null;
  $date_a_without_time = new DateTime(date("Y-m-d", strtotime($date_a)));
  $date_b_without_time = new DateTime(date("Y-m-d", strtotime($date_b)));

  switch ($operator) {
    case "<":
      $result = $date_a_without_time < $date_b_without_time;
      break;
    case ">":
      $result = $date_a_without_time > $date_b_without_time;
      break;
    case "=":
      $result = $date_a_without_time == $date_b_without_time;
      break;
    case "<=":
      $result = $date_a_without_time <= $date_b_without_time;
      break;
    case ">=":
      $result = $date_a_without_time >= $date_b_without_time;
      break;
  }

  return $result;
}

/**
 * @param string $alias
 * @param array $categories
 * @return array | null
 */
function get_category_by_alias($alias, $categories) {
  $result = null;

  foreach($categories as $category) {
    if ($category["alias"] === $alias) {
      $result = $category;
    }
  }
  return $result;
}

/**
 * @param int $category_id
 * @param array $categories
 * @return bool
 */
function is_category_exists($category_id, $categories) {
  return in_array($category_id, array_column($categories, "id"));
}
