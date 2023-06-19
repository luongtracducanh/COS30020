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
    $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    $day = "";
    echo "<p>The Days of the week in English are:<br>";
    for ($i = 0; $i < count($days); $i++) {
        $day .= " $days[$i],";
    }
    echo rtrim($day, ","), ".</p>";

    $days[0] = "Dimanche";
    $days[1] = "Lundi";
    $days[2] = "Mardi";
    $days[3] = "Mercredi";
    $days[4] = "Jeudi";
    $days[5] = "Vendredi";
    $days[6] = "Samedi";
    $day = "";
    echo "<p>The Days of the week in French are:<br>";
    for ($i = 0; $i < count($days); $i++) {
        $day .= " $days[$i],";
    }
    echo rtrim($day, ","), ".</p>";
    ?>
</body>

</html>