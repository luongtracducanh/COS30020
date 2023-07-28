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
    <ul class="nav">
      <li class="nav-link"><a href="index.php">Home</a></li>
      <li class="nav-link"><a href="signup.php">Sign-Up</a></li>
      <li class="nav-link"><a href="login.php">Login</a></li>
      <li class="nav-link"><a href="about.php">About</a></li>
    </ul>
  </div>

  <div class="about-text">
    <h1 style="text-align: center;">About Page</h1>
    <ul>
      <li>I have attempted and completed all tasks.</li>
      <li>The special features that I have done in creating the site were:</li>
      <ul>
        <li>MySQL connection error checking and handling: Re-direct the user to an error page with the relevant error code and message.</li>
      </ul>
      <li>I had had trouble with the mutual friend count in the add friend page but after a couple of tries I could handle it.</li>
      <li>I would like to build the program in a better structure next time, using OOP concepts for better maintenance and scalability.</li>
      <li>The additional features that I added to the assignment were:</li>
      <ul>
        <li>Styling and navigation using Bootstrap and additional CSS.</li>
      </ul>
    </ul>
    <h3>Discussion response</h3>
    <figure>
      <img style="width: 70%;" src="images/discussion.png" alt="Discussion response" class="my-image">
      <figcaption>Figure 1: Discussion response that answered someone's thread in the unit's discussion board for Assignment 2</figcaption>
    </figure>
    <div class="friendslinks">
      <p><a class="link" href="friendlist.php"><span>Friend List</span></a></p>
      <br>
      <p><a class="link" href="friendadd.php"><span>Friend Add</span></a></p>
      <br>
    </div>
  </div>
</body>

</html>