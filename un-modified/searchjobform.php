<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JVPS</title>
</head>

<body>
  <h1>Job Vacancy Posting System</h1>
  <form method="GET" action="searchjobprocess.php">
    <p>Job Title:
      <input type="text" id="title" name="title">
    </p>
    <p>Position:
      <input type="radio" id="fullTime" name="position" value="Full Time">
      <label for="fullTime">Full Time</label>
      <input type="radio" id="partTime" name="position" value="Part Time">
      <label for="partTime">Part Time</label>
    </p>
    <p>Contract:
      <input type="radio" id="onGoing" name="contract" value="On-going">
      <label for="onGoing">On-going</label>
      <input type="radio" id="fixedTerm" name="contract" value="Fixed term">
      <label for="fixedTerm">Fixed term</label>
    </p>
    <p>Accepted application By:
      <input type="checkbox" id="post" name="app[]" value="Post">
      <label for="post">Post</label>
      <input type="checkbox" id="mail" name="app[]" value="Mail">
      <label for="mail">Mail</label>
    </p>
    <p>Location:
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
    </p>
    <button>Search</button>
    <button type="reset">Reset</button>
  </form>
  <p><a href="index.php">Return to Home Page</a></p>
</body>

</html>