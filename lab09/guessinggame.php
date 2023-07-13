<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab 9 - Task 2</title>
</head>

<body>
  <h1>Guessing Game</h1>
  <p>Enter a number between 1 and 100, then press the Guess button.</p>
  <form method="post">
    <p>
      <input name="guessNum">
      <input type="submit" value="Guess">
    </p>
  </form>
  <?php
  session_start();

  // check if random number has already been generated
  if (!isset($_SESSION["randNum"])) {
    // generate a random number between 1 and 100
    $_SESSION["randNum"] = rand(1, 100);
    // initialize the guess count
    $_SESSION["guessCount"] = 0;
  }

  // check if user has submitted a guess
  if (isset($_POST["guessNum"])) {
    if (is_numeric($_POST["guessNum"]) && !empty($_POST["guessNum"]) && $_POST["guessNum"] >= 1 && $_POST["guessNum"] <= 100) {
      $guess = $_POST["guessNum"];
      $_SESSION["guessCount"]++;

      // Compare guess to random number
      if ($guess < $_SESSION["randNum"]) echo "<p>Guess higher!</p>";
      else if ($guess > $_SESSION["randNum"]) echo "<p>Guess lower!</p>";
      else echo "<p style='color:green'>Congratulations! You guessed the hidden numer.</p>";
    } else {
      echo "<p style='color:red'>You must enter a number between 1 and 100!</p>";
    }
  } else {
    echo "<p>Start guessing.</p>";
  }
  ?>
  <p>Number of guesses: <?php echo $_SESSION["guessCount"]; ?>.</p>
  <p><a href="giveup.php">Give Up</a></p>
  <p><a href="startover.php">Start Over</a></p>
</body>

</html>