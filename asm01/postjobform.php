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
    <form method="POST">
        <p>Position ID: <input type="text" id="positionId" name="positionId"></p>
        <p>Title: <input type="text" id="title" name="title"></p>
        <p>Description: <textarea id="description" name="description"></textarea></p>
        <p>Closing Date: <input type="text" id="closingDate" name="closingDate" value="<?php echo date('d/m/y'); ?>"></p>
        <p>Position:
            <input type="radio" id="fullTime" name="position" value="Full Time">
            <label for="fullTime">Full Time</label>
            <input type="radio" id="partTime" name="position" value="Part Time">
            <label for="partTime">Part Time</label>
        </p>
        <p>Contract:
            <input type="checkbox" id="post" name="applicationMethod[]" value="Post">
            <label for="post">Post</label>
            <input type="checkbox" id="email" name="applicationMethod[]" value="Email">
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