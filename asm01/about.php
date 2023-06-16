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
      <li class="navlist"> <a href="postjobform.php">Post job</a></li>
      <li class="navlist"> <a href="searchjobform.php"> Search job</a></li>
      <li class="navlist current"> <a href="about.php">About assignment</a></li>
    </ul>
  </nav>
  <div class="container">
    <ul class="content">
      <li class="detail">The PHP version installed in Mercury is 5.4.16.</li>
      <li class="detail">I have attempted and completed all tasks.</li>
      <li class="detail">In the special feature section, I have implemented the following enhancement(s):
        <ul>
          <!-- <li><span class="list">Automatic listing for the description field: </span> Users can now enter multiple job criteria by simply adding a new line. Each criterion will be added as a separate item in the list, which will be displayed on the search page.</li> -->
          <li><span class="list">Vietnamese language support:</span> The system now supports job posting and searching in Vietnamese. I have modified the regular expression pattern for post validation to accommodate Vietnamese characters, and implemented a <span class="code">replaceVnese()</span> function to enable search filtering with accurate results.</li>
        </ul>
      </li>
    </ul>
    <h3>Discussion points participated</h3>
    <figure>
      <img src="images/discuss1.png" alt="Discussion point 1" class="my-image">
      <figcaption>Figure 1: Discussion point 1</figcaption>
    </figure>
    <br>
    <figure>
      <img src="images/discuss2.png" alt="Discussion point 2" class="my-image">
      <figcaption>Figure 2: Discussion point 2</figcaption>
    </figure>
    <br>
    <figure>
      <img src="images/discuss3.png" alt="Discussion point 3" class="my-image">
      <figcaption>Figure 3: Discussion point 3</figcaption>
    </figure>
    <br>
    <div class="lastnote">
      <p class="return"><a href="index.php"><span>Return to Home Page</span></a></p>
    </div>
    <div class="push"></div>
  </div>
  <footer class="footer">
    <p>Copyright @2023</p>
  </footer>
</body>

</html>