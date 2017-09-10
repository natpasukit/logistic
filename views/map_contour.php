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
          <h1>Contour Distance</h1>
          <svg width="960" height="500"></svg>
          <script src="https://d3js.org/d3.v4.min.js"></script>
          <script src="https://d3js.org/d3-contour.v1.min.js"></script>
          <script>
          var svg = d3.select("svg"),
              width = +svg.attr("width"),
              height = +svg.attr("height"),
              margin = {top: 20, right: 30, bottom: 30, left: 40};
          var x = d3.scaleLinear()
              .rangeRound([margin.left, width - margin.right]);
          var y = d3.scaleLinear()
              .rangeRound([height - margin.bottom, margin.top]);
          d3.tsv("/../public/data/faithful.tsv", function(d) {
            d.latitude = +d.latitude;
            d.longtitude = +d.longtitude;
            return d;
          }, function(error, faithful) {
            if (error) throw error;

            x.domain(d3.extent(faithful, function(d) { return d.longtitude; })).nice();
            y.domain(d3.extent(faithful, function(d) { return d.latitude; })).nice();

            svg.insert("g", "g")
                .attr("fill", "none")
                .attr("stroke", "steelblue")
                .attr("stroke-linejoin", "round")
              .selectAll("path")
              .data(d3.contourDensity()
                  .x(function(d) { return x(d.longtitude); })
                  .y(function(d) { return y(d.latitude); })
                  .size([width, height])
                  .bandwidth(40)
                (faithful))
              .enter().append("path")
                .attr("d", d3.geoPath());

            svg.append("g")
                .attr("stroke", "white")
              .selectAll("circle")
              .data(faithful)
              .enter().append("circle")
                .attr("cx", function(d) { return x(d.longtitude); })
                .attr("cy", function(d) { return y(d.latitude); })
                .attr("r", 2);

            svg.append("g")
                .attr("transform", "translate(0," + (height - margin.bottom) + ")")
                .call(d3.axisBottom(x))
              .select(".tick:last-of-type text")
              .select(function() { return this.parentNode.appendChild(this.cloneNode()); })
                .attr("y", -3)
                .attr("dy", null)
                .attr("font-weight", "bold")
                .text("Longtitude");

            svg.append("g")
                .attr("transform", "translate(" + margin.left + ",0)")
                .call(d3.axisLeft(y))
              .select(".tick:last-of-type text")
              .select(function() { return this.parentNode.appendChild(this.cloneNode()); })
                .attr("x", 3)
                .attr("text-anchor", "start")
                .attr("font-weight", "bold")
                .text("Latitude");
          });
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
