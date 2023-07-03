<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
</head>

<body>
  <h1>My Friends System<br>Assignment Home Page</h1>
  <p>Name: Trac Duc Anh Luong</p>
  <p>Student ID: 103488117</p>
  <p>Email: <a href="mailto:103488117@student.swin.edu.au">103488117@student.swin.edu.au</a></p>
  <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other students work or from any other source.</p>
  <?php
  require_once("settings.php");
  $temp1 = false;
  $temp2 = false;

  // Connect to database
  $conn = @mysqli_connect($host, $user, $pswd) or die("Connection failed: " . mysqli_connect_error());
  @mysqli_select_db($conn, $dbnm) or die("Database selection failed: " . mysqli_error($conn));

  // Create table "friends" if not exists
  $sql1 = "CREATE TABLE IF NOT EXISTS $table1 (
    friend_id INT NOT NULL AUTO_INCREMENT,
    friend_email VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL,
    profile_name VARCHAR(30) NOT NULL,
    date_started DATE NOT NULL,
    num_of_friends INT UNSIGNED NOT NULL,
    PRIMARY KEY (friend_id)
  ) ENGINE = InnoDB;";

  // Execute the query and check for any errors
  if (mysqli_query($conn, $sql1)) {
    $temp1 = true;
  } else {
    echo "<p style=color:red>Error creating table: " . mysqli_error($conn) . "</p>";
  }

  // Create table "myfriends" if not exists
  $sql2 = "CREATE TABLE IF NOT EXISTS $table2 (
    friend_id1 INT NOT NULL,
    friend_id2 INT NOT NULL
  ) ENGINE = InnoDB;";

  // Execute the query and check for any errors
  if (mysqli_query($conn, $sql2)) {
    $temp2 = true;
  } else {
    echo "<p style=color:red>Error creating table: " . mysqli_error($conn) . "</p>";
  }

  if ($temp1 && $temp2) {
    echo "<p>Tables sucessfully created and populated.</p>";
  }

  // Close connection
  mysqli_close($conn);
  ?>
  <p><a href="signup.php">Sign-Up</a></p>
  <p><a href="login.php">Login</a></p>
  <p><a href="about.php">About</a></p>
</body>

</html>