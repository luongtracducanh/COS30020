<?php
session_start(); // start the session
$_SESSION = array(); // unset all session variables
session_destroy(); // destroy all data associated with the session
header("location:guessinggame.php"); // redirect to guessinggame.php
