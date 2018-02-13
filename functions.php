<?php
/**
 * Format a number with grouped thousands and add currency sign
 * @param $price
 * @return string
 */
function format_price($price)
{
  $price = number_format(ceil($price), 0, ".",  " ");
  return $price . " " . "₽";
}

/**
 * Get content of template
 * @param $template
 * @param $vars
 * @return string
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
 * Add leading zero to time if necessary
 * @param $time
 * @return string
 */
function format_time($time)
{
  return $time < 10 ? "0" . $time : $time;
}

/**
 * Display formatted time left until midnight
 * @return string
 */
function count_time_until_midnight()
{
  $diff = strtotime("tomorrow midnight") - strtotime("now");
  $seconds = format_time($diff % 60);
  $minutes = format_time(floor($diff / 60) % 60);
  $hours = format_time(floor($diff / (60 * 60)));

  return $hours . ":" . $minutes . ":" . $seconds;
}
