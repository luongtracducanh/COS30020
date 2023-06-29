<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Add Member Form</h1>
  <form action="member_add.php" method="post">
    <p><label for="fname">First Name:</label>
      <input name="fname" />
    </p>
    <p><label for="lname">Last Name:</label>
      <input name="lname" />
    </p>
    <p><label for="gender">Gender:</label>
      <label>
        <input type="radio" name="gender" value="M">
        M
      </label>
      <label>
        <input type="radio" name="gender" value="F">
        F
      </label>
    </p>
    <p><label for="email">Email:</label>
      <input name="email" />
    </p>
    <p><label for="phone">Phone:</label>
      <input name="phone" />
    </p>
    <p>
      <input type="submit" value="Add Member" />
      <input type="reset" value="Clear Form" />
    </p>
  </form>
</body>

</html>