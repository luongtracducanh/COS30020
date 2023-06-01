<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab03 Task 2 - Leap Year</h1>
    <hr>
    <form action="leapyear_selfcall.php" method="get">
        <p>Year: <input type="number" name="year" /></p>
        <input type="submit" value="Check for Leap Year" />
    </form>
    <?php
    function is_leapyear($year)
    {
        if ($year % 400 == 0) {
            return true;
        } else if ($year % 100 == 0) {
            return false;
        } else if ($year % 4 == 0) {
            return true;
        } else {
            return false;
        }
    }
    if (isset($_GET["year"])) {
        $year = $_GET["year"];
        if (is_numeric($year) && $year > 0 && $year == round($year)) {
            is_leapyear($year)
                ? print("<p>The year you entered $year is a leap year.</p>")
                : print("<p>The year you entered $year is not a leap year.</p>");
        } else {
            echo "<p>Please enter a positive integer.</p>";
        }
    }
    ?>
</body>

</html>