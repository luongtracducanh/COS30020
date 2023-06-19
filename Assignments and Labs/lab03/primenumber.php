<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab03 Task 3 - Prime Number</h1>
    <hr>
    <?php
    function is_prime($num)
    {
        for ($i = 2; $i <= sqrt($num); $i++) {
            if ($num % $i == 0) {
                return false;
            }
        }
        return true;
    }
    if (isset($_GET["num"])) {
        $num = $_GET["num"];
        if (is_numeric($num) && $num > 0 && $num == round($num)) {
            is_prime($num)
                ? print("<p>The number you entered $num is a prime number.</p>")
                : print("<p>The number you entered $num is not a prime number.</p>");
        } else {
            echo "<p>Please enter a positive integer.</p>";
        }
    } else {
        echo "<p>Please enter a positive integer.</p>";
    }
    ?>
</body>

</html>