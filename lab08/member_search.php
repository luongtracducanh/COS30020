<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Search Member Form</h1>
  <form action="member_search.php" method="post">
    <p><label for="lname">Last Name:</label>
      <input name="lname" />
    </p>
    <p>
      <input type="submit" value="Search Member" />
      <input type="reset" value="Clear Form" />
    </p>
  </form>
  <?php
  if (isset($_POST["lname"]) && !empty($_POST["lname"])) {
    $lname = strtolower($_POST["lname"]);

    require_once("settings.php");
    $table = "vipmembers";

    // connect to server and select db
    $conn = @mysqli_connect($host, $user, $pswd) or die("Connection failed: " . mysqli_connect_error());
    @mysqli_select_db($conn, $dbnm) or die("Database selection failed: " . mysqli_error($conn));

    // check if table exists
    $checkQuery = "SHOW TABLES LIKE '$table'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      // table exists, proceed with retrieving data

      // query and retrieve data
      $query = "SELECT member_id, fname, lname, email FROM $table WHERE LOWER(lname) LIKE '%$lname%'";
      $results = mysqli_query($conn, $query);

      if (mysqli_num_rows($results) > 0) {
        // display data in table
        echo "<table border='1'>";
        echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";
        while ($row = mysqli_fetch_assoc($results)) {
          echo "<tr><td>" . $row['member_id'] . "</td><td>" . $row['fname'] . "</td><td>" . $row['lname'] . "</td><td>" . $row["email"] . "</td></tr>";
        }
        echo "</table>";
      } else {
        echo "<p style='color:red'>No data available in the $table table.</p>";
      }

      // free result
      mysqli_free_result($results);
    } else {
      echo "<p style='color:red'>Table $table does not exist.</p>";
    }

    // close connection and free results
    mysqli_free_result($checkResult);
    mysqli_close($conn);
  } else {
    echo "<p>Please enter a last name.</p>";
  }
  ?>
</body>

</html>