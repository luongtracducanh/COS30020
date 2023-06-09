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
  $currentDate = new DateTime(); // Get the current date

  // function for special feature - replace Vietnamese characters with English characters for search filtering
  function replaceVnese($str)
  {
    // lowercase
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    // uppercase (not needed since the job titles will be converted to lowercase before being passed to this function)
    // $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    // $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    // $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    // $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    // $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    // $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    // $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
  }

  // check if the job title is set and not empty
  if (isset($_GET['title']) && !empty($_GET['title'])) {
    $title = $_GET['title'];
    $position = isset($_GET["position"]) ? $_GET["position"] : "";
    $contract = isset($_GET["contract"]) ? $_GET["contract"] : "";
    $app = isset($_GET["app"]) ? $_GET["app"] : array();
    $location = isset($_GET["location"]) ? $_GET["location"] : "";

    $file = '../../data/jobposts/jobs.txt';
    if (!file_exists($file)) {
      echo "<p>No up-to-date job vacancy found.</p>";
      exit;
    } else {
      $handle = fopen($file, 'r');
      // check if the file is opened successfully
      if ($handle) {
        $jobVacancies = array(); // array to store the job vacancies
        while (($line = fgets($handle)) !== false) {
          $lineData = explode("\t", $line);
          $jobTitle = isset($lineData[1]) ? $lineData[1] : "";
          $des = isset($lineData[2]) ? stripslashes($lineData[2]) : "";
          $closingDate = isset($lineData[3]) ? date_create_from_format('d/m/y', $lineData[3]) : "";
          $jobPosition = isset($lineData[4]) ? $lineData[4] : "";
          $jobContract = isset($lineData[5]) ? $lineData[5] : "";
          $jobApplication = isset($lineData[6]) ? explode(", ", $lineData[6]) : array();
          $jobLocation = isset($lineData[7]) ? $lineData[7] : "";
          // check if the job vacancy matches the search criteria
          if (
            (strpos(replaceVnese(strtolower($jobTitle)), replaceVnese(strtolower(trim($title)))) !== false) &&
            // (strpos(strtolower(trim($jobTitle)), strtolower($title)) !== false) &&
            (empty($position) || strtolower(trim($jobPosition)) === strtolower($position)) &&
            (empty($contract) || strtolower(trim($jobContract)) === strtolower($contract)) &&
            (empty($app) || array_intersect(array_map('strtolower', $app), array_map('strtolower', $jobApplication))) &&
            (empty($location) || strtolower(trim($jobLocation)) === strtolower($location)) &&
            ($closingDate >= $currentDate) // check if the closing date is after or equal to the current date
          ) {
            // add the job vacancy to the array
            $jobVacancies[] = array(
              'title' => $jobTitle,
              'description' => $des,
              'closingDate' => $closingDate,
              'position' => "$jobContract - $jobPosition",
              'application' => $jobApplication,
              'location' => $jobLocation
            );
          }
        }
        if (empty($jobVacancies)) {
          echo '<p>No up-to-date job vacancy found.</p>';
        } else {
          // sort the job vacancies by closing date in descending order
          usort($jobVacancies, function ($a, $b) {
            if ($a['closingDate'] < $b['closingDate']) {
              return -1;
            } elseif ($a['closingDate'] > $b['closingDate']) {
              return 1;
            } else {
              return 0;
            }
          });

          // iterate over the sorted job vacancies and display the information for the ones that haven't closed
          foreach ($jobVacancies as $job) {
            $jobTitle = $job['title'];
            $description = $job['description'];
            $closingDate = $job['closingDate'];
            $position = $job['position'];
            $application = implode(", ", $job['application']);
            $location = $job['location'];

            // display the job vacancy information
            echo "<p>Job Title: $jobTitle</p>";
            echo "<p>Description: $description</p>";
            echo "<p>Closing Date: {$closingDate->format('d/m/y')}</p>";
            echo "<p>Position: $position</p>";
            echo "<p>Application by: $application</p>";
            echo "<p>Location: $location</p><hr>";
          }
        }
        fclose($handle); // close the file
      } else {
        echo "Unable to open $file.";
      }
    }
  } else {
    echo '<p>Please enter a job title.</p>';
  }
  ?>
  <p><a href="searchjobform.php">Search for another job vacancy</a></p>
  <p><a href="index.php">Return to Home Page</a></p>
</body>

</html>