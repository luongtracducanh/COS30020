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
  $conn = mysqli_connect($host, $user, $pswd, $dbnm);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $mailRegex = "/^[a-zA-Z0-9.]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
  $profileRegex = "/^[a-zA-Z ]+$/";
  $passwordRegex = "/^[a-zA-Z0-9]+$/";

  function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }

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
    $sql = "SELECT friend_email FROM $table1 WHERE friend_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $numRows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($numRows > 0) {
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
    $mail = validateField("Email", sanitizeInput($_POST['email']), $mailRegex, "Email is invalid");
    $profileName = validateField("Profile Name", sanitizeInput($_POST['profileName']), $profileRegex, "Profile Name is invalid");
    $password = validateField("Password", sanitizeInput($_POST['password']), $passwordRegex, "Password is invalid");
    $confirmPassword = validateField("Confirm Password", sanitizeInput($_POST['confirmPassword']), $passwordRegex, "Confirm Password is invalid");

    if ($mail && $profileName && $password && $confirmPassword && isEmailUnique($mail) && isPasswordMatch($password, $confirmPassword)) {
      $sql = "INSERT INTO $table1 (friend_email, password, profile_name, date_started, num_of_friends) VALUES (?, ?, ?, CURDATE(), 0)";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "sss", $mail, $password, $profileName);
      if (mysqli_stmt_execute($stmt)) {
        // echo "<p>Account successfully created</p>";
        $msg = "Account successfully created";

        // start the session with the profile name and the number of friends
        session_start();
        $_SESSION['mail'] = $mail;
        $_SESSION['loggedIn'] = true;
        header("Location: friendadd.php");
        exit();
      } else {
        echo "<p style=color:red>Error creating account: " . mysqli_error($conn) . "</p>";
      }
      mysqli_stmt_close($stmt);
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