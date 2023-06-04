<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JVPS</title>
</head>

<body>
  <h1>Job Vacancy Posting System</h1>
  <?php
  $file = '../../data/jobposts/jobs.txt'; // sudo chown ducanh:www-data jobs.txt

  // Validate a field based on a regular expression pattern
  function validateField($fieldName, $fieldValue, $pattern, $errorMessage)
  {
    if (empty($fieldValue)) {
      echo "<p>Please enter a $fieldName.</p>";
    } else if (!preg_match($pattern, $fieldValue)) {
      echo "<p>$errorMessage</p>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  // Check if the Position ID is unique
  function isPosIdUnique($posId, $file)
  {
    $handle = fopen($file, 'r');
    if ($handle) {
      while (($line = fgets($handle)) !== false) {
        $lineData = explode("\t", $line);
        if (isset($lineData[0]) && trim($lineData[0]) === $posId) {
          fclose($handle);
          return false; // Position ID already exists
        }
      }
      fclose($handle);
    }
    return true; // Position ID is unique
  }

  // Validate the application method field
  function validateApplicationMethod($fieldName, $fieldValue)
  {
    if (empty($fieldValue)) {
      echo "<p>Please select $fieldName(s) to send accepted application.</p>";
    } else {
      return implode(", ", $fieldValue);
    }
    return null;
  }

  // Validate the location field
  function validateLocation($fieldName, $fieldValue)
  {
    if (empty($fieldValue)) {
      echo "<p>Please enter a $fieldName.</p>";
    } else {
      return $fieldValue;
    }
    return null;
  }

  // Process the form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posId = validateField('position ID', $_POST['posId'], '/^P\d{4}$/', 'Please enter a unique 5-character code that starts with "P" and is followed by 4 digits, e.g., P0001.');
    // $title = validateField('title', $_POST['title'], '/^[a-zA-Z0-9 ,.!]{1,20}$/', 'Please enter a maximum of 20 characters without any special characters (comma, period, and exclamation point are allowed).');
    // support Vietnamese characters
    $title = validateField('title', $_POST['title'], '/^[a-zA-Z0-9 ,.!àáãạảăắằẳẵặâấầẩẫậèéẹẻẽêềếểễệđìíĩỉịòóõọỏôốồổỗộơớờởỡợùúũụủưứừửữựỳỵỷỹýÀÁÃẠẢĂẮẰẲẴẶÂẤẦẨẪẬÈÉẸẺẼÊỀẾỂỄỆĐÌÍĨỈỊÒÓÕỌỎÔỐỒỔỖỘƠỚỜỞỠỢÙÚŨỤỦƯỨỪỬỮỰỲỴỶỸÝ]{1,20}$/', 'Please enter a maximum of 20 characters without any special characters (comma, period, and exclamation point are allowed).');
    $des = validateField('description', $_POST['des'], '/^.{1,260}$/', 'Please enter a maximum of 260 characters.');
    $date = validateField('closing date', $_POST['date'], '/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{2}$/', 'Please enter a date in "dd/mm/yy" format.');
    $position = isset($_POST['position']) ? $_POST['position'] : array();
    $contract = isset($_POST['contract']) ? $_POST['contract'] : array();
    $app = validateApplicationMethod('method', isset($_POST['app']) ? $_POST['app'] : array());
    $location = validateLocation('location', isset($_POST['location']) ? $_POST['location'] : '');

    if ($posId && $title && $des && $date && $position && $contract && $app && $location) {
      if (!isPosIdUnique($posId, $file)) {
        echo '<p>The position ID already exists. Please enter a unique ID.</p>';
      } else {
        $record = "$posId\t$title\t$des\t$date\t$position\t$contract\t$app\t$location\n";
        $handle = fopen($file, 'a');
        if ($handle) {
          fwrite($handle, $record);
          fclose($handle);
          echo "The job vacancy has been posted successfully.";
        } else {
          echo "Unable to open the file.";
        }
      }
    }
  }
  ?>
  <p><a href="postjobform.php">Back to Job Posting Page</a></p>
  <p><a href="index.php">Back to Home</a></p>
</body>

</html>