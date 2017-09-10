<?php
  require(__DIR__ . '/../php/logistic_global.php');
  require(__DIR__ . '/../php/authen_redirect.php');
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Logistic demo</title>
  <!-- Core css -->
  <link href="/../public/css/bootstrap.min.css" rel="stylesheet">
  <link href="/../public/css/dashboard.css" rel="stylesheet">
</head>
  <body>
    <?php require_once(__DIR__ . '/../component/menu_top.php');?>
    <div class="container-fluid">
      <div class="row">
        <?php require_once(__DIR__ . '/../component/menu_left.php');?>
        <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
          <h1>Dashboard</h1>
          <h2>Section title</h2>
        </main>
      </div>
    </div>
    <!-- ================================================== -->
    <script src="/../public/js/jquery-3.2.1.min.js"></script>
    <script src="/../public/js/popper.min.js"></script>
    <script src="/../public/js/bootstrap.min.js"></script>
  </body>
</html>
