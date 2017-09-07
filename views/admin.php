<?php
  require(__DIR__ . '/../php/logistic_global.php');
  require(__DIR__ . '/../php/authen_redirect.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php include(__DIR__ . '/../component/header.php'); // Header component include?>
<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="/../pages/adminIndex.php" class="site_title"><i class="fa fa-paw"></i> <span>Demo</span></a>
          </div>
          <!-- sidebar menu -->
          <?php include '/../component/sideMenu.php';
          include '/../component/sidefootMenu.php';?>
          <!-- /menu footer buttons -->
          <?php include '/../component/sidefootMenu.php';?>
          <!-- /menu footer buttons -->
        </div>
      </div>
      <!-- top navigation -->
      <?php include '../component/topMenu.php';?>
      <div class="right_col" role="main">
        <div class="">
          <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                <div class="count"></div>
                <h3>Total Transaction</h3>
                <p>all transaction</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-comments-o"></i></div>
                <div class="count"></div>
                <h3>Wait for info</h3>
                <p>Wait for info transaction</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                <div class="count"></div>
                <h3>On route</h3>
                <p>On route , wait for deploy</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i></div>
                <div class="count"> </div>
                <h3>Total complete</h3>
                <p>Total complete transaction</p>
              </div>
            </div>
          </div>
      <div class="mid_col" role="main">
        <div class="">
        <!-- small title -->
          <div class="page-title">
            <div class="title_left">
              <h3>Heat Map data<small> Base on all transaction</small></h3>
            </div>
            <div id="map"></div>
            <script src="/../public/js/heatmapdata.js"></script>
            <script type="text/javascript">
              var map = L.map('map').setView([18.783629,99.001751], 14);
              var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                  attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                  }).addTo(map);
              addressPoints = addressPoints.map(function (p) { return [p[0], p[1]]; });
              var heat = L.heatLayer(addressPoints, {radius: 50}).addTo(map);
          </script>
          </div>
          <!--/small title-->
          <div class="clearfix"></div>
        </div>
      </div>
        </div>
      </div>
      <footer>
        <div class="pull-right">
          Logistic Advisor <a href="http://natpaphon.arg.in.th">Natpa wwww</a>
        </div>
        <div class="clearfix"></div>
      </footer>
    </div>
  </div>
</body>
</html>
