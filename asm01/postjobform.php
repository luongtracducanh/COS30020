<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JVPS</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
  <h1 class="header">Job Vacancy Posting System</h1>
  <nav>
    <ul class="navigator">
      <li class="navlist"> <a href="index.php">Home</a></li>
      <li class="navlist current"> <a href="postjobform.php">Post job</a></li>
      <li class="navlist"> <a href="searchjobform.php"> Search job</a></li>
      <li class="navlist"> <a href="about.php">About assignment</a></li>
    </ul>
  </nav>
  <div class="container">
    <form method="POST" action="postjobprocess.php">
      <div class="row">
        <div class="col-25">
          <p>Position ID:</p>
        </div>
        <div class="col-75">
          <p><input type="text" id="posId" name="posId"></p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Title:</p>
        </div>
        <div class="col-75">
          <p> <input type="text" id="title" name="title"></p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Description:</p>
        </div>
        <div class="col-75">
          <p> <textarea id="des" name="des"></textarea></p>
          <!-- <p class="note"><i>Note: The description criteria will be displayed in a bullet point list.<br>Simply enter each criteria on a new line in the text area, it will be automatically created the list.</i></p> -->
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <!-- echo current date using php -->
          <p>Closing Date:</p>
        </div>
        <div class="col-75">
          <p> <input type="text" id="date" name="date" placeholder="dd/mm/yy" value="<?php echo date('d/m/y'); ?>"></p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Position:</p>
        </div>
        <div class="col-75">
          <p>
            <input type="radio" id="fullTime" name="position" value="Full Time">
            <label for="fullTime">Full Time</label>
            <input type="radio" id="partTime" name="position" value="Part Time">
            <label for="partTime">Part Time</label>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Contract:</p>
        </div>
        <div class="col-75">
          <p>
            <input type="radio" id="onGoing" name="contract" value="On-going">
            <label for="onGoing">On-going</label>
            <input type="radio" id="fixedTerm" name="contract" value="Fixed term">
            <label for="fixedTerm">Fixed term</label>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Accepted application by:</p>
        </div>
        <div class="col-75">
          <p>
            <input type="checkbox" id="post" name="app[]" value="Post">
            <label for="post">Post</label>
            <input type="checkbox" id="mail" name="app[]" value="Mail">
            <label for="mail">Mail</label>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-25">
          <p>Location:</p>
        </div>
        <div class="col-75">

          <select name="location">
            <option value="">---</option>
            <option value="ACT">ACT</option>
            <option value="NSW">NSW</option>
            <option value="NT">NT</option>
            <option value="QLD">QLD</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="VIC">VIC</option>
            <option value="WA">WA</option>
          </select>

        </div>
      </div>

      <div class="submit">
        <input class="button" type="submit" value="Submit">
        <input class="button" type="reset" value="Reset">
      </div>
      <div class="lastnote">
        <p class="note">All fields are required.</p>
        <p class="return"><a href="index.php"><span>Return to Home Page</span></a></p>
      </div>
    </form>
    <div class="push"></div>
  </div>
  <footer class="footer">
    <p>Copyright @2023</p>
  </footer>
</body>

</html>