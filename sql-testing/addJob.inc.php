<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$error_stuff = "";

if(isset($_POST['jobName'])) {
     $jobname = $_POST['jobName'];
     $hourlytime = $_POST['hourlyTime'];
     $statmultiple = $_POST['statMultiple'];
     $overtimemultiple = $_POST['overtimeMultiple'];
     $othour = $_POST['otHour'];
     $jscolor = $_POST['jscolor'];

     $conn = "SELECT jobname FROM jobs WHERE jobname = '" . $jobname . "' AND id='" . $_SESSION['user_id'] . "'";
     $result = $mysqli->query($conn);
     if ($result->num_rows > 0) {
          $error_stuff .= '<p class="error">ERROR: You already have a job with this name. Please create a unique name.</p>';
     } else {
          $conn = "INSERT INTO jobs (id, jobname, hourlytime, statmultiple, overtimemultiple, othour, colour) VALUES ('" . $_SESSION['user_id'] . "', '"  . $jobname . "', '"  . $hourlytime . "', '" . $statmultiple . "', '" . $overtimemultiple . "', '"  . $othour . "', '#" . $jscolor . "')";
          $result = $mysqli->query($conn);
          header("Location: manageJobs.php");
     }
}
?>
