<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 12],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title':'How Much Pizza I Ate Last Night',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>


 <script type="text/javascript">

 var c0 =parseInt("<?php echo $c0 ?>");
 var c1 =parseInt("<?php echo $c1 ?>");
 var c3 =parseInt("<?php echo $c3 ?>");
 var c4 =parseInt("<?php echo $c4 ?>");
 var c5 =parseInt("<?php echo $c5 ?>");
 var c6 =parseInt("<?php echo $c6 ?>");
 var c7 =parseInt("<?php echo $c7 ?>");
 var c8 =parseInt("<?php echo $c8 ?>");
 var c9 =parseInt("<?php echo $c9 ?>");
/*
 var c0 =1;
 var c1 =2;
 var c3 =3;
 var c4 =4;
 var c5 =4;
 var c6 =4;
 var c7 =4;
 var c8 =4;
 var c9 =4;*/
 google.load('visualization', '1.0', {'packages':['corechart']});


 google.setOnLoadCallback(drawChart);
 

 function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['These', c0],
          ['Article dans une revue', c1],
          ['Communications avec actes', c3],
          ['Communications sans actes', c4],
          ['Conférence invitée', c5],
          ['Ouvrage', c6],
          ['Chapitre douvrage', c7],
          ['Direction douvrage', c8],
          ['Autre type de publication', c9]
        ]);

        // Set chart options
        var options = {'title':'Répartition publication',
                       'width':900,
                       'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<div id="chart_div"></div>