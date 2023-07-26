<?php
// localhost
$host = "localhost";
$user = "ducanh";
$pswd = "ducanh2003";
$dbnm = "AW";

// swin server
// $host = "feenix-mariadb.swin.edu.au";
// $user = "s103488117";
// $pswd = "181203";
// $dbnm = "s103488117_db";

// 000webhost server
// $host = "localhost";
// $user = "id21037306_ducanh";
// $pswd = "Tomato1309*";
// $dbnm = "id21037306_awd";

// tabels used
$table1 = "friends";
$table2 = "myfriends";

// Connect to database on later versions of PHP
// try {
//   $conn = @mysqli_connect($host, $user, $pswd, $dbnm);
// } catch (mysqli_sql_exception $e) {
//   // Get error message
//   $errMsg = $e->getMessage();
//   session_start();
//   // Store error message in session variable and redirect to error page
//   $_SESSION["errMsg"] = $errMsg;
//   header("Location: error.php");
//   exit();
// }

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
