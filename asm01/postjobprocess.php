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
if (isset($_POST['title'])) {
	if (empty($_POST['title'])) {
		echo 'Please enter a title.';
	} else if (!preg_match('/^[a-zA-Z0-9 ,.!]{1,20}$/', $_POST['title'])) {
		echo 'Please enter a maximum of 20 characters without any special characacter (comma, period, and exclamation point are allowed).';
	} else {
		$title = $_POST['title'];
	}
}
if (isset($_POST['des'])) {
	if (empty($_POST['des'])) {
		echo 'Please enter a description.';
	} else if (strlen($_POST['des']) > 260) {
		echo 'Please enter a maximum of 260 characters.';
	} else {
		$des = $_POST['des'];
	}
}
if (isset($_POST['date'])) {
	if (empty($_POST['date'])) {
		echo 'Please enter a closing date.';
	} else if (!preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{2}$/', $_POST['date'])) {
		echo 'Please enter a date in "dd/mm/yy" format.';
	} else {
		$date = $_POST['date'];
	}
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['position'])) {
		echo '<br>Please select a position.';
	} else {
		$position = $_POST['position'];
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['contract'])) {
		echo '<br>Please select a contract.';
	} else {
		$contract = $_POST['contract'];
	}
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (!isset($_POST['app'])) {
		echo '<br>Please select a method(s) to send accepted application.';
	} else {
		$app = $_POST['app'];
	}
}

if (isset($_POST['location'])) {
	if (empty($_POST['location'])) {
		echo 'Please enter a location.';
	} else {
		$location = $_POST['location'];
	}
}
