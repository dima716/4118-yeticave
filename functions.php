<?php
function format_price($price)
{
  $price = number_format(ceil($price), 0, '.', ' ');
  return $price . ' ' . '₽';
}

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
