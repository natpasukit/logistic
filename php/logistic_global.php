<?php
  require_once __DIR__ . '/monolog_global.php';
  // check session
  if (!isset($_SESSION)){
    $flog->info('Non session were set');
    session_start();
  }
?>
