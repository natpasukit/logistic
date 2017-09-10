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
          <h1>Car Management Dash</h1>
          <h2>Car Type Table</h2>
          <div class="table-responsive">
            <table class="table table-striped" id="table-cartype">
            </table>
          </div>
          <h2>Car Table</h2>
          <div class="table-responsive">
            <table class="table table-striped" id="table-car">
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
      var table1 = '#table-cartype';
      var table2 = '#table-car';
      var id1 = 'carTypeId';
      var id2 = 'carId';
      $.ajax({
            type: 'GET',
            url: '/../api/cartype',
            info:{namekey:'cartype' , url:'/../api/cartype'},
            success: function (data) {
              var cartypeJSON = data;
              table_create(cartypeJSON,table1,id1,this.info);
            }
        });
        $.ajax({
              type: 'GET',
              url: '/../api/car',
              info:{namekey:'car' , url:'/../api/car'},
              success: function (data) {
                var carJSON = data;
                table_create(carJSON,table2,id2,this.info);
              }
          });
    });
    </script>
  </body>
</html>
