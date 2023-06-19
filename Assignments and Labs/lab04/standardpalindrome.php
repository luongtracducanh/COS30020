<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab04 Task 3 - Standard Palindrome</h1>
    <hr>
    <?php
    if (isset($_POST['str']) && !empty($_POST['str'])) {
        $str = $_POST['str'];
        $newstr = "";
        $pattern = "/^[A-Za-z]+$/";
        for ($i = 0; $i < strlen($str); $i++) {
            $letter = substr($str, $i, 1);
            if (preg_match($pattern, $letter)) {
                $newstr .= $letter;
            }
        }
        $revstr = strrev($newstr);
        if (strcmp(strtolower($newstr), strtolower($revstr)) === 0) {
            echo "<p>The text you entered '$str' is a standard palindrome!</p>";
        } else {
            echo "<p>The text you entered '$str' is not a standard palindrome.</p>";
        }
    } else {
        echo "<p>Please enter a string.</p>";
    }
    ?>
</body>

</html>