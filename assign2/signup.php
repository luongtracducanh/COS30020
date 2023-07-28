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
  $mail = $profileName = $password = null;
  // regexes for email, profile name, and password
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
      echo "<span class='err'>$fieldName is empty</span>";
    } else if (!preg_match($regex, $fieldValue)) {
      echo "<span class='err'>$errMsg</span>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  function checkUniqueEmail($email)
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
      echo "<span class='err'>Email already exists</span>";
      return false;
    }
    return true;
  }

  function checkMatchPasswords($password, $confirmPassword)
  {
    if ($password !== $confirmPassword) {
      echo "<span class='err'>Passwords do not match</span>";
      return false;
    }
    return true;
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
    <h1>Registration Page</h1>
    <form method="post" action="signup.php">
      <div class="row">
        <div class="col-25">
          <p><label for="email">Email</label> </p>
        </div>
        <div class="col-75">
          <p> <input name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $mail = validateField("Email", sanitizeInput($_POST['email']), $mailRegex, "Email is invalid");
              $isMailUnique = checkUniqueEmail($mail);
            }
            ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p><label for="profileName">Profile Name</label></p>
        </div>
        <div class="col-75">
          <p><input name="profileName" value="<?php echo isset($_POST['profileName']) ? htmlspecialchars($_POST['profileName']) : ''; ?>">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $profileName = validateField("Profile Name", sanitizeInput($_POST['profileName']), $profileRegex, "Profile Name is invalid");
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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $password = validateField("Password", sanitizeInput($_POST['password']), $passwordRegex, "Password is invalid");
            }
            ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p><label for="confirmPassword">Confirm Password</label></p>
        </div>
        <div class="col-75">
          <p><input type="password" name="confirmPassword">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $arePasswordsMatch = checkMatchPasswords($password, sanitizeInput($_POST['confirmPassword']));
            }
            ?>
          </p>
        </div>
      </div>

      <?php
      if ($mail && $profileName && $password && $isMailUnique && $arePasswordsMatch) {
        $sql = "INSERT INTO $table1 (friend_email, password, profile_name, date_started, num_of_friends) VALUES (?, ?, ?, CURDATE(), 0)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $mail, $password, $profileName);
        if (mysqli_stmt_execute($stmt)) {
          // start the session with the profile name and the number of friends
          session_start();
          $_SESSION['email'] = $mail;
          $_SESSION['loggedIn'] = true;
          header("Location: friendadd.php");
          exit();
        } else {
          echo "<p class='err' style=color:red>Error creating account: " . mysqli_error($conn) . "</p>";
        }
        mysqli_stmt_close($stmt);
      }
      ?>

      <p><input class="button-32" type="submit" value="Register">
        <!-- clear button as a link to refresh the page since the html clear button cant remove default values -->
        <a href="signup.php" class="btnclear">Clear</a>
      </p>
    </form>


    <!-- <p><a class="link" href="index.php"><span>Home</span></a></p> -->
  </div>
</body>

</html>