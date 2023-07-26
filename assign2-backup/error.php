<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <h1>My Friends System<br>Error Page</h1>
  <?php
  session_start();
  // check if error message is set
  if (isset($_SESSION["errMsg"])) {
    $errMsg = $_SESSION["errMsg"];
    echo "<p><b>Error encountered:</b> <span style=color:red>$errMsg.</span></p>";
  } else {
    echo "<p>No error encountered. Redirecting to the home page...</p>";
  }

  // Redirect to logout page to: 
  // - unset all session variables
  // - redirect to the home page
  // - home page will redirect to error page if there is an error
  // - keep this loop unless there is no error
  header("Refresh: 1; URL=logout.php");
  ?>
</body>

</html>