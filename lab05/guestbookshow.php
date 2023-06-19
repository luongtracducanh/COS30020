<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Lab05 Task 2 - Guestbook Show</h1>
    <hr>
    <?php
    $filename = "../../data/lab05/guestbook.txt";
    if (!file_exists($filename)) {
        echo "<p style='color:red'>Guestbook is empty!</p>";
        exit;
    } else {
        $handle = fopen($filename, "r");
        // method 1 to read file
        $data = "";
        while (!feof($handle)) {
            $temp = stripslashes(fgets($handle));
            $data .= $temp;
        }
        // method 2 to read file
        // $data = fread($handle, filesize($filename));
        echo "<p style='color:green'>Guest book entries:</p>";
        echo "<pre style=\"font-family: 'Times New Roman', Times, serif;\">$data</pre>";
        fclose($handle);
    }
    ?>
</body>

</html>