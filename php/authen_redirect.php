<?php
  require(__DIR__ . '/logistic_global.php');
  // Check empty
  if(empty($_SESSION['login_user']) || empty($_SESSION['user_type'])){
    $isLogin = false;
    $user_name = "guest";
    $user_type = "guest";
    header("Location: ../index.html");
  }else{
    $isLogin = true;
    $user_name = $_SESSION['login_user'];
    $user_type = $_SESSION['user_type'];
  }
?>
