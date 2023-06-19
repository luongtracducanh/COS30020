<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab06 Task 2 - Sign Guestbook</h1>
    <hr>
    <?php
    umask(0007);
    $dir = "../../data/lab06";
    if (!file_exists($dir)) {
        mkdir($dir, 02770);
    }
    if (isset($_POST["name"]) && isset($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["email"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        // regex for email
        $regexp = "/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/";
        if (preg_match($regexp, $email)) {
            echo "<p style='color:green'>Email address is valid.</p>";

            $filename = "../../data/lab06/guestbook.txt";
            $nameArr = array();
            $emailArr = array();

            if (file_exists($filename)) {
                $handle = fopen($filename, "r");
                while (!feof($handle)) {
                    $line = fgets($handle);
                    $lineArr = explode(",", $line);
                    if (count($lineArr) == 2) {
                        array_push($nameArr, $lineArr[0]);
                        array_push($emailArr, trim($lineArr[1]));
                    }
                }
                fclose($handle);
            }

            if (!in_array($name, $nameArr) && !in_array($email, $emailArr)) {
                $handle = fopen($filename, "a");
                $data = $name . "," . $email . "\n";
                fwrite($handle, $data);
                fclose($handle);
                echo "<p style='color:green'>Thank you for signing our guest book:</p>";
                echo "<p><b>Name</b>: $name<br><b>E-mail</b>: $email</p>";
            } else {
                echo "<p style='color:red'>You have already signed our guest book!</p>";
            }
        } else {
            echo "<p style='color:red'>Email address is not valid.</p>";
        }
    } else {
        echo "<p style='color:red'>You must enter your name and email address!<br>Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
    }
    echo '<p><a href="guestbookform.php">Add Another Visitor</a><br><a href="guestbookshow.php">View Guest Book</a></p>';
    ?>
</body>

</html>