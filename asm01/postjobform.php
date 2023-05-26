<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JVPS</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
</head>

<body>
    <h1>Job Vacancy Posting System</h1>
    <form method="POST" action="postjobform.php">
        <p>Position ID: <input type="text" id="posId" name="posId">
            <?php
            if (isset($_POST['posId'])) {
                if (empty($_POST['posId'])) {
                    echo 'Please enter a position ID.';
                } else if (!preg_match('/^P\d{4}$/', $_POST['posId'])) {
                    echo 'Please enter a unique 5-character code that starts with "P" and follows by 4 digits e.g. P0001.';
                } else {
                    $posId = $_POST['posId'];
                }
            }
            ?></p>
        <p>Title: <input type="text" id="title" name="title">
            <?php
            if (isset($_POST['title'])) {
                if (empty($_POST['title'])) {
                    echo 'Please enter a title.';
                } else if (!preg_match('/^[a-zA-Z0-9 ,.!]{1,20}$/', $_POST['title'])) {
                    echo 'Please enter a maximum of 20 characters without any special characacter (comma, period, and exclamation point are allowed).';
                } else {
                    $title = $_POST['title'];
                }
            }
            ?></p>
        <p>Description: <textarea id="des" name="des"></textarea>
            <?php
            if (isset($_POST['des'])) {
                if (empty($_POST['des'])) {
                    echo 'Please enter a description.';
                } else if (strlen($_POST['des']) > 260) {
                    echo 'Please enter a maximum of 260 characters.';
                } else {
                    $des = $_POST['des'];
                }
            }
            ?></p>
        <p>Closing Date: <input type="text" id="closingDate" name="closingDate" value="<?php echo date('d/m/y'); ?>">
        </p>
        <p>Position:
            <input type="radio" id="fullTime" name="position" value="Full Time">
            <label for="fullTime">Full Time</label>
            <input type="radio" id="partTime" name="position" value="Part Time">
            <label for="partTime">Part Time</label>
        </p>
        <p>Contract:
            <input type="checkbox" id="post" name="post" value="Post">
            <label for="post">Post</label>
            <input type="checkbox" id="email" name="email" value="Email">
            <label for="email">Email</label>
        </p>
        <p>Application By: <input type="checkbox"> Post <input type="checkbox">Mail</p>
        <p>Location:
            <select>
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
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
        <p>All fields are required. <a href="index.php">Return to Home Page</a></p>
    </form>
</body>

</html>