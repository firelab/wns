<?php


$markers = []; 

$markerszoom = []; 
$totals = [];

$totals1 = [];

$totals2 = [];

$totals3 = [];

### DISPLAY
$timeint = ""; 
$timeint1 = "";

## generate display 
function makedisplay($smtm, $db) {
  global $markerszoom;

  global $markers;


$result = $smtm->execute();

// Fetch the result

echo '<div class="scroll" style="max-height: 500px; overflow-y: auto;">';
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
  echo "Organization";
echo "</td>";
echo "<td>";
  echo "Time";
echo "</td>";

echo "<td>";
  echo "Total CLI Runs";
echo "</td>";

echo "<td>";
  echo "Total GUI Runs";
echo "</td>";

echo "<td>";
  echo "Total Runs";
echo "</td>";
  echo "</tr>"; 
  
$x = 0;
$searchtd = "Total Logs"; 


while ($row = $result->fetchArray(SQLITE3_ASSOC)) { 
   $markerszoom[] = $row['lat']; 
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
    echo  "<td>{$row['organization']}</td>";
    echo  "<td>{$row['time']}</td>";
    echo "<td>";
    echo  $row['totalcliruns'];
    echo "</td>";
    echo "<td>";
    echo  $row['totalguiruns'];
    echo "</td>";
    echo "<td>";
    echo  $row['total'];
    echo "</td>";

      echo "</tr>";
  
}

echo "</div>";

##### Create markers 
$smtm4 = $db->prepare('SELECT countryname, region, city, organization, postalcode, lat, time, total, totalcliruns, totalguiruns FROM locations');
$result2 = $smtm4->execute();

while ($row1 = $result2->fetchArray(SQLITE3_ASSOC)) { 
      $markers[] = $row1;
}
$smtm4 -> close();





if (isset($_POST['year']) && !empty($_POST['year']) || isset($_POST['month']) && !empty($_POST['month']) || isset($_POST['day']) && !empty($_POST['day'])) {
  $searchtd = $searchtd . " of selected time period"; 
}

echo "</div>"; 

echo '<div class="stats">';



$query1 = "SELECT * FROM windowsorlinux";
$result1 = $db->query($query1);

// Fetch the first row (assuming there's only one row based on your usage)
$row1 = $result1->fetchArray(SQLITE3_ASSOC);

// Output total Windows users
if ($row1) {
  //echo "Total Windows Users: " . $row1['windowstot'] . "<br>";

}

##echo "<ul><li>$searchtd: $x</li></ul>"; 
##echo "</div>";     

$smtm -> close();
$db -> close();


}


## POST 




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

    $timeint =  $timeint . $_POST['year']; 
    $timeint1 =  $timeint1 . $_POST['year2'];
    if (isset($_POST['month']) && !empty($_POST['month']) && isset($_POST['month2']) && !empty($_POST['month2'])) {
      $timeint = $timeint . "/"; 
      $timeint1 = $timeint1 ."/"; 
    }
    $yearval = "CAST(SUBSTR(time, 1, 4) AS INTEGER)"; 
     
  }

               if (isset($_POST['month']) && !empty($_POST['month']) && isset($_POST['month2']) && !empty($_POST['month2'])) {
                $start_value +=   100*((int)$_POST['month']);
                $end_value +=   100*((int)$_POST['month2']);

                $monthval = "CAST(SUBSTR(time, 6, 2) AS INTEGER) * 100"; 
             
  
                $timeint =$timeint .  $_POST['month']; 
                $timeint1 =   $timeint1 . $_POST['month2'];
                if (isset($_POST['day']) && !empty($_POST['day']) && isset($_POST['day2']) && !empty($_POST['day2'])) {
                    $timeint = $timeint . "/"; 
                    $timeint1 = $timeint1 ."/"; 
                }
            
              } 

               if (isset($_POST['day']) && !empty($_POST['day']) && isset($_POST['day2']) && !empty($_POST['day2'])) {
                $start_value += (int)$_POST['day'];
                $end_value += (int)$_POST['day2'];

                $dayval = "CAST(SUBSTR(time, 9, 2) AS INTEGER)"; 
      
     $timeint =    $timeint . $_POST['day']; 
     $timeint1 =  $timeint1 . $_POST['day2'];
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
          

          }

            if ($bool1) {
                $query = "SELECT * FROM locations 
                WHERE countryname LIKE :searchTerm
                   OR region LIKE :searchTerm
                   OR city LIKE :searchTerm
                    OR organization LIKE :searchTerm
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
}



} 




#GET



else {

$dbfile = '/var/www/html/sqlitetest/db.sqlite';

$db = new SQLite3($dbfile);  


if(isset($_GET['time']) && isset($_GET['runtype']) &&!empty($_GET['runtype'])) {
$client_ip = $_SERVER['REMOTE_ADDR'];


// Log the output to a file (append mode)
    
$new_key = $client_ip;
$linuxw =   "linux";



$query = "CREATE TABLE IF NOT EXISTS locations(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    countryname TEXT NOT NULL,
    region TEXT NOT NULL, 
    city TEXT NOT NULL, 
    organization TEXT NOT NULL,
    postalcode TEXT NOT NULL, 
    lat TEXT NOT NULL, 
    time TEXT NOT NULL,
    ip TEXT NOT NULL,
    totalcliruns INTEGER NOT NULL, 
    totalguiruns INTEGER NOT NULL,
    total INTEGER NOT NULL
)";


$db->exec($query);

$query = "CREATE TABLE IF NOT EXISTS totals(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    time TEXT NOT NULL,
    totalcliruns INTEGER NOT NULL, 
    totalguiruns INTEGER NOT NULL, 
    total INTEGER NOT NULL
)";


$db->exec($query);

$query = "CREATE TABLE IF NOT EXISTS windowsorlinux (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  windowstot INTEGER NOT NULL DEFAULT 0,
  linuxtot INTEGER NOT NULL DEFAULT 0
)";

// Create the table if it doesn't exist
$db->exec($query);

// Query to check if there are any rows in the table

$queryCheck = "SELECT * FROM windowsorlinux";
$result = $db->query($queryCheck);

// Fetch the first row (if any)
$row = $result->fetchArray(SQLITE3_ASSOC);

if (!$row) {
    // No rows exist, so insert initial values
    $stmtInsert = $db->prepare('INSERT INTO windowsorlinux (windowstot, linuxtot) VALUES (0, 0)');
    $stmtInsert->execute();
    $stmtInsert->close();
} 
   $IPAD = $client_ip;

  
   $time1 = date('Y/m/d');


$url = "https://ipinfo.io/$IPAD?token=c1281616449b0c";


// SQL query to check if the value exists
$query = "SELECT * FROM locations WHERE ip = :ip";
$smtm3 = $db->prepare($query);
$smtm3->bindValue(':ip', $client_ip, SQLITE3_TEXT); // Bind parameter as a float

$result = $smtm3->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

// Check if any rows were returned
$timesclicked = 1; 
$smtm3->close();

if ($row) {
  if ($_GET['runtype'] == "gui") {
    $smtm1 = $db->prepare('UPDATE locations SET totalguiruns = :timesnew WHERE id = :id');
    $smtm1->bindValue(':id', $row['id'], SQLITE3_INTEGER); // Bind location ID parameter
    $smtm1->bindValue(':timesnew', $row['totalguiruns'] + 1, SQLITE3_INTEGER); // Bind location ID parameter
    $smtm1-> execute();
  $smtm1 -> close();
  }

  if ($_GET['runtype'] == "cli") {
    $smtm1 = $db->prepare('UPDATE locations SET totalcliruns = :timesnew WHERE id = :id');
    $smtm1->bindValue(':id', $row['id'], SQLITE3_INTEGER); // Bind location ID parameter
    $smtm1->bindValue(':timesnew', $row['totalcliruns'] + 1, SQLITE3_INTEGER); // Bind location ID parameter
    $smtm1-> execute();
  
  $smtm1 -> close();
  }

  $smtm1 = $db->prepare('UPDATE locations SET total = :timesnew WHERE id = :id');
  $smtm1->bindValue(':id', $row['id'], SQLITE3_INTEGER); // Bind location ID parameter
  $smtm1->bindValue(':timesnew', $row['total'] + 1, SQLITE3_INTEGER); // Bind location ID parameter
  $smtm1-> execute();

$smtm1 -> close();

  
} 

else {
  
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



$response = curl_exec($ch);


curl_close($ch);

   $decoded_json = json_decode($response); 
 
   $countryname = isset($decoded_json->country) ? $decoded_json->country : ""; 
  $lat = isset($decoded_json->loc) ? $decoded_json->loc : "";
  $regname = isset($decoded_json->region) ? $decoded_json->region : "";
  $postalcode = isset($decoded_json->postal) ? $decoded_json->postal : "";
   $city = isset($decoded_json->city) ? $decoded_json->city : "";
   $org = isset($decoded_json->org) ? $decoded_json->org : "";
   $appendVa = fopen("/var/www/html/sqlitetest/placeholder.txt","a");
  fwrite($appendVa, $countryname);
 fwrite($appendVa, "    | ");
fwrite($appendVa, $regname);
fwrite($appendVa, "    | ");
fwrite($appendVa, $city);
fwrite($appendVa, "    | ");
fwrite($appendVa, $org);
fwrite($appendVa, "    | ");
fwrite($appendVa, $postalcode);
fwrite($appendVa, "    | ");
fwrite($appendVa, $lat);
fwrite($appendVa, "    | ");
fwrite($appendVa, $time1);
fwrite($appendVa, "    | ");
fwrite($appendVa, $row['totalcliruns'] );
fwrite($appendVa, "    | ");
fwrite($appendVa, $row['totalguiruns'] );
fwrite($appendVa, "    | ");
fwrite($appendVa, $row['total'] );
  fwrite($appendVa, "\n");
  fclose($appendVa);




/*
 if (strpos(strtolower($linuxw), 'linux') !== false) {

  // Fetch current linuxtot value
  $querylinux = "SELECT linuxtot FROM windowsorlinux";
  $currentLinuxTot = $db->querySingle($querylinux);


  if ($currentLinuxTot !== false) {
      // Increment linuxtot by 1
      $newLinuxTot = $currentLinuxTot + 1;


      // Update linuxtot in windowsorlinux table
      $stmt = $db->prepare('UPDATE windowsorlinux SET linuxtot = :newLinuxTot');
      $stmt->bindValue(':newLinuxTot', $newLinuxTot, SQLITE3_INTEGER);
      $stmt->execute();
      $stmt->close();
  }
}
if (strpos(strtolower($linuxw), 'windows') !== false) {
// Fetch current linuxtot value
$querywindows = "SELECT windowstot FROM windowsorlinux";
$currentWindowsTot = $db->querySingle($querywindows);


if ($currentWindowsTot !== false) {
    // Increment linuxtot by 1
    $newWindowsTot = $currentWindowsTot + 1;


    // Update linuxtot in windowsorlinux table
    $stmt = $db->prepare('UPDATE windowsorlinux SET windowstot = :newWindowsTot');
    $stmt->bindValue(':newWindowsTot', $newWindowsTot, SQLITE3_INTEGER);
    $stmt->execute();
    $stmt->close();


}
}
*/

      $smtm2 = $db->prepare('INSERT INTO locations (countryname, region, city, organization, postalcode, lat, time, ip, total, totalcliruns, totalguiruns) VALUES (:countryname, :region, :city, :organization, :postalcode, :lat, :time, :ip,  :total, :totalcliruns, :totalguiruns)');
      $smtm2->bindValue(':countryname', $countryname, SQLITE3_TEXT);
      $smtm2->bindValue(':region', $regname, SQLITE3_TEXT);
      $smtm2->bindValue(':city', $city, SQLITE3_TEXT);
      $smtm2->bindValue(':organization', $org, SQLITE3_TEXT);
 $smtm2->bindValue(':postalcode', $postalcode, SQLITE3_TEXT);
 $smtm2->bindValue(':lat', $lat, SQLITE3_TEXT);
 $smtm2->bindValue(':time', $time1, SQLITE3_TEXT);
 $smtm2->bindValue(':ip', $client_ip, SQLITE3_TEXT);
 $smtm2->bindValue(':total', 1, SQLITE3_INTEGER);
 if ($_GET['runtype'] == "gui") {

  $smtm2->bindValue(':totalcliruns', 0, SQLITE3_INTEGER);
  $smtm2->bindValue(':totalguiruns',1, SQLITE3_INTEGER);
 }
 if ($_GET['runtype'] == "cli") {

 $smtm2->bindValue(':totalcliruns', 1, SQLITE3_INTEGER);
 $smtm2->bindValue(':totalguiruns', 0, SQLITE3_INTEGER);
 }

 $smtm2-> execute();
 $smtm2 -> close();

}


$query = "SELECT * FROM totals WHERE time = :times2";
$smtm5 = $db->prepare($query);
$smtm5->bindValue(':times2', $time1, SQLITE3_TEXT); 

$results1 = $smtm5->execute();
$row = $results1->fetchArray(SQLITE3_ASSOC);

$timesclicked = 1; 
$smtm5->close();

if ($row) {
  $smtm6 = $db->prepare('UPDATE totals SET total = :timesnew WHERE id = :id');
  $smtm6->bindValue(':id', $row['id'], SQLITE3_INTEGER);
  $smtm6->bindValue(':timesnew', $row['total'] + 1, SQLITE3_INTEGER); 
  $smtm6-> execute();

$smtm6 -> close();
if ($_GET['runtype'] == "cli") {

  $smtm6 = $db->prepare('UPDATE totals SET totalcliruns = :timesnew WHERE id = :id');
  $smtm6->bindValue(':id', $row['id'], SQLITE3_INTEGER);
  $smtm6->bindValue(':timesnew', $row['totalcliruns'] + 1, SQLITE3_INTEGER); 
  $smtm6-> execute();
  
  $smtm6 -> close();
}
if ($_GET['runtype'] == "gui") {
  $smtm6 = $db->prepare('UPDATE totals SET totalguiruns = :timesnew WHERE id = :id');
  $smtm6->bindValue(':id', $row['id'], SQLITE3_INTEGER);
  $smtm6->bindValue(':timesnew', $row['totalguiruns'] + 1, SQLITE3_INTEGER); 
  $smtm6-> execute();
  $smtm6 -> close();
}

} 

else {

      $smtm7 = $db->prepare('INSERT INTO totals (time, totalcliruns, totalguiruns, total) VALUES (:time1, :timesclicked, :timesclicked1, :timesclicked2)');
 $smtm7->bindValue(':time1', $time1, SQLITE3_TEXT);
 if ($_GET['runtype'] == "cli") {
  $smtm7->bindValue(':timesclicked', 1, SQLITE3_INTEGER);
  $smtm7->bindValue(':timesclicked1', 0, SQLITE3_INTEGER);
 }
 if ($_GET['runtype'] == "gui") {
  $smtm7->bindValue(':timesclicked', 0, SQLITE3_INTEGER);
  $smtm7->bindValue(':timesclicked1', 1, SQLITE3_INTEGER);
 }

 $smtm7->bindValue(':timesclicked2', 1, SQLITE3_INTEGER);

 $smtm7-> execute();
 $smtm7 -> close();

}

}

$smtm = $db->prepare('SELECT countryname, region, city, organization, postalcode, lat, time,  totalcliruns, totalguiruns, total FROM locations');

$query = "SELECT COUNT(DISTINCT countryname) AS total_countries FROM locations";
$result = $db->query($query);
$row = $result->fetchArray(SQLITE3_ASSOC);
$totalCountries = $row['total_countries'];

$query = "SELECT COUNT(DISTINCT ip) AS unique_users FROM locations";
$result = $db->query($query);
$row = $result->fetchArray(SQLITE3_ASSOC);
$uniqueUsers = $row['unique_users'];

$query = "
    SELECT SUM(total) AS total_runs_2025 
    FROM totals 
    WHERE substr(time, 1, 4) = '2025'
";
$result = $db->query($query);
$row = $result->fetchArray(SQLITE3_ASSOC);
$totalRuns2025 = $row['total_runs_2025'] ?? 0;

makedisplay($smtm, $db); 

}


  $dbfile = '/var/www/html/sqlitetest/db.sqlite';

  $db = new SQLite3($dbfile);  
  
  $smtm8 = $db->prepare('SELECT *, 
                CAST(SUBSTR(time, 1, 4) AS INTEGER) AS year_int,
               CAST(SUBSTR(time, 6, 2) AS INTEGER) * 100 AS month_int,
                CAST(SUBSTR(time, 9, 2) AS INTEGER) AS day_int
                FROM totals 
                ORDER BY year_int + month_int * 100 + day_int ASC');
  
  $result = $smtm8->execute();
  
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) { 
  
      $totals[] = $row['time'];
      $totals3[] = $row['total'];
      $totals1[] = $row['totalcliruns'];
      $totals2[] = $row['totalguiruns'];

    }
  
  $smtm8 -> close();

$totalCountriesJson = json_encode($totalCountries);

$uniqueUsersJson = json_encode($uniqueUsers);

$totalRuns2025Json = json_encode($totalRuns2025);
  
$totalsJson = json_encode($totals);
$totals1Json = json_encode($totals1);

$totals2Json = json_encode($totals2); 
$totals3Sum = array_sum($totals3);
$totals3SumJson = json_encode($totals3Sum);
$totals3Json = json_encode($totals3);

$timeintJson = json_encode($timeint);
$timeintJson1 = json_encode($timeint1);

$markerszoomJson = json_encode($markerszoom);

$markersJson = json_encode($markers);


?>
