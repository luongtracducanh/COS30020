<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Friends System</title>
  <link rel="stylesheet" href="style/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
</head>

<body class="bg-image">
  <div " class=" header">
    <h1>My Friends System</h1>
    <div class="nav">
      <ul>
        <li class="nav-link"> <a href="friendlist.php"> List friends </a></li>
        <li class="nav-link"> <a href="logout.php"> Log out </a></li>
      </ul>
    </div>
  </div>
  <?php
  session_start();

  // Check if the user is logged in using session email and loggedIn session variable
  if (!isset($_SESSION["email"]) || !isset($_SESSION["loggedIn"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
  }

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

  <div class="content">
    <h2><?php echo $profileName ?>'s Add Friend Page</h2>
    <h2>Total number of friends is <?php echo $numOfFriends ?></h2>
    <!-- Table displaying the list and add friend button -->
    <div class='addfriendtable'>
      <?php
      if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered table-info table-striped'>";
        echo "<thead><tr><th>Profile Name</th><th>Mutual Friends</th><th>Action</th></tr></thead>";
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
          echo "<tbody>";
          echo "<tr>";
          echo "<td>{$friendProfileName}</td>";
          echo "<td>{$mutualFriendCount} mutual friends</td>";
          echo "<td>
                  <form method='post' action='friendadd.php'>
                    <input type='hidden' name='friendId' value='{$friendId}'>
                    <input type='hidden' name='page' value='{$currentPage}'>
                    <input class='btn btn-outline-info' type='submit' name='addfriend' value='Add as friend'>
                  </form>
                </td>";
          echo "</tr>";
          echo "</tbody>";
        }
        echo "</table>";

        // Generate pagination links
        echo "<div class='linkbtm'>";
        if ($currentPage > 1) {
          $previousPage = $currentPage - 1;
          echo "<a class='pagenumber' href='friendadd.php?page={$previousPage}'>Previous</a>&nbsp;";
        }

        // page numbers for pagination
        for ($i = 1; $i <= $totalPages; $i++) {
          $activeClass = ($i == $currentPage) ? 'active' : '';
          echo "<a href='friendadd.php?page={$i}' class='{$activeClass} pagenumber'>$i</a>&nbsp;";
        }

        if ($currentPage < $totalPages) {
          $nextPage = $currentPage + 1;
          echo "<a class='pagenumber' href='friendadd.php?page={$nextPage}'>Next</a>";
        }
        echo "</div>";
      } else {
        echo "<p class='nofriend'>No friend to add.</p>";
      }

      // Close the result and connection
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      ?>
      <div class="friendslinks">
        <p><a class="link" href="friendlist.php"><span>Friend Lists</span></a></p><br>
        <p><a class="link" href="logout.php"><span>Log out</span></a></p>
      </div>
    </div>
  </div>
  </div>
  </div>
</body>

</html>