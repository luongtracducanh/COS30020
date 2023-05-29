<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JVPS - Search Results</title>
</head>

<body>
  <h1>Job Vacancy Posting System - Search Results</h1>
  <?php
  // check if the job title is set and not empty
  if (isset($_GET['title']) && !empty($_GET['title'])) {
    $title = $_GET['title'];
    $position = isset($_GET["position"]) ? $_GET["position"] : "";
    $contract = isset($_GET["contract"]) ? $_GET["contract"] : "";
    $app = isset($_GET["app"]) ? $_GET["app"] : [];
    $location = isset($_GET["location"]) ? $_GET["location"] : "";

    $file = 'jobposts/jobs.txt';
    $handle = fopen($file, 'r');
    // check if the file is opened successfully
    if ($handle) {
      $jobVacancies = []; // array to store the job vacancies
      while (($line = fgets($handle)) !== false) {
        $lineData = explode("\t", $line);
        $jobTitle = isset($lineData[1]) ? $lineData[1] : "";
        $jobPosition = isset($lineData[4]) ? $lineData[4] : "";
        $jobContract = isset($lineData[5]) ? $lineData[5] : "";
        $jobApplication = isset($lineData[6]) ? explode(", ", $lineData[6]) : [];
        $jobLocation = isset($lineData[7]) ? $lineData[7] : "";
        // check if the job vacancy matches the search criteria
        if (
          (strpos(strtolower(trim($jobTitle)), strtolower($title)) !== false) &&
          (empty($position) || strtolower(trim($jobPosition)) === strtolower($position)) &&
          (empty($contract) || strtolower(trim($jobContract)) === strtolower($contract)) &&
          (empty($app) || array_intersect(array_map('strtolower', $app), array_map('strtolower', $jobApplication))) &&
          (empty($location) || strtolower(trim($jobLocation)) === strtolower($location))
        ) {
          $closingDate = DateTime::createFromFormat('d/m/y', $lineData[3]);
          // add the job vacancy to the array with closing date as the key
          // format will be yymmdd for sorting purpose
          $jobVacancies[$closingDate->format('ymd')] = [
            'title' => $jobTitle,
            'description' => $lineData[2],
            'closingDate' => $closingDate,
            'position' => "$jobContract - $jobPosition",
            'application' => $jobApplication,
            'location' => $jobLocation
          ];
        }
      }
      if (empty($jobVacancies)) {
        echo '<p>No job vacancy found.</p>';
      } else {
        // sort the job vacancies by closing date in descending order
        krsort($jobVacancies);

        // iterate over the sorted job vacancies and display the information
        foreach ($jobVacancies as $job) {
          $jobTitle = $job['title'];
          $description = $job['description'];
          $closingDate = $job['closingDate']->format('d/m/y');
          $position = $job['position'];
          $application = implode(", ", $job['application']);
          $location = $job['location'];

          // display the job vacancy information
          echo "<p>Job Title: $jobTitle</p>";
          echo "<p>Description: \"$description\"</p>";
          echo "<p>Closing Date: $closingDate</p>";
          echo "<p>Position: $position</p>";
          echo "<p>Application by: $application</p>";
          echo "<p>Location: $location</p><hr>";
        }
      }
      fclose($handle); // close the file
    }
  } else {
    echo '<p>Please enter a job title.</p>';
  }
  ?>
  <p><a href="searchjobform.php">Search for another job vacancy</a></p>
  <p><a href="index.php">Return to Home Page</a></p>
</body>

</html>