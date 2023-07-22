<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="Trac Duc Anh Luong" />
  <title>Web Programming - Lab10</title>
</head>

<body>
  <h1>Web Programming - Lab10</h1>
  <form method="post">
    <p>Username: <input name="username" /></p>
    <p>Password: <input name="password" type="password" /></p>
    <p>Database name: <input name="dbname" /></p>
    <p>
      <input type="submit" value="Set Up" />
      <input type="reset" value="Reset" />
    </p>
  </form>
</body>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $host = "feenix-mariadb.swin.edu.au";
  // $host = "localhost";
  if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["dbname"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["dbname"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $dbname = $_POST["dbname"];

    // establish connection to the database
    $dbConnect = new mysqli($host, $username, $password, $dbname);
    if ($dbConnect->connect_error)
      die("<p>Unable to connect to the database server.</p>"
        . "<p>Error code " . $dbConnect->connect_errno
        . ": " . $dbConnect->connect_error . "</p>");
    else {
      $table = "hitcounter";
      $sql1 = "CREATE TABLE $table ( `id` SMALLINT NOT NULL PRIMARY KEY, `hits` SMALLINT NOT NULL );";
      $sql2 = "INSERT INTO $table VALUES (1,0);";

      // execute the queries
      $queryResult = $dbConnect->query($sql1)
        or die("<p>Unable to execute the query.</p>"
          . "<p>Error code " . $dbConnect->errno
          . ": " . $dbConnect->error . "</p>");

      $queryResult = $dbConnect->query($sql2)
        or die("<p>Unable to execute the query.</p>"
          . "<p>Error code " . $dbConnect->errno
          . ": " . $dbConnect->error . "</p>");

      echo "<p>Database successfully set up.</p>";

      // write the database connection details to a file
      umask(0007);
      $directory = "../../data/lab10";
      if (!file_exists($directory)) {
        mkdir($directory, 02770);
      }
      $filename = "../../data/lab10/mykeys.txt";
      // we use the w flag so that the contents of the file are overwritten
      $handle = fopen($filename, "w");
      if (!$handle) {
        echo "<p>Unable to open the file.</p>";
      } else {
        $data = $host . "\n" . $username . "\n" . $password . "\n" . $dbname . "\n";
        fwrite($handle, $data);
        fclose($handle);
        echo "<p>Database connection details written to file.</p>";
        echo "<p><a href='countvisits.php'>Count Visits</a></p>";
      }
    }
    $dbConnect->close();
  } else {
    echo "<p>Please enter all database connection details.</p>";
  }
}
?>

</html>