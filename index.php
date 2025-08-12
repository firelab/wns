<!DOCTYPE html>
<html>
<head>
    <title>Stats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="styler.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Chart.js 4.4.0 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

<!-- hammer.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

<!-- chartjs-plugin-zoom compatible with Chart.js 4.x -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.2.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

</head>
<body>
<div class="tabledis">
<div class="header-container">
            <h1>Where are people using WindNinja?!</h1>
            <a href="index.php" class="go-home-button">Go Home</a>
        </div>
        

<br>

<!-- <div class="BIG">
    <form method="post" class="form-horizontal">
        <div class="grouper">
            <label for="search">Search By Country, Region, City, Postal Code (no spaces):</label>
            <input type="text" id="search" name="search" value=""> 
        </div>
        <input type="submit" value="Submit">
    </form>
    <form method="post" class="form-horizontal">
        <div class="grouper">
            <label for="year">Search by Year From:</label>
            <input class="inp" type="text" id="year" name="year" value="">
            <label for="year2">To: </label>
            <input class="inp" type="text" id="year2" name="year2" value="">
        </div> 
        <div class="grouper">
            <label for="month">Search by Month From:</label>
            <input class="inp" type="text" id="month" name="month" value="">
            <label for="month2">To:</label>
            <input class="inp" type="text" name="month2" id="month2" value="">
        </div>           
        <div class="grouper">          
            <label for="day">Search by Day From:</label>
            <input class="inp" type="text" id="day" name="day" value="">
            <label for="day2">To:</label>
            <input class="inp" type="text" id="day2" name="day2" value="">
        </div>            
        <input type="submit" value="Submit">
    </form>
</div> -->

<div class = "flexx">
   <div id="map" style="height: 20vh;"></div>
   <canvas id="myChart"  style="width: 15vw;"></canvas>
    <p id="totalRuns2025Display" style="margin-top: 10px;"></p>
    <p id="totalUserDisplay" style="margin-top: 10px;"></p>
    <p id="totalCountryDisplay" style="margin-top: 10px;"></p>

</div>
<br>
<?php include "markers.php"; ?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var totals = <?php echo $totalsJson; ?>;
        var totals1 = <?php echo $totals1Json; ?>;

        var totals2 = <?php echo $totals2Json; ?>;

        var totals3 = <?php echo $totals3Json; ?>;

        var markers = <?php echo $markersJson; ?>;
        var markerszoom1 = <?php echo $markerszoomJson; ?>;
        var timeint = <?php echo $timeintJson; ?>;
        var timeint1 = <?php echo $timeintJson1; ?>;

        var totalUnqiueUsers = <?php echo $uniqueUsersJson; ?>;
        var totalCountries = <?php echo $totalCountriesJson; ?>;
        var totalRuns2025 = <?php echo $totalRuns2025Json; ?>;


        if (markerszoom1.length === 0) {
            var map = L.map('map').fitBounds([
                [24.396308, -125.0],  
                [49.384358, -66.93457] 
            ]);
        } else {
            // Same for markerszoom1 condition
            var map = L.map('map').fitBounds([
                [24.396308, -125.0],
                [49.384358, -66.93457]
            ]);
        }
            
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        markers.forEach(function(marker) { 
            if (marker && marker.lat && marker.lat.split(',').length === 2) {
                var lat = marker.lat.split(',')[0];
                var lon = marker.lat.split(',')[1];
                var popupContent = '<b>Marker Information</b><br>' +
                                'Latitude: ' + lat + '<br>' +
                                'Longitude: ' + lon  + '<br>' + "Total WindNinja Runs: " + marker.total; 
                L.marker([lat, lon]).bindPopup(popupContent).addTo(map);
            }
        });

        let combinedData = totals.map((dateStr, i) => ({
            date: new Date(dateStr),
            cli: totals1[i],
            gui: totals2[i],
            total: totals3[i]
        }));
        combinedData.sort((a, b) => a.date - b.date);

        var dateObjects = combinedData.map(d => d.date);
        var totals1Sorted = combinedData.map(d => d.cli);
        var totals2Sorted = combinedData.map(d => d.gui);
        var totals3Sorted = combinedData.map(d => d.total);

        var maximum = dateObjects[dateObjects.length - 2];
        var minimum = dateObjects[dateObjects.length - 5];
        if (timeint != "") { 
            minimum = new Date(timeint);
            maximum = new Date(timeint1);
        }``
      
 // Chart.js setup
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dateObjects,
            datasets: [
                {
                    label: 'Total Ninja CLI Runs',
                    data: totals1Sorted,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Ninja GUI Runs',
                    data: totals2Sorted,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Ninja Runs',
                    data: totals3Sorted,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                zoom: {
            limits: {
                y: { min: 0 }  // Prevent zooming/panning below 0 on y-axis
            },
                    pan: {
                        enabled: true,
                        mode: 'xy',
                        speed: 2,
                        threshold: 0
                    },
                    zoom: {
                        wheel: { enabled: true },
                        pinch: { enabled: true },
                        mode: 'xy'
                    }
                }
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day',
                        tooltipFormat: 'll'
                    },
                    ticks: {
                        maxTicksLimit: 7,
                        autoSkip: false
                    },
                    min: minimum,
                    max: maximum
                },
                y: {
                    type: 'linear',
                    suggestedMin: 0,  
                    grace: '5%',  
                }
            }
        }
    });

    setTimeout(() => {
        const maxDate = new Date();
        const minDate = new Date();
        minDate.setDate(maxDate.getDate() - 8);
        maxDate.setDate(maxDate.getDate() - 1);


        myChart.zoomScale('x', {
            min: minDate,
            max: maxDate
        });

        myChart.zoom(0.999, 'xy');

    }, 0);

    document.getElementById('totalRuns2025Display').textContent = 
    'Total Runs (Year to date): ' + totalRuns2025.toLocaleString();

    document.getElementById('totalUserDisplay').textContent = 
    'Total Users: ' + totalUnqiueUsers.toLocaleString();

    document.getElementById('totalCountryDisplay').textContent = 
    'Total Countries: ' + totalCountries.toLocaleString();

});
</script>


     <a href="https://ninjastorm.firelab.org/sqlitetest/placeholder.txt" download="stats.txt" class="download-link">
Download Text File of Stats</a>
</body>
</html>
