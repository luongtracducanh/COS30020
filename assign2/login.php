<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body class="bg-image">
  <?php
  require_once("settings.php");

  // initialize variables
  $inputEmail = $inputPassword = $msg1 = $msg2 = $msg3 = $msg4 = null;

  // function for validating fields
  function validateField($fieldName, $fieldValue)
  {
    if (empty($fieldValue)) {
      echo "<span class='err'>$fieldName is empty</span>";
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
  <div class="header">
    <h1>My Friends System</h1>
    <ul class="nav">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="signup.php">Sign-Up</a></li>
      <li class="nav-link"><a href="login.php">Login</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
    </ul>
  </div>

  <div class="login-text">
    <h1>Log in page</h1>
    <form method="post" action="login.php">
      <div class="row">
        <div class="col-25">
          <p><label for="email">Email</label> </p>
        </div>
        <div class="col-75">
          <p><input name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <?php
            // sanitize input and validate email
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $inputEmail = validateField("Email", sanitizeInput($_POST['email']));
            }
            ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p><label for="password">Password</label></p>
        </div>
        <div class="col-75">
          <p><input type="password" name="password">
            <?php
            // sanitize input and validate password
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $inputPassword = validateField("Password", sanitizeInput($_POST['password']));
            }
            ?>
          </p>
        </div>
      </div>

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
            echo "<p class='err'>Incorrect email or password</p>";
          }
        } else {
          echo "<p class='err'>Incorrect email or password</p>";
        }

        mysqli_stmt_close($stmt);
      }
      ?>

      <p><input class="button-32" type="submit" value="Log in">
        <!-- clear button as a link to refresh the page since the html clear button cant remove default values -->
        <a href="login.php" class="btnclear">Clear</a>
      </p>
    </form>
  </div>
</body>

</html>