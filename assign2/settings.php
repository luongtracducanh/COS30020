<?php
// localhost
$host = "localhost";
$user = "ducanh";
$pswd = "ducanh2003";
$dbnm = "AWD";

// swin server
// $host = "feenix-mariadb.swin.edu.au";
// $user = "s103488117";
// $pswd = "181203";
// $dbnm = "s103488117_db";

// tabels used
$table1 = "friends";
$table2 = "myfriends";

// Connect to database
try {
  $conn = @mysqli_connect($host, $user, $pswd, $dbnm);
} catch (mysqli_sql_exception $e) {
  // Get error message
  $errMsg = $e->getMessage();
  session_start();
  // Store error message in session variable and redirect to error page
  $_SESSION["errMsg"] = $errMsg;
  header("Location: error.php");
  exit();
}
