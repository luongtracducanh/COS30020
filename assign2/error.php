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
  </div>
  <div class="login-text">
    <h1 style="font-size: 80px; margin: 0">Error Page</h1>
    <?php
    session_start();
    // check if error message is set
    if (isset($_SESSION["errMsg"]) && isset($_SESSION["errNo"])) {
      $errMsg = $_SESSION["errMsg"];
      $errNo = $_SESSION["errNo"];
      echo "<p class='errorpage'><b>Error encountered: </b><br>$errMsg (Code: $errNo).</br></p>";
    } else {
      echo "<p>No error encountered. Redirecting to the home page...</p>";
    }

    // Redirect to logout page to: 
    // - unset all session variables
    // - redirect to the home page
    // - home page will redirect to error page if there is an error
    // - keep this loop unless there is no error
    header("Refresh: 5; URL=logout.php");
    ?>
  </div>
</body>

</html>