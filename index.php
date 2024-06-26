<!DOCTYPE html>
<html>
<head>
    <title>Stats</title>
    <style>


/* Styles for the 'tabledis' table display */
.tabledis {
    height: 95vh; /* Full height of the viewport minus padding and margin */
    width: 90%; /* 90% of the available width */
    max-width: 90vw; /* Maximum width to maintain readability */
    margin:  auto; /* Center the table horizontally with 20px margin at the top */
  
    background-color: #fff; /* White background */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
overflow: hidden;     
 /* Hide any overflow beyond this div */
}

#map {
  height: 25vh !important; 
  width: 50vw !important;
}



.BIG {
    max-width: 40vw;
    margin-left: 20vw;
    margin-bottom: 4vh; 
    padding: 20px;
    max-height: 40vh;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-family: Arial, sans-serif;
}

/* Form Label Styles */
form label {
font-size: 8px;    
display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

/* Input Styles */

input {    
height: .8vh;
    padding: 8px;
    margin-right: 5px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 20px;
}

/* Grouping Container Styles */
.grouper {
    margin-bottom: 5px;
}

/* Submit Button Styles */
input[type="submit"] {
    background-color: #4CAF50;
    color: white;
   
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

input[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}


.scroll {
    margin: 2vh 2vw; 
      /* Full width table */
    overflow: auto;
    height: 45vh;
    max-height: 45vh; 
    /* Enable horizontal scrolling if content overflows */
}
.scroll table {
width: 100%; 
max-height:95%; 
height: 95%;
 padding: 10px;
overflow: auto;  
}
.tabledis th, .tabledis td {
    border: 1px solid #ccc;
  padding: 8px;
    text-align: left;
}

.tabledis th {
    background-color: #f2f2f2; /* Light grey background for table header */
    font-weight: bold;
}


.stats {
    position: fixed;
   /* 5% of viewport height from the right */
     top: 5vh; /* 5% of viewport height from the top */
    right: 5vw; 
   width: 20vw; /* 20% of the viewport width */
    max-width: 350px; /* Maximum width to maintain readability */
      padding: 2vh;

    background-color: #f8f9fa; /* Light grey background */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    overflow: auto; /* Enable scrolling if content exceeds height */
    max-height: 30vh; /* Maximum height is 30% of viewport height */
}


#myChart {

  height: 24vh !important; 
  width: 35vw !important; 

}

.grouper {
display: flex;

}
.grouper input  {
margin-right: 2px; 

}
.grouper label {
margin-right: 2px; 
}
/* Download link styling */
.download-link {
 position: fixed;
   /* 5% of viewport height from the right */
     top: 20vh; /* 5% of viewport height from the top */
    right: 6vw; 
}


.download-link:hover {
    background-color: #0056b3; /* Darker blue on hover */
    border-color: #0056b3;
}


.download-link:active {
    background-color: #004185; /* Even darker blue when clicked */
    border-color: #004185;
}
h1{
height: 10vh; /* Full height of the viewport minus padding and margin */
    width: 40vw; /* 90% of the available width */
    max-width: 40vw; /* Maximum width to maintain readability */
    margin-left: 2vw; 
   margin-bottom: .2vh;
 }
.box {
  display: flex;
  flex-direction: row;
}
.box div {
margin-right: 4vw;
}
.box div input {
font-size: 2vh; 

}

.flexx {
    
  display: flex;
            flex-direction: row; 

}
.back {
  height: 5vh; 
  width: 10vw;

  position: fixed;
   /* 5% of viewport height from the right */
     top: 5vh; /* 5% of viewport height from the top */
    right: 50vw; 
}
  

    </style>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="tabledis">
<h1>
Where are people using WindNinja?!
</h1>

<br>

        <div class = "BIG">       
<form method="post">
<div class = "grouper">   
<label for="search">Search By Country, Region, City, Postal Code (no spaces):</label>
            <input type="text" id="search" name="search" value=""> 
</div>
<div class="grouper">
  <label for="year">Search by Year From:</label>

            <input class = "inp" type="text" id="year" name="year" value = "">
            

  <label for="year2">To: </label>

            <input class = "inp" type="text" id="year2" name="year2" value="">

</div> 
<div class="grouper">                   
  <label for="month">Search by Month From:</label>

             <input class = "inp"  type="text" id="month" name="month" value="">

  <label for="month2">To:</label>
            <input class = "inp"  type="text" name = "month2" id="month2" name="">
</div>           
 <div class="grouper">          
            <label for="day">Search by Day From:</label>
            <input  class = "inp" type="text" id="day" name="day" value="">

            <label for="day2">To:</label>
            <input  class = "inp" type="text" id="day2" name="day2" value = "">

</div>            
            <input type="submit" value="Submit">
        </form>
   </div>
<div class = "flexx">
   <div id="map" style="height: 20vh;"></div>
   <canvas id="myChart"  style="width: 15vw;"></canvas>
</div>
<br>
<?php


$markers = []; 

function makedisplay($smtm, $db) {

  global $markers;

$result = $smtm->execute();

// Fetch the result

echo '<div class="scroll">';
  echo "<table>";

echo "<tr>";
  echo "<td>";
  echo "Country Name";
echo "</td>";
  echo "<td>";
  echo "Region";
echo "</td>";
  echo "<td>";
  echo "City";
echo "</td>";
  echo "<td>";
  echo "Post Code";
echo "</td>";


echo "<td>";
  echo "Latitude, Longitude";
echo "</td>";
echo "<td>";
  echo "Time";
echo "</td>";
  echo "</tr>"; 
  
$x = 0;
$searchtd = "Total Logs"; 



while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
  $markers[] = $row['lat'];
   if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        if (isset($_POST['search']) && !empty($_POST['search'])) {  
   if (strtolower(trim( $row['countryname']))  == strtolower(trim( $_POST['search']))) {
         $searchtd = "Total Logs" . " of country " .  strtolower(trim($_POST['search']));
} 
if (strtolower(trim($row['region']))  == strtolower(trim($_POST['search']))) {
  $searchtd = "Total Logs"  . " of region " .  strtolower(trim($_POST['search']));
}
if (strtolower(trim($row['city']))  == strtolower(trim($_POST['search']))) {
  $searchtd = "Total Logs" . " of city " .  strtolower(trim($_POST['search'])); 
}
if (strtolower(trim($row['postalcode']))  == strtolower(trim($_POST['search']))) {
  $searchtd = "Total Logs" . " of postalcode " .  strtolower(trim($_POST['search'])); 
}
}
 }
   $x = $x + 1; 
   echo "<tr>";
   echo  "<td>{$row['countryname']}</td>";
    echo  "<td>{$row['region']}</td>";
     echo  "<td>{$row['city']}</td>"; 
    echo  "<td>{$row['postalcode']}</td>";
    echo  "<td>{$row['lat']}</td>";
    echo  "<td>{$row['time']}</td>";
      echo "</tr>";
  
}


if (isset($_POST['year']) && !empty($_POST['year']) || isset($_POST['month']) && !empty($_POST['month']) || isset($_POST['day']) && !empty($_POST['day'])) {
  $searchtd = $searchtd . " of selected time period"; 
}


echo '<div class="back">';
echo '<form action="https://ninjastorm.firelab.org/sqlitetest" method="get">';
echo '<input type="submit" value="Go Back">';
echo '</form>';
echo '</div>';

echo "</div>";
echo '<div class="stats">';
echo "<ul><li>$searchtd (since 2024 June 21): $x</li></ul>"; 
echo "</div>";     

}





if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$dbfile = '/var/www/html/sqlitetest/db.sqlite';

               $db = new SQLite3($dbfile);
               $start_value = 0; 
               $end_value = 0; 
               $query =  "";
               $yearval = ""; 
               $monthval = ""; 
               $dayval = "";
               $bool2 = ((isset($_POST['year']) && !empty($_POST['year']) && isset($_POST['year2']) && !empty($_POST['year2']) )  || (isset($_POST['month']) && !empty($_POST['month']) && isset($_POST['month2']) && !empty($_POST['month2']) ) || (isset($_POST['day']) && !empty($_POST['day']) && isset($_POST['day2']) && !empty($_POST['day2']) ));
              $bool1 = isset($_POST['search']) && !empty($_POST['search']); 
               if ($bool2) {

               if (isset($_POST['year']) && !empty($_POST['year']) && isset($_POST['year2']) && !empty($_POST['year2'])) {
               
   $start_value += (int)$_POST['year'];
    $end_value += (int)$_POST['year2'];

    $yearval = "CAST(SUBSTR(time, 1, 4) AS INTEGER)"; 
     
  }

               if (isset($_POST['month']) && !empty($_POST['month']) && isset($_POST['month2']) && !empty($_POST['month2'])) {
                $start_value +=   100*((int)$_POST['month']);
                $end_value +=   100*((int)$_POST['month2']);

                $monthval = "CAST(SUBSTR(time, 6, 2) AS INTEGER) * 100"; 
             
            
              } 

               if (isset($_POST['day']) && !empty($_POST['day']) && isset($_POST['day2']) && !empty($_POST['day2'])) {
                $start_value += (int)$_POST['day'];
                $end_value += (int)$_POST['day2'];

                $dayval = "CAST(SUBSTR(time, 9, 2) AS INTEGER)"; 
      
              } 



              $query = "SELECT *, "; 
              if (!empty($yearval) && (!empty($monthval) || !empty($dayval))) {
                $query = $query .$yearval . " + "; 
              }
              else if (!empty($yearval) ) {
                $query = $query .$yearval; 
              }
              if (!empty($monthval) && (!empty($dayval))) {
                $query = $query .$monthval . " + "; 
              }
              else if (!empty($monthval) ) {
                $query = $query .$monthval; 
              }
              if (!empty($dayval)) {
                $query = $query .$dayval; 
              }
              
             $query = $query . " AS date_integer FROM locations WHERE (";
           
             if (!empty($yearval) && (!empty($monthval) || !empty($dayval))) {
              $query = $query .$yearval . " + "; 
            }
            else if (!empty($yearval) ) {
              $query = $query .$yearval; 
            }
            if (!empty($monthval) && (!empty($dayval))) {
              $query = $query .$monthval . " + "; 
            }
            else if (!empty($monthval) ) {
              $query = $query .$monthval; 
            }
            if (!empty($dayval)) {
              $query = $query .$dayval; 
            }

            $query = $query . ") BETWEEN :start_value AND :end_value";
            if ($bool1) {
            $query = $query . " AND (countryname LIKE :searchTerm
                   OR region LIKE :searchTerm
                   OR city LIKE :searchTerm
                   OR postalcode LIKE :searchTerm)";
            }


          }


            if ($bool1 && !$bool2) {
                $query = $query . "SELECT * FROM locations 
                WHERE countryname LIKE :searchTerm
                   OR region LIKE :searchTerm
                   OR city LIKE :searchTerm
                   OR postalcode LIKE :searchTerm";
               }
               $smtm = $db->prepare($query);
               if ($bool2) {

                $smtm->bindValue(':start_value', $start_value, SQLITE3_INTEGER);
                $smtm->bindValue(':end_value', $end_value, SQLITE3_INTEGER);
 
               } 
               if ($bool1) {
  

                $smtm->bindValue(':searchTerm', $_POST['search'], SQLITE3_TEXT);
 
               } 



if (!isset($smtm)) {
  echo "<div>"; 
  echo "You did not enter a valid submission. :(";
  echo "</div>"; 

  $db -> close();

}
else {
makedisplay($smtm, $db);
$db -> close(); 
}


} 


else {


$dbfile = '/var/www/html/sqlitetest/db.sqlite';

$db = new SQLite3($dbfile);  


if(isset($_GET['time'])) {
$client_ip = $_SERVER['REMOTE_ADDR'];


$query = "CREATE TABLE IF NOT EXISTS locations(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    countryname TEXT NOT NULL,
    region TEXT NOT NULL, 
    city TEXT NOT NULL, 
    postalcode TEXT NOT NULL, 
    lat TEXT NOT NULL, 
    time TEXT NOT NULL
)";


$db->exec($query);

    
 
   $IPAD = $client_ip;

   $time1 = date('Y/m/d');


$url = "https://ipinfo.io/$IPAD?token=c1281616449b0c";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



$response = curl_exec($ch);




curl_close($ch);

   $decoded_json = json_decode($response); 
 
   $countryname = $decoded_json->country; 
  $lat = $decoded_json->loc;
  $regname = $decoded_json->region;
  $postalcode = $decoded_json->postal;
   $city = $decoded_json->city;
   
  $appendVa = fopen("/var/www/html/sqlitetest/placeholder.txt","a");
  fwrite($appendVa, $countryname);
 fwrite($appendVa, "    | ");
fwrite($appendVa, $regname);
fwrite($appendVa, "    | ");
fwrite($appendVa, $city);
fwrite($appendVa, "    | ");
fwrite($appendVa, $postalcode);
fwrite($appendVa, "    | ");
fwrite($appendVa, $lat);
fwrite($appendVa, "    | ");
fwrite($appendVa, $time1);
  fwrite($appendVa, "\n");
  fclose($appendVa);

 $smtm = $db->prepare('INSERT INTO locations (countryname, region, city, postalcode, lat, time) VALUES (:countryname, :region, :city, :postalcode, :lat, :time)');
    $smtm->bindValue(':countryname', $countryname, SQLITE3_TEXT);
    $smtm->bindValue(':region', $regname, SQLITE3_TEXT);
    $smtm->bindValue(':city', $city, SQLITE3_TEXT);

    $smtm->bindValue(':postalcode', $postalcode, SQLITE3_TEXT);
    $smtm->bindValue(':lat', $lat, SQLITE3_TEXT);
    $smtm->bindValue(':time', $time1, SQLITE3_TEXT);
       
  $smtm -> execute(); 
 
    // Execute the statement

    


}
$smtm = $db->prepare('SELECT * FROM locations');

makedisplay($smtm, $db); 
$db -> close();
}


$markersJson = json_encode($markers);

?>

<script>
     var times = [];
    var top = [];
    document.addEventListener('DOMContentLoaded', (event) => {
    
        var markers = <?php echo $markersJson; ?>;
        top = markers;
        var map = L.map('map').setView([markers[0].split(',')[0], markers[0].split(',')[1]], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        markers.forEach(function(marker) {
          times.push(marker['time']); 

        var popupContent = '<b>Marker Information</b><br>' +
                           'Latitude: ' + marker.split(',')[0] + '<br>' +
                           'Longitude: ' + marker.split(',')[1] ;
            if (marker) {
                L.marker(marker.split(',')).bindPopup(popupContent).addTo(map);
            }
        });


         
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: times,
    datasets: [{ 
        data: top,
        label: "Africa",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'World population per region (in millions)'
    }
  }
});



    });
</script>


     <a href="https://ninjastorm.firelab.org/sqlitetest/placeholder.txt" download="stats.txt" class="download-link">
Download Text File of Stats</a>
</body>
</html>

