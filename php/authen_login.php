<?php
  require(__DIR__ . '/logistic_global.php');
  require( __DIR__ . '/db_connection.php');
  $error=''; // Variable To Store Error Message
  if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['usertype'])) {
      $error = "Username or Password or Type is invalid";
      $flog->error($error);
    }else{
      $username=$_POST['username'];
      $password=$_POST['password'];
      $usertype=$_POST['usertype'];
      // To protect MySQL injection for Security purpose
      $username = stripslashes($username);
      $password = stripslashes($password);
      $usertype = stripslashes($usertype);
      $username = mysqli_real_escape_string($conn,$username);
      $password = mysqli_real_escape_string($conn,$password);
      $usertype = mysqli_real_escape_string($conn,$usertype);
      $password = md5($password);
      $result = mysqli_query($conn,"select * from login where password='$password' AND username='$username' AND usertype='$usertype'");
      $rows = mysqli_num_rows($result);
      $flog->info($rows);
      if ($rows == 1) {
        $_SESSION['login_user']=$username;
        $_SESSION['user_type']=$usertype;
        header("location: /../index.html");
      }else{
        $error = "somethings went wrong here";
        $flog->error($error);
      }
      mysqli_close($conn);
    }
  }
?>
