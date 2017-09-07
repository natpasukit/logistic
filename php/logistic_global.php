<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  require_once __DIR__ . '/monolog_global.php';
  // check session
  if (!isset($_SESSION)){
    session_start();
  }
?>
