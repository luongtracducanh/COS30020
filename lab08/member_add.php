<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Add Member Form Result</h1>
  <?php
  // Establish DB connection
  require_once("settings.php");
  $table = "vipmembers";
  $conn = @mysqli_connect($host, $user, $pswd) or die("Connection failed: " . mysqli_connect_error());
  @mysqli_select_db($conn, $dbnm) or die("Database selection failed: " . mysqli_error($conn));

  // Create "vipmembers" table if not exists
  $sql = "CREATE TABLE IF NOT EXISTS $table (
    member_id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(40),
    lname VARCHAR(40),
    gender VARCHAR(1),
    email VARCHAR(40),
    phone VARCHAR(20)
  )";

  // Execute the query and check for any errors
  if (mysqli_query($conn, $sql)) {
    echo "<p style='color:green'>Table created successfully</p>";
  } else {
    echo "<p style='color:red'>Error creating table: " . mysqli_error($conn) . "</p>";
  }

  // Get form data values
  if (
    isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["gender"]) && isset($_POST["email"]) && isset($_POST["phone"])
    && !empty($_POST["fname"]) && !empty($_POST["lname"]) && !empty($_POST["gender"]) && !empty($_POST["email"]) && !empty($_POST["phone"])
  ) {
    // regex for email and phone
    $regexEmail = "/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
    $regexPhone = "/^[0-9]{10}$/";
    if (!preg_match($regexEmail, $_POST["email"])) {
      echo "<p style='color:red'>Email address is not valid.</p>";
    } else if (!preg_match($regexPhone, $_POST["phone"])) {
      echo "<p style='color:red'>Phone number is not valid.</p>";
    } else {
      $fname = $_POST["fname"];
      $lname = $_POST["lname"];
      $gender = $_POST["gender"];
      $email = $_POST["email"];
      $phone = $_POST["phone"];

      // Check if the record already exists
      $existingQuery = "SELECT * FROM vipmembers WHERE fname = '$fname' AND lname = '$lname'";
      $existingResult = mysqli_query($conn, $existingQuery);
      
      if (mysqli_num_rows($existingResult) > 0) {
        echo "<p style='color:red'>A member with the same first name and last name already exists.</p>";
      } else {
        // Insert statement
        $sql = "INSERT INTO vipmembers (fname, lname, gender, email, phone) VALUES ('$fname', '$lname', '$gender', '$email', '$phone')";
        // Execute the query and check for any errors
        if (mysqli_query($conn, $sql)) {
          echo "<p style='color:green'>Data inserted successfully</p>";
        } else {
          echo "<p style='color:red'>Error creating table: " . mysqli_error($conn) . "</p>";
        }
      }
    }
  } else {
    echo "<p style='color:red'>All fields are required.</p>";
  }

  // Close connection
  mysqli_close($conn);
  ?>
</body>

</html>