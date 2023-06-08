<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab05 Task 2 - Sign Guestbook</h1>
    <hr>
    <?php
    umask(0007);
    $dir = "../../data/lab05";
    if (!file_exists($dir)) {
        mkdir($dir, 02770);
    }
    if (isset($_POST["fName"]) && isset($_POST["lName"]) && !empty($_POST["fName"]) && !empty($_POST["lName"])) {
        $fName = $_POST["fName"];
        $lName = $_POST["lName"];
        $filename = "../../data/lab05/guestbook.txt";
        $handle = fopen($filename, "a");
        // method 1 to write file
        $data = addslashes($fName . " " . $lName . "\n");
        fwrite($handle, $data);
        // method 2 to write file
        // file_put_contents($filename, $data, FILE_APPEND);
        fclose($handle);
        echo "<p style='color:green'>Thank you for signing our guest book!</p>";
    } else {
        echo "<p style='color:red'>You must enter your first and last name!<br>Use the Browser's 'Go Back' button to return to the Guestbook form.</p>";
    }
    echo '<p><a href="guestbookshow.php">Show Guest Book</a></p>';
    ?>
</body>

</html>