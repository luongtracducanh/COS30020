<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <?php
  require_once("settings.php");

  // Connect to database
  $conn = mysqli_connect($host, $user, $pswd, $dbnm);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  function validateField($fieldName, $fieldValue)
  {
    if (empty($fieldValue)) {
      echo "<p>$fieldName is empty</p>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }

  // check if the form is submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = validateField("Email", sanitizeInput($_POST['email']));
    $inputPassword = validateField("Password", sanitizeInput($_POST['password']));

    $sql = "SELECT friend_email, password FROM $table1 WHERE friend_email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $inputEmail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // if email exists, check the password
    if (mysqli_stmt_num_rows($stmt) > 0) {
      mysqli_stmt_bind_result($stmt, $dbEmail, $dbPassword);
      mysqli_stmt_fetch($stmt);
      if ($dbPassword === $inputPassword) {
        echo "<p>Log in successful</p>";
        // Set up session variable(s) and redirect to friendlist.php
        session_start();
        $_SESSION['email'] = $inputEmail;
        $_SESSION['loggedIn'] = true;
        header("Location: friendlist.php");
        exit();
      } else {
        echo "<p>Incorrect password</p>";
      }
    } else {
      echo "<p>Incorrect email</p>";
    }

    mysqli_stmt_close($stmt);
  }

  ?>

  <h1>My Friends System<br>Log in Page</h1>
  <form method="post" action="login.php">
    <p><label for="email">Email</label>
      <input name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
    </p>
    <p><label for="password">Password</label>
      <input type="password" name="password">
    </p>
    <p><input type="submit" value="Log in">
      <input type="reset" value="Clear">
    </p>
  </form>
  <p><a href="index.php">Home</a></p>
</body>

</html>