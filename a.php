<?php
// $host = "feenix-mariadb.swin.edu.au";
// $username = "s103488117";
// $password = "181203";
// $dbname = "s103488117_db";
$host = "localhost";
$username = "ducanh";
$password = "ducanh2003";
$dbname = "AWD";

// Connect to database
$conn = @mysqli_connect($host, $username, $password) or die("Connection failed: " . mysqli_connect_error());
@mysqli_select_db($conn, $dbname) or die("Database selection failed: " . mysqli_error($conn));

// SQL query
$query = "SELECT * FROM Weather";
$results = mysqli_query($conn, $query);

// Display results
while ($row = mysqli_fetch_assoc($results)) {
  echo $row['ID'] . " " . $row['Temperature'] . " " . $row['Humidity'] . " " . $row["Gas"] . "<br>";
}

// Close connection
mysqli_free_result($results);
mysqli_close($conn);
