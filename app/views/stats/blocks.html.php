<?php 	echo $this->_render('element', 'stats');?>
<h4>Graph: Blocks generated</h4>
Number of blocks generated from start of bitcoins till today!
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          ['x', 'Blocks'],
		  <?php echo $Graphdata;?>
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 800, height: 400,
                        vAxis: {maxValue: 10}}
                );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
    <div id="visualization" style="width: 500px; height: 400px;"></div>
