<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="Trac Duc Anh Luong" />
  <title>TITLE</title>
</head>

<body>
  <h1>Web Programming - Lab08</h1>
  <?php
  require_once("settings.php");
  // complete your answer based on Lecture 8 slides 26 and 44

  // connect to server and select db
  $conn = @mysqli_connect($host, $user, $pswd) or die("Connection failed: " . mysqli_connect_error());
  @mysqli_select_db($conn, $dbnm) or die("Database selection failed: " . mysqli_error($conn));

  // query and retrieve data
  $query = "SELECT * FROM cars";
  $results = mysqli_query($conn, $query);

  // display data in table
  echo "<table border='1'>";
  echo "<tr><th>Car ID</th><th>Make</th><th>Model</th><th>Price</th></tr>";
  while ($row = mysqli_fetch_assoc($results)) {
    echo "<tr><td>" . $row['car_id'] . "</td><td>" . $row['make'] . "</td><td>"
      . $row['model'] . "</td><td>" . $row["price"] . "</td></tr>";
  }
  echo "</table>";
  
  // free result and close connection
  mysqli_free_result($results);
  mysqli_close($conn);
  ?>
</body>

</html>