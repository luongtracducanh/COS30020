<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JVPS</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
  <h1 class="header">Job Vacancy Posting System</h1>
  <nav>
    <ul class="navigator">
      <li class="navlist"> <a href="index.php">Home</a></li>
      <li class="navlist"> <a href="postjobform.php">Post job</a></li>
      <li class="navlist current"> <a href="searchjobform.php"> Search job</a></li>
      <li class="navlist"> <a href="about.php">About assignment</a></li>
    </ul>
  </nav>
  <div class="container">
    <div>
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
          echo "<p class='process'>No up-to-date job vacancy found.</p>";
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
              echo "<p class='process'>No up-to-date job vacancy found.</p>";
            } else {
              // sort the job vacancies by closing date in descending order
              usort($jobVacancies, function ($b, $a) {
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
                // $descriptionList = explode("[NEWLINE]", $description);
                $descriptionList = str_replace("[NEWLINE]", "<br>", $description);
                $closingDate = $job['closingDate'];
                $position = $job['position'];
                $application = implode(", ", $job['application']);
                $location = $job['location'];

                // display the job vacancy information
                echo '<div class="jobvacancy">';
                echo "<p class='jobtitle'> Job Title: $jobTitle</p>";
                echo "<span class='list'>Description:</span>";
                echo "<p>$descriptionList</p>";
                // echo "<ul>";
                // foreach ($descriptionList as $item) {
                //   echo "<li>" . htmlspecialchars($item) . "</li>";
                // }
                // echo "</ul>";
                echo "<p><span class='list'>Closing Date:</span> {$closingDate->format('d/m/y')}</p>";
                echo "<p><span class='list'>Position:</span> $position</p>";
                echo "<p><span class='list'>Application by:</span> $application</p>";
                echo "<p><span class='list'>Location:</span> $location</p>";
                echo '</div>';
              }
            }
            fclose($handle); // close the file
          } else {
            echo "Unable to open $file.";
          }
        }
      } else {
        echo '<p class="process">Please enter a job title.</p>';
      }
      ?>
    </div>

    <div class="lastnote">
      <p class="return"><a href="searchjobform.php"><span>Search for another job vacancy</span></a></p>
      <p class="return"><a href="index.php"><span>Return to Home Page</span></a></p>
    </div>
    <div class="push"></div>
  </div>
  <footer class="footer">
    <p>Copyright @2023</p>
  </footer>
</body>

</html>