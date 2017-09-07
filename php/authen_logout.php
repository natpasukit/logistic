<?php
  require(__DIR__ . '/logistic_global.php');
  if(session_destroy()){
    $flog->info('Connect session destroy');
    header("Location: ../index.html");
  }else{
    $flog->error('Somethings wrong on logout may not logout');
  }
?>
