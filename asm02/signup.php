<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
</head>

<body>
  <?php
  require_once("settings.php");

  // Connect to database
  $conn = @mysqli_connect($host, $user, $pswd) or die("Connection failed: " . mysqli_connect_error());
  @mysqli_select_db($conn, $dbnm) or die("Database selection failed: " . mysqli_error($conn));

  $mailRegex = "/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
  $profileRegex = "/^[a-zA-Z]+$/";
  $passwordRegex = "/^[a-zA-Z0-9]+$/";

  function validateField($fieldName, $fieldValue, $regex, $errMsg)
  {
    if (empty($fieldValue)) {
      echo "<p>$fieldName is empty</p>";
    } else if (!preg_match($regex, $fieldValue)) {
      echo "<p>$errMsg</p>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  function isEmailUnique($email)
  {
    // Check if email exists in the ‘friends’ table
    global $conn, $table1;
    $sql = "SELECT friend_email FROM $table1 WHERE friend_email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      echo "<p>Email already exists</p>";
      return false;
    }
    return true;
  }

  function isPasswordMatch($password, $confirmPassword)
  {
    if ($password !== $confirmPassword) {
      echo "<p>Passwords do not match</p>";
      return false;
    }
    return true;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = validateField("Email", $_POST['email'], $mailRegex, "Email is invalid");
    $profileName = validateField("Profile Name", $_POST['profileName'], $profileRegex, "Profile Name is invalid");
    $password = validateField("Password", $_POST['password'], $passwordRegex, "Password is invalid");
    $confirmPassword = validateField("Confirm Password", $_POST['confirmPassword'], $passwordRegex, "Confirm Password is invalid");

    if ($_POST['password'] !== $_POST['confirmPassword']) {
      echo "<p>Passwords do not match</p>";
    }

    if ($mail && $profileName && $password && $confirmPassword && isEmailUnique($mail) && isPasswordMatch($password, $confirmPassword)) {
      $sql = "INSERT INTO $table1 (friend_email, password, profile_name, date_started, num_of_friends) VALUES ('$mail', '$password', '$profileName', CURDATE(), 0)";
      if (mysqli_query($conn, $sql)) {
        echo "<p>Account successfully created</p>";
        session_start();
        $_SESSION['email'] = $mail;
        $_SESSION['profileName'] = $profileName;
        $_SESSION['loggedIn'] = true;
        header("Location: friendadd.php");

        // Close connection
        mysqli_free_result($result);
        mysqli_close($conn);
      } else {
        echo "<p style=color:red>Error creating account: " . mysqli_error($conn) . "</p>";
      }
    }
  }
  ?>

  <h1>My Friends System<br>Registration Page</h1>
  <form method="post" action="signup.php">
    <p><label for="email">Email</label>
      <input name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
    </p>
    <p><label for="profileName">Profile Name</label>
      <input name="profileName" value="<?php echo isset($_POST['profileName']) ? htmlspecialchars($_POST['profileName']) : ''; ?>">
    </p>
    <p><label for="password">Password</label>
      <input type="password" name="password">
    </p>
    <p><label for="confirmPassword">Confirm Password</label>
      <input type="password" name="confirmPassword">
    </p>
    <p><input type="submit" value="Register">
      <input type="reset" value="Clear">
    </p>
  </form>
  <p><a href="index.php">Home</a></p>


</body>

</html>