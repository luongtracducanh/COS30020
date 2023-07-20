<?php
class HitCounter
{
  private $dbConnect;
  function __construct($host, $username, $password, $dbname)
  {
    // establish connection to the database
    $this->dbConnect = new mysqli($host, $username, $password, $dbname);
    if ($this->dbConnect->connect_error)
      die("<p>Unable to connect to the database server.</p>"
        . "<p>Error code " . $this->dbConnect->connect_errno
        . ": " . $this->dbConnect->connect_error . "</p>");
    // check if the table exists
    $table = "hitcounter";
    $sql = "SELECT * FROM $table;";
    $this->dbConnect->query($sql)
      or die("<p>Unable to execute the query.</p>"
        . "<p>Error code " . $this->dbConnect->errno
        . ": " . $this->dbConnect->error . "</p>");
  }

  function getHits()
  {
    $sql = "SELECT * FROM hitcounter;";
    $this->dbConnect->query($sql)
      or die("<p>Unable to execute the query.</p>"
        . "<p>Error code " . $this->dbConnect->errno
        . ": " . $this->dbConnect->error . "</p>");
    $result = $this->dbConnect->query($sql);
    $row = $result->fetch_assoc();
    return $row["hits"];
  }

  function setHits($hit)
  {
    $sql = "UPDATE hitcounter SET hits = $hit;";
    $this->dbConnect->query($sql)
      or die("<p>Unable to execute the query.</p>"
        . "<p>Error code " . $this->dbConnect->errno
        . ": " . $this->dbConnect->error . "</p>");
  }

  function closeConnection()
  {
    $this->dbConnect->close();
  }

  function startOver()
  {
    $sql = "UPDATE hitcounter SET hits = 0;";
    $this->dbConnect->query($sql)
      or die("<p>Unable to execute the query.</p>"
        . "<p>Error code " . $this->dbConnect->errno
        . ": " . $this->dbConnect->error . "</p>");
  }
}
