<?php
mysqli_report(MYSQLI_REPORT_OFF);

// swin server
// $host = "feenix-mariadb.swin.edu.au";
// $user = "s103488117";
// $pswd = "181203";
// $dbnm = "s103488117_db";

// localhost
$host = "localhost";
$user = "ducanh";
$pswd = "ducanh2003";
$dbnm = "AWD";

// tabels used
$table1 = "friends";
$table2 = "myfriends";

// Connect to database on PHP 5.4.16
$conn = @mysqli_connect($host, $user, $pswd, $dbnm);
if (!$conn) {
  // Get error message
  $errMsg = mysqli_connect_error();
  $errNo = mysqli_connect_errno();
  session_start();
  // Store error message in session variable and redirect to error page
  $_SESSION["errMsg"] = $errMsg;
  $_SESSION["errNo"] = $errNo;
  header("Location: error.php");
  exit();
}
