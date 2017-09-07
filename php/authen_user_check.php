<?php
  require(__DIR__ . '/logistic_global.php');
  // Check empty
  if(empty($_SESSION['login_user']) || empty($_SESSION['user_type'])){
    $isLogin = false;
    $user_name = "guest";
    $user_type = "guest";
  }else{
    $isLogin = true;
    $user_name = $_SESSION['login_user'];
    $user_type = $_SESSION['user_type'];
  }
  // AJAX call
  header('Content-Type: application/json');
  echo json_encode(
    array('isLogin'=>$isLogin,
          'user_name'=>$user_name,
          'user_type'=>$user_type));
  exit(0);
?>
