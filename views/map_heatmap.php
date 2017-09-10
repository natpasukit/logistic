<?php
  require(__DIR__ . '/../php/logistic_global.php');
  require(__DIR__ . '/../php/authen_redirect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Logistic demo</title>
  <!-- Core css -->
  <link href="/../public/css/bootstrap.min.css" rel="stylesheet">
  <link href="/../public/css/dashboard.css" rel="stylesheet">
  <link rel="stylesheet" href="/../public/css/leaflet.css" />
  <script src="/../public/js/leaflet.js"></script>
  <script src="/../public/js/leaflet-heat.js"></script>
</head>
<style>
    #map { width: 800px; height: 600px; }
    body { font: 16px/1.4 "Helvetica Neue", Arial, sans-serif; }
    .ghbtns { position: relative; top: 4px; margin-left: 5px; }
    a { color: #0077ff; }
</style>
<body>
  <?php require_once(__DIR__ . '/../component/menu_top.php');?>
  <div class="container-fluid">
    <div class="row">
      <?php require_once(__DIR__ . '/../component/menu_left.php');?>
      <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
        <h1>Heat Map</h1>
        <div id="map"></div>
        <script src="/../public/data/heatmapdata.js"></script>
        <script type="text/javascript">
          var map = L.map('map').setView([18.783629,99.001751], 14);
          var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
              attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
              }).addTo(map);

          addressPoints = addressPoints.map(function (p) { return [p[0], p[1]]; });

          var heat = L.heatLayer(addressPoints, {radius: 50}).addTo(map);
      </script>
      </main>
    </div>
  </div>
  <!-- ================================================== -->
  <script src="/../public/js/jquery-3.2.1.min.js"></script>
  <script src="/../public/js/popper.min.js"></script>
  <script src="/../public/js/bootstrap.min.js"></script>
</body>
</html>
