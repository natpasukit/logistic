<?php
  // require log system
  require(__DIR__ . '/logistic_global.php');
  //credent info
  $servername = "localhost";
  $username = "natpaphon";
  $password = "sukitpaneenit";
  $dbname = "logistic";
  // connect
  $conn = new mysqli($servername, $username ,$password);
  // Check connection
  if ($conn->connect_error) {
    $flog->alert('Database fail to connect');
    die("Connection failed: " . $conn->connect_error);
  }else{
    $flog->info('Database connected successfully');
    mysqli_select_db($conn,$dbname);
  }
?>
