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
	<!-- validation section -->
	<?php
	// declare variables
	$posId = $title = $des = $date = $position = $contract = $app = $location = "";
	$file = 'jobs.txt';

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

	// validate position id field
	if (isset($_POST['posId'])) {
		// check if the field is empty
		if (empty($_POST['posId'])) {
			echo '<p>Please enter a position ID.</p>';
		}
		// check for uniqueness
		else if (!isPosIdUnique($_POST['posId'], $file)) {
			echo '<p>The position ID already exists. Please enter a unique ID.</p>';
		}
		// check if the input matches the pattern
		else if (!preg_match('/^P\d{4}$/', $_POST['posId'])) {
			echo '<p>Please enter a unique 5-character code that starts with "P" and follows by 4 digits e.g. P0001.</p>';
		}
		// if validated, assign the value to a variable
		else {
			$posId = $_POST['posId'];
		}
	}

	// validate the title field
	if (isset($_POST['title'])) {
		// check if the field is empty
		if (empty($_POST['title'])) {
			echo '<p>Please enter a title.</p>';
		}
		// check if the input matches the pattern
		else if (!preg_match('/^[a-zA-Z0-9 ,.!]{1,20}$/', $_POST['title'])) {
			echo '<p>Please enter a maximum of 20 characters without any special characacter (comma, period, and exclamation point are allowed).</p>';
		}
		// if validated, assign the value to a variable
		else {
			$title = $_POST['title'];
		}
	}

	// validate the description field
	if (isset($_POST['des'])) {
		// check if the field is empty
		if (empty($_POST['des'])) {
			echo '<p>Please enter a description.</p>';
		}
		// check if the input exceeds 260 characters
		else if (strlen($_POST['des']) > 260) {
			echo '<p>Please enter a maximum of 260 characters.</p>';
		}
		// if validated, assign the value to a variable
		else {
			$des = $_POST['des'];
		}
	}

	// validate the closing date field
	if (isset($_POST['date'])) {
		// check if the field is empty
		if (empty($_POST['date'])) {
			echo '<p>Please enter a closing date.</p>';
		}
		// check if the input matches dd/mm/yy
		else if (!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{2}$/', $_POST['date'])) {
			echo '<p>Please enter a date in "dd/mm/yy" format.</p>';
		}
		// if validated, assign the value to a variable
		else {
			$date = $_POST['date'];
		}
	}

	// check if a position a selected
	if (!isset($_POST['position'])) {
		echo '<p>Please select a position.</p>';
	}
	// if validated, assign the value to a variable
	else {
		$position = $_POST['position'];
	}

	// check if a contract type is selected
	if (!isset($_POST['contract'])) {
		echo '<p>Please select a contract.</p>';
	}
	// if validated, assign the value to a variable
	else {
		$contract = $_POST['contract'];
	}

	// check if an application method is selected
	if (!isset($_POST['app'])) {
		echo '<p>Please select a method(s) to send accepted application.</p>';
	}
	// if validated, assign the value to a variable
	else {
		$app = implode(", ", $_POST['app']);
		// $app = $_POST['app'];
	}

	// validate the location option menu
	if (isset($_POST['location'])) {
		// check if a location is selected
		if (empty($_POST['location'])) {
			echo '<p>Please enter a location.</p>';
		}
		// if validated, assign the value to a variable
		else {
			$location = $_POST['location'];
		}
	}
	?>

	<!-- write to text file -->
	<?php
	if (!empty($posId) && !empty($title) && !empty($des) && !empty($date) && !empty($position) && !empty($contract) && !empty($app) && !empty($location)) {
		// All variables are not empty strings
		$record = "$posId\t$title\t$des\t$date\t$position\t$contract\t$app\t$location\n";
		// Open the file in append mode
		$handle = fopen($file, 'a');

		if ($handle) {
			// Append the new line to the file
			fwrite($handle, $record);

			// Close the file handle
			fclose($handle);

			echo "The job vacancy has been posted successfully.";
		} else {
			echo "Unable to open the file.";
		}
	}
	?>
	<p><a href="postjobform.php">Back to Job Posting Page</a></p>
	<p><a href="index.php">Back to Home</a></p>
</body>

</html>