<?php
/**
 * Format a number with grouped thousands and add currency sign
 * @param $price
 * @return string
 */
function format_price($price)
{
  $price = number_format(ceil($price), 0, '.', ' ');
  return $price . ' ' . '₽';
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
    return '';
  }

  if (is_array($vars)) {
    extract($vars);
  }

  ob_start();
  require $template;
  return ob_get_clean();
}
