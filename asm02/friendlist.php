<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
</head>

<body>
  <?php
  session_start();

  // Check if the user is logged in
  if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
  }

  require_once("settings.php");

  // Connect to database
  $conn = mysqli_connect($host, $user, $pswd, $dbnm);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Query the result for profile name and number of friends
  $sql = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $_SESSION["email"]);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  // Get the profile name and number of friends
  $profileName = $row["profile_name"];
  $numOfFriends = $row["num_of_friends"];
  $userId = $row["friend_id"];

  // Get the list of friends of the logged in user
  $sql = "SELECT f.friend_id, f.profile_name
          FROM friends AS f
          INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
          WHERE mf.friend_id1 = ?
          ORDER BY f.profile_name";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  function deleteFriend($friendId)
  {
    global $conn, $numOfFriends, $userId;

    // Delete the friend from the myfriends table
    $sql = "DELETE FROM myfriends WHERE friend_id1 = ? AND friend_id2 = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $friendId);
    mysqli_stmt_execute($stmt);
    // 2-way friendship
    $sql = "DELETE FROM myfriends WHERE friend_id1 = ? AND friend_id2 = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $friendId, $userId);
    mysqli_stmt_execute($stmt);

    // Update the number of friends of the logged in user
    $numOfFriends--;
    $sql = "UPDATE friends SET num_of_friends = ? WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $numOfFriends, $userId);
    mysqli_stmt_execute($stmt);

    // Get the number of friends of the friend
    $sql = "SELECT num_of_friends FROM friends WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $friendId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $numOfFriends2 = $row["num_of_friends"];

    // Update the number of friends of the friend
    $numOfFriends2--;
    $sql = "UPDATE friends SET num_of_friends = ? WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $numOfFriends2, $friendId);
    mysqli_stmt_execute($stmt);
  }

  // Unfriend button
  if (isset($_POST["unfriend"])) {
    deleteFriend($_POST["friendId"]);

    // Redirect to the friendlist page
    header("Location: friendlist.php");
    exit();
  }
  ?>

  <h1>My Friends System<br><?php echo $profileName ?> Page<br>Total number of friends is <?php echo $numOfFriends ?></h1>
  <!-- Table displaying friends and unfriend button -->
  <?php
  // Check if any friends are found
  if (mysqli_num_rows($result) > 0) {
    echo "<table border=1>";
    echo "<tr><th>Profile Name</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      $friendId = $row["friend_id"];
      $friendProfileName = $row["profile_name"];
      echo "<tr>";
      echo "<td>{$friendProfileName}</td>";
      echo "<td>
      <form method='post' action='friendlist.php'>
        <input type='hidden' name='friendId' value='{$friendId}'>
        <input type='submit' name='unfriend' value='Unfriend'>
      </form>
      </td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No friend found.</p>";
  }

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  ?>
  <p><a href="friendadd.php">Add Friends</a></p>
  <p><a href="logout.php">Log out</a></p>
</body>

</html>