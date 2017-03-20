
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotatedtimeline']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var options = {};

      options.colors = ['blue', 'green'];
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Datum');
        data.addColumn('number', 'Celkem');
        data.addColumn('string', 'title1');
        data.addColumn('string', 'text1');
        data.addColumn('number', 'Spravne');
        data.addColumn('string', 'title2');
        data.addColumn('string', 'text2');
        data.addRows([
        <?php
      
        $q = mysqli_query(DATABASE::getDb(), "SELECT sum(spravne) as spravne, sum(spatne) as spatne, cas FROM `vysledky` group by DATE(cas)");
        
        while ($v = mysqli_fetch_array($q)){
            echo "[new Date(".(Date("Y, n-1, j", strtotime($v["cas"])))."), ";
            echo $v["spravne"]+$v["spatne"].", undefined, undefined, ".$v["spravne"].", undefined, undefined],\n";
        }
        ?>
         
         
        ]);

        var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('chart_div'), color=["red", "green"]);
        chart.draw(data, options);
      }
    </script>
    <div id='chart_div' style='width: 500px; height: 300px;'></div>

