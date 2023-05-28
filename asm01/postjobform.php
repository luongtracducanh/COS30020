<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JVPS</title>
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
</head>

<body>
	<h1>Job Vacancy Posting System</h1>
	<form method="POST" action="postjobprocess.php">
		<p>Position ID: <input type="text" id="posId" name="posId">
			<?php
			if (isset($_POST['posId'])) {
				if (empty($_POST['posId'])) {
					echo 'Please enter a position ID.';
				} else if (!preg_match('/^P\d{4}$/', $_POST['posId'])) {
					echo 'Please enter a unique 5-character code that starts with "P" and follows by 4 digits e.g. P0001.';
				} else {
					$posId = $_POST['posId'];
				}
			}
			?></p>
		<p>Title: <input type="text" id="title" name="title">
			<?php
			if (isset($_POST['title'])) {
				if (empty($_POST['title'])) {
					echo 'Please enter a title.';
				} else if (!preg_match('/^[a-zA-Z0-9 ,.!]{1,20}$/', $_POST['title'])) {
					echo 'Please enter a maximum of 20 characters without any special characacter (comma, period, and exclamation point are allowed).';
				} else {
					$title = $_POST['title'];
				}
			}
			?></p>
		<p>Description: <textarea id="des" name="des"></textarea>
			<?php
			if (isset($_POST['des'])) {
				if (empty($_POST['des'])) {
					echo 'Please enter a description.';
				} else if (strlen($_POST['des']) > 260) {
					echo 'Please enter a maximum of 260 characters.';
				} else {
					$des = $_POST['des'];
				}
			}
			?></p>
		<p>Closing Date: <input type="text" id="date" name="date" value="<?php echo date('d/m/y'); ?>">
			<?php
			if (isset($_POST['date'])) {
				if (empty($_POST['date'])) {
					echo 'Please enter a closing date.';
				} else if (!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{2}$/', $_POST['date'])) {
					echo 'Please enter a date in "dd/mm/yy" format.';
				} else {
					$date = $_POST['date'];
				}
			}
			?></p>
		<p>
			Position:
			<input type="radio" id="fullTime" name="position" value="Full Time">
			<label for="fullTime">Full Time</label>
			<input type="radio" id="partTime" name="position" value="Part Time">
			<label for="partTime">Part Time</label>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!isset($_POST['position'])) {
					echo '<br>Please select a position.';
				} else {
					$position = $_POST['position'];
				}
			}
			?>
		</p>
		<p>Contract:
			<input type="radio" id="onGoing" name="contract" value="On-going">
			<label for="post">On-going</label>
			<input type="radio" id="fixedTerm" name="contract" value="Fixed term">
			<label for="email">Fixed term</label>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!isset($_POST['contract'])) {
					echo '<br>Please select a contract.';
				} else {
					$contract = $_POST['contract'];
				}
			}
			?>
		</p>
		<p>Accepted application By:
			<input type="checkbox" id="post" name="app" value="Post">
			<label for="">Post</label>
			<input type="checkbox" id="mail" name="app" value="Mail">
			<label for="">Mail</label>
			<?php
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!isset($_POST['app'])) {
					echo '<br>Please select a method(s) to send accepted application.';
				} else {
					$app = $_POST['app'];
				}
			}
			?>
		</p>
		<p>Location:
			<select name="location">
				<option value="">---</option>
				<option value="ACT">ACT</option>
				<option value="NSW">NSW</option>
				<option value="NT">NT</option>
				<option value="QLD">QLD</option>
				<option value="SA">SA</option>
				<option value="TAS">TAS</option>
				<option value="VIC">VIC</option>
				<option value="WA">WA</option>
			</select>
			<?php
			if (isset($_POST['location'])) {
				if (empty($_POST['location'])) {
					echo 'Please enter a location.';
				} else {
					$location = $_POST['location'];
				}
			}
			?>
		</p>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
		<p>All fields are required. <a href="index.php">Return to Home Page</a></p>
	</form>
</body>

</html>