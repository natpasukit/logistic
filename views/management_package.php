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
          <h1>Package and Customer Management Dash</h1>
          <h2>Package Type Table</h2>
          <div class="table-responsive">
            <table class="table table-striped" id="table-package">
            </table>
          </div>
          <ul class="pagination">
            <!-- <li><a href="#">1</a></li> -->
          </ul>
          <h2>Customer Table</h2>
          <div class="table-responsive">
            <table class="table table-striped" id="table-customer">
            </table>
          </div>
        </main>
      </div>
    </div>
    <!-- ================================================== -->
    <script src="/../public/js/jquery-3.2.1.min.js"></script>
    <script src="/../public/js/popper.min.js"></script>
    <script src="/../public/js/bootstrap.min.js"></script>
    <script src="/../component/js/table_script.js"></script>
    <script>
    $(document).ready(function() {
      var table1 = '#table-package';
      var table2 = '#table-customer';
      var id1 = 'packageId';
      var id2 = 'customerId';
      $.get("/../api/pkg",function(data){
        var cartypeJSON = data;
        // console.log(cartypeJSON); // for Dev
        table_create(cartypeJSON,table1,id1); // calling from table_script

      });
      $.get("/../api/customer",function(data){
        var cartypeJSON = data;
        // console.log(cartypeJSON); // for dev
        table_create(cartypeJSON,table2,id2); // calling from table_script
      });
    });
    </script>
  </body>
</html>
