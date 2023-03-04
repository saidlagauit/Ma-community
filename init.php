<?php

  // Start Connect to database
  include 'connect.php';

  // Start directory includes
  $func = 'includes/functions/';
  $tpl  = 'includes/templates/';
  $css = 'layout/css/';
  $js = 'layout/js/';
  $img = 'layout/img/';

  // Start include Files
  include $func . 'function.php';
  include $tpl . 'header.php';
?>