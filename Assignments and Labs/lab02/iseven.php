<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $num = 0;
    if (isset($_GET['num'])) {
        $num = $_GET['num'];
    }
    if (is_numeric($num)) {
        $new_num = round($num);
        if ($new_num % 2 == 0) {
            echo "<p>The variable $num <b>contains an even</b> number.</p>";
        } elseif ($new_num % 2 == 1) {
            echo "<p>The variable $num <b>contains an odd</b> number.</p>";
        }
    } else {
        echo "<p>The variable $num <b>does not contain a number</b>.</p>";
    }
    ?>
</body>

</html>