<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
</head>

<body>
  <?php
  session_start();

  require_once("settings.php");

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

  // Add friend function
  function addFriend($friendId)
  {
    global $conn, $numOfFriends, $userId, $table1, $table2;

    // Delete the friend from the myfriends table
    $sql = "INSERT INTO $table2 (friend_id1, friend_id2) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $friendId);
    mysqli_stmt_execute($stmt);

    // Update the number of friends of the logged in user
    $numOfFriends++;
    $sql = "UPDATE $table1 SET num_of_friends = ? WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $numOfFriends, $userId);
    mysqli_stmt_execute($stmt);

    // Get the number of friends of the friend
    $sql = "SELECT num_of_friends FROM $table1 WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $friendId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $numOfFriends2 = $row["num_of_friends"];

    // Update the number of friends of the friend
    $numOfFriends2++;
    $sql = "UPDATE $table1 SET num_of_friends = ? WHERE friend_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $numOfFriends2, $friendId);
    mysqli_stmt_execute($stmt);
  }

  // Add friend button
  if (isset($_POST["addfriend"])) {
    addFriend($_POST["friendId"]);

    // keep the current page after adding a friend
    header("Location: friendadd.php?page={$_POST['page']}");
    exit();
  }

  // Pagination settings
  $limit = 5; // Number of names per page

  // Get number of accounts that are not friends of the logged in user
  $sql = "SELECT COUNT(f.friend_id) AS total_names
          FROM $table1 f
          WHERE f.friend_id != ?
            AND f.friend_id NOT IN (
              SELECT mf.friend_id1
              FROM $table2 mf
              WHERE mf.friend_id2 = ?)
            AND f.friend_id NOT IN (
              SELECT mf.friend_id2
              FROM $table2 mf
              WHERE mf.friend_id1 = ?)";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iii", $userId, $userId, $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  // Pagination
  $totalNames = $row["total_names"];
  $totalPages = ceil($totalNames / $limit);
  $currentPage = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;
  $offset = ($currentPage - 1) * $limit;

  // Retrieve friends for the current page
  $sql = "SELECT f.friend_id, f.profile_name
          FROM $table1 f
          WHERE f.friend_id != ?
            AND f.friend_id NOT IN (
              SELECT mf.friend_id1
              FROM $table2 mf
              WHERE mf.friend_id2 = ?)
            AND f.friend_id NOT IN (
              SELECT mf.friend_id2
              FROM $table2 mf
              WHERE mf.friend_id1 = ?)
              LIMIT ?, ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "iiiii", $userId, $userId, $userId, $offset, $limit);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  ?>
  <h1>My Friends System<br><?php echo $profileName ?>'s Add Friend Page<br>Total number of friends is <?php echo $numOfFriends ?></h1>
  <!-- Table displaying the list and add friend button -->
  <?php
  if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Profile Name</th><th>Mutual Friends</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      $friendId = $row["friend_id"];
      $friendProfileName = $row["profile_name"];
      // get mutual friends count
      $sql2 = "SELECT friend_id, COUNT(*) AS mutual_friend_count
      FROM $table1 AS f JOIN $table2 AS mf
      ON (f.friend_id = mf.friend_id1 AND mf.friend_id2 = {$row['friend_id']})
      OR (f.friend_id = mf.friend_id2 AND mf.friend_id1 = {$row['friend_id']})
      WHERE f.friend_id != ?
      AND f.friend_id IN (
        SELECT friend_id1 FROM $table2 WHERE friend_id2 = $userId
        UNION SELECT friend_id2 FROM $table2 WHERE friend_id1 = $userId
      )";
      $stmt = mysqli_prepare($conn, $sql2);
      mysqli_stmt_bind_param($stmt, "i", $userId);
      mysqli_stmt_execute($stmt);
      $result2 = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result2);

      // Display the queried data
      $mutualFriendCount = $row["mutual_friend_count"];
      echo "<tr>";
      echo "<td>{$friendProfileName}</td>";
      echo "<td>{$mutualFriendCount} mutual friends</td>";
      echo "<td>
      <form method='post' action='friendadd.php'>
        <input type='hidden' name='friendId' value='{$friendId}'>
        <input type='hidden' name='page' value='{$currentPage}'>
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

    // page numbers for pagination
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