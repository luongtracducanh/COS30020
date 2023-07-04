<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="style/style.css">
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

  // Pagination settings
  $limit = 5; // Number of names per page

  // Query to retrieve friends who are not already added
  $sql = "SELECT friend_id, profile_name
          FROM friends
          WHERE friend_id NOT IN (
            SELECT f.friend_id
            FROM friends AS f
            INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
            WHERE mf.friend_id1 = ?
          ) AND friend_id != ?
          ORDER BY profile_name";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $userId, $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  function addFriend($friendId)
  {
    global $conn, $numOfFriends, $userId;

    // Delete the friend from the myfriends table
    $sql = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $friendId);
    mysqli_stmt_execute($stmt);
    // 2-way friendship
    $sql = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $friendId, $userId);
    mysqli_stmt_execute($stmt);

    // Update the number of friends of the logged in user
    $numOfFriends++;
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
    $numOfFriends2++;
    $sql = "UPDATE friends SET num_of_friends = ? WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $numOfFriends2, $friendId);
    mysqli_stmt_execute($stmt);
  }

  // Add friend button
  if (isset($_POST["addfriend"])) {
    addFriend($_POST["friendId"]);

    // Redirect to the friendlist page
    header("Location: friendadd.php");
    exit();
  }

  // Pagination logic
  $totalNames = mysqli_num_rows($result);
  $totalPages = ceil($totalNames / $limit);
  $currentPage = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;
  $offset = ($currentPage - 1) * $limit;

  // Retrieve friends for the current page
  $sql = "SELECT friend_id, profile_name
          FROM friends
          WHERE friend_id NOT IN (
            SELECT f.friend_id
            FROM friends AS f
            INNER JOIN myfriends AS mf ON (f.friend_id = mf.friend_id2)
            WHERE mf.friend_id1 = ?
          ) AND friend_id != ?
          ORDER BY profile_name
          LIMIT ?, ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iiii", $userId, $userId, $offset, $limit);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  ?>
  <h1>My Friends System<br><?php echo $profileName ?>'s Add Friend Page<br>Total number of friends is <?php echo $numOfFriends ?></h1>
  <!-- Table displaying the list and add friend button -->
  <?php
  if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    while ($row = mysqli_fetch_assoc($result)) {
      $friendId = $row["friend_id"];
      $friendProfileName = $row["profile_name"];
      echo "<tr>";
      echo "<td>{$friendProfileName}</td>";
      echo "<td>
      <form method='post' action='friendadd.php'>
        <input type='hidden' name='friendId' value='{$friendId}'>
        <input type='submit' name='addfriend' value='Add as friend'>
      </form>
      </td>";
      echo "</tr>";
    }
    echo "</table>";

    // Generate pagination links
    echo "<div>";
    if ($currentPage > 1) {
      $previousPage = $currentPage - 1;
      echo "<a href='friendadd.php?page={$previousPage}'>Previous</a>&nbsp;";
    }

    for ($i = 1; $i <= $totalPages; $i++) {
      $activeClass = ($i == $currentPage) ? 'active' : '';
      echo "<a href='friendadd.php?page={$i}' class='{$activeClass}'>$i</a>&nbsp;";
    }

    if ($currentPage < $totalPages) {
      $nextPage = $currentPage + 1;
      echo "<a href='friendadd.php?page={$nextPage}'>Next</a>";
    }
    echo "</div>";
  } else {
    echo "<p>No friend to add.</p>";
  }

  // Close the result and connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
  ?>
  <p><a href="friendlist.php">Friend Lists</a></p>
  <p><a href="logout.php">Log out</a></p>
</body>

</html>