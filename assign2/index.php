<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body class="bg-image">
  <div class="header">
    <h1>My Friends System</h1>
    <ul class="nav">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="signup.php">Sign-Up</a></li>
      <li class="nav-link"><a href="login.php">Login</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
    </ul>
  </div>

  <div class="bg-text">
    <h1>Assignment Home Page</h1>
    <p>Name: Trac Duc Anh Luong</p>
    <p> Student ID: 103488117 </p>
    <p>Email: <a class="email" href="mailto:103488117@student.swin.edu.au">103488117@student.swin.edu.au</a></p>
    <p>I declare that this assignment is my individual work. I have not worked collaboratively nor have I copied from any other students work or from any other source.</p>
  </div>

  <div class="grid-container">
    <?php
    require_once("settings.php");

    // Create table "friends" if not exists
    $sql1 = "CREATE TABLE IF NOT EXISTS $table1 (
    friend_id INT NOT NULL AUTO_INCREMENT,
    friend_email VARCHAR(50) NOT NULL,
    password VARCHAR(20) NOT NULL,
    profile_name VARCHAR(30) NOT NULL,
    date_started DATE NOT NULL,
    num_of_friends INT UNSIGNED NOT NULL,
    PRIMARY KEY (friend_id)
  )";

    // Execute the query and check for any errors
    if (mysqli_query($conn, $sql1)) {
      echo "<p style=color:green>Table $table1 created successfully.</p>";
    } else {
      echo "<p style=color:red>Error creating table: " . mysqli_error($conn) . "</p>";
    }

    // Create table "myfriends" if not exists
    $sql2 = "CREATE TABLE IF NOT EXISTS $table2 (
    friend_id1 INT NOT NULL,
    friend_id2 INT NOT NULL
  )";

    // Execute the query and check for any errors
    if (mysqli_query($conn, $sql2)) {
      echo "<p style=color:green>Table $table2 created successfully.</p>";
    } else {
      echo "<p style=color:red>Error creating table: " . mysqli_error($conn) . "</p>";
    }

    // Check if table "friends" is empty
    $sql3 = "SELECT * FROM $table1";
    $result = mysqli_query($conn, $sql3);
    if (mysqli_num_rows($result) > 0) {
      echo "<p style=color:green>Table $table1 already has data.</p>";
    } else {
      // Insert sample data to table "friends"
      $sql4 = "INSERT INTO $table1 (friend_email, password, profile_name, date_started, num_of_friends)
    VALUES
      ('friend1@example.com', 'password1', 'John Doe', '2023-01-01', 4),
      ('friend2@example.com', 'password2', 'Jane Smith', '2023-02-15', 4),
      ('friend3@example.com', 'password3', 'Michael Johnson', '2023-03-10', 4),
      ('friend4@example.com', 'password4', 'Sarah Thompson', '2023-04-22', 4),
      ('friend5@example.com', 'password5', 'David Lee', '2023-05-05', 4),
      ('friend6@example.com', 'password6', 'Emily Davis', '2023-06-18', 4),
      ('friend7@example.com', 'password7', 'Daniel Wilson', '2023-07-07', 4),
      ('friend8@example.com', 'password8', 'Olivia Brown', '2023-08-12', 4),
      ('friend9@example.com', 'password9', 'James Taylor', '2023-09-25', 4),
      ('friend10@example.com', 'password10', 'Sophia Anderson', '2023-10-31', 4)";

      // Execute the query and check for any errors
      if (mysqli_query($conn, $sql4)) {
        echo "<p style=color:green>Sample data populated to table $table1 successfully.</p>";
      } else {
        echo "<p style=color:red>Error inserting data: " . mysqli_error($conn) . "</p>";
      }
    }

    // Check if table "myfriends" is empty
    $sql5 = "SELECT * FROM $table2";
    $result = mysqli_query($conn, $sql5);
    if (mysqli_num_rows($result) > 0) {
      echo "<p style=color:green>Table $table2 already has data.</p>";
    } else {
      // Insert sample data to table "myfriends"
      $sql4 = "INSERT INTO myfriends (friend_id1, friend_id2)
    VALUES
      (1, 2),
      (2, 3),
      (3, 4),
      (4, 5),
      (5, 6),
      (6, 7),
      (7, 8),
      (8, 9),
      (9, 10),
      (10, 1),
      (1, 3),
      (2, 4),
      (3, 5),
      (4, 6),
      (5, 7),
      (6, 8),
      (7, 9),
      (8, 10),
      (9, 1),
      (10, 2)";

      // Execute the query and check for any errors
      if (mysqli_query($conn, $sql4)) {
        echo "<p style=color:green>Sample data populated to table $table2 successfully.</p>";
      } else {
        echo "<p style=color:red>Error inserting data: " . mysqli_error($conn) . "</p>";
      }
    }

    // Close connection
    mysqli_close($conn);
    ?>
  </div>
</body>

</html>