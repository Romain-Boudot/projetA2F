<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/cdn/Chart.bundle.min.js"></script>
    <script src="/cdn/Chart.js"></script>
    <style>
    canvas{
        max-height: 300px !important;
        max-width: 300px !important;
    }
    .graphWrapper{
        max-height: 500px;
        max-width: 500px;
    }
    </style>
    <title>test</title>
</head>
<body>

    <div class="graphWrapper">
        
        <canvas id="chart-p1" class="chartjs"></canvas>
        
        <script>  
            var co1 = new chartOptionBaton();
            co1.chart.data.datasets[0].data = [1.2, null, 3];
            co1.chart.data.labels = ["coucou", "test", "bruh"];
            co1.chart.options.scales.yAxes[0].ticks.max = 4;
            var t = new Chart(document.getElementById("chart-p1"), co1.option);
        </script>
    
    </div>

</body>
</html>