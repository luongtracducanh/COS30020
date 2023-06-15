<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Lab06 Task 2 - Guestbook</h1>
    <h2>View Guestbook</h2>
    <hr>
    <?php
    $fileName = "../../data/lab06/guestbook.txt";
    if (!file_exists($fileName) || filesize($fileName) == 0) {
        echo "<p style='color:red'>No guestbook entries found!</p>";
    } else {
        $fileArr = file($fileName);
        echo "<table>";
        echo "<tr>";
        echo "<th>Number</th>";
        echo "<th>Name</th>";
        echo "<th>Email</th>";
        echo "</tr>";
        for ($i = 0; $i < count($fileArr); $i++) {
            $lineArr = explode(",", $fileArr[$i]);

            echo "<tr>";
            echo "<td class='center'><b>" . ($i + 1) . "</b></td>";
            echo "<td>" . $lineArr[0] . "</td>";
            echo "<td>" . $lineArr[1] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
    <hr>
    <p><a href="guestbookform.php">Add Another Visitor</a></p>
</body>

</html>