<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 9 - Task 2</title>
</head>

<body>
  <h1>Guessing Game</h1>
  <p style="color: blue;">The hidden number was:
    <?php
    session_start();
    if (isset($_SESSION["randNum"])) {
      echo $_SESSION["randNum"];
    } else {
      echo "not generated";
    }
    ?>
  </p>
  <p><a href="startover.php">Start Over</a></p>
</body>

</html>