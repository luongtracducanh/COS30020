<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Trac Duc Anh Luong" />
    <title>TITLE</title>
</head>

<body>
    <h1>Web Programming - Lab 5</h1>
    <?php // read the comments for hints on how to answer each item
    if (isset($_POST["item"]) && isset($_POST["qty"]) && is_numeric($_POST["qty"])) { // check if both form data exists
        $item = $_POST["item"]; // obtain the form item data
        $qty = $_POST["qty"]; // obtain the form quantity data
        $filename = "../../data/shop.txt"; // assumes php file is inside lab05
        $handle = fopen($filename, "a"); // open the file in append mode
        $data = $item . ", " . $qty . "\n"; // concatenate item and qty delimited by comma
        fwrite($handle, $data); // write string to text file
        fclose($handle); // close the text file
        echo "<p>Shopping List</p> "; // generate shopping list
        $handle = fopen($filename, "r"); // open the file in read mode
        while (!feof($handle)) { // loop while not end of file
            $data = fgets($handle); // read a line from the text file
            echo "<p>", $data, "</p>"; // generate HTML output of the data
        }
        fclose($handle); // close the text file
    } else if (isset($_POST["item"]) && isset($_POST["qty"]) && !is_numeric($_POST["qty"])) { // qty is not numeric
        echo "<p>Please enter a numeric value for quantity.</p>";
    } else { // no input
        echo "<p>Please enter item and quantity in the input form.</p>";
    }
    ?>
</body>

</html>