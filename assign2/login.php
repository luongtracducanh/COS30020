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

  // initialize variables
  $inputEmail = $inputPassword = null;
  $msg1 = $msg2 = $msg3 = $msg4 = null;

  // function for validating fields
  function validateField($fieldName, $fieldValue)
  {
    if (empty($fieldValue)) {
      echo "<span>$fieldName is empty</span>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  // function for sanitizing input
  function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
  ?>

  <h1>My Friends System<br>Log in Page</h1>
  <form method="post" action="login.php">
    <p><label for="email">Email</label>
      <input name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputEmail = validateField("Email", sanitizeInput($_POST['email']));
      }
      ?>
    </p>
    <p><label for="password">Password</label>
      <input type="password" name="password">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputPassword = validateField("Password", sanitizeInput($_POST['password']));
      }
      ?>
    </p>
    <?php
    // Check if the user has submitted the form
    if ($inputEmail && $inputPassword) {
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
          // Set up session variable(s) and redirect to friendlist.php
          session_start();
          $_SESSION['email'] = $inputEmail;
          $_SESSION['loggedIn'] = true;
          header("Location: friendlist.php");
          exit();
        } else {
          echo "<p>Incorrect email or password</p>";
        }
      } else {
        echo "<p>Incorrect email or password</p>";
      }

      mysqli_stmt_close($stmt);
    }
    ?>
    <p><input type="submit" value="Log in">
      <input type="reset" value="Clear">
    </p>
  </form>
  <p><a href="index.php">Home</a></p>
</body>

</html>