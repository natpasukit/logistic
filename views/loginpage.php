<?php
  require(__DIR__ . '/../php/logistic_global.php');
  require_once(__DIR__ . '/../php/authen_login.php');
  if(isset($_SESSION['login_user'])){
    header("location: ../index.html");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../public/css/animate.css" rel="stylesheet">
    <link href="../public/css/custom.css" rel="stylesheet">
</head>
<body class="login">
  <div class="login_wrapper">
    <div class="animate form login_form">
      <section class="login_content">
        <form action="" method="post">
          <h1>Login Form</h1>
          <input id="name" name="username" type="text" class="form-control" placeholder="Username" required="true" />
          <input id="password" name="password" type="password" class="form-control" placeholder="Password" required="true" />
          <input id="usertype" name="usertype" type="text" class="form-control" placeholder="usertype" required="true" />
          <div class="clearfix"></div>
          <div class="separator">
            <center><input class="btn btn-default submit" name="submit" type="submit" value="Login"><br></center>
            <p class="change_link">New to site? Contact natpa for demo</p>
            <div class="clearfix"></div>
            <div>
              <h1><i class="fa fa-car"></i> Natpaphon Sukitpaneenit</h1>
              <p>©2016 All Rights Reserved.</p>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
</body>
</html>
