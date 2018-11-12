<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$error_stuff = "";

if(isset($_POST['jobName'])) {
     $oldname = $_POST['oldName'];
     $jobname = $_POST['jobName'];
     $hourlytime = $_POST['hourlyTime'];
     $statmultiple = $_POST['statMultiple'];
     $overtimemultiple = $_POST['overtimeMultiple'];
     $othour = $_POST['otHour'];
     $jscolor = $_POST['jscolor'];

     $conn = "UPDATE jobs SET id='" . $_SESSION['user_id'] . "', jobname='" . $jobname . "', hourlytime='" . $hourlytime . "', statmultiple='" . $statmultiple . "', overtimemultiple='" . $overtimemultiple . "', othour='" . $othour . "', colour='#" . $jscolor . "' WHERE jobname='" . $oldname . "' AND id='" . $_SESSION['user_id'] . "'";
     $result = $mysqli->query($conn);
     if ($result == false) {
          $error_stuff .= $mysqli->error;
     }

     $conn = "SELECT * FROM events WHERE job='" . $oldname . "'";
     $result = $mysqli->query($conn);
     if ($result->num_rows < 1) {
          $error_msg = "<p class='error'>Some error occured. Please contact the system admin</p>";
     }

     while ($row = $result->fetch_assoc()) {
          $start = preg_split("/:/", $row['timestart']);
          $start[0] = (float)$start[0];
          $start[1] = (float)$start[1];
          $start[1] = $start[1] / 60;
          $start = $start[0] + $start[1];

          $end = preg_split("/:/", $row['timeend']);
          $end[0] = (float)$end[0];
          $end[1] = (float)$end[1];
          $end[1] = $end[1] / 60;
          $end = $end[0] + $end[1];

          if ($start > $end) {
               $start = abs(24 - $start);
               $counter = $start + $end;
          } else {
               $counter = abs($start - $end);
               $counter = $counter;
          }

          $break = $row['breaktime'] / 60;
          $counter = $counter - $break;

          if ($counter > $othour) {
               $secondpart = $counter - $othour;
               $money = $othour * $hourlytime;
               $money = $money + ($secondpart * $overtimemultiple * $hourlytime);
          } else {
               $money = $counter * $hourlytime;
          }

          $tryme = "UPDATE events SET id='" . $_SESSION['user_id'] . "', date='" . $row['date'] . "', timestart='" . $row['timestart'] . "', timeend='" . $row['timeend'] . "', breaktime='" . $row['breaktime'] . "', job='" . $jobname . "', eventpay='" . $money . "' WHERE id='" . $_SESSION['user_id'] . "' AND eventid='" . $row['eventid'] . "'";
          $fixresult = $mysqli->query($tryme);
          if ($fixresult == false) {
               $error_msg .= "Fucked up";
          }
     }
     header("Location: ../manageJobs.php");
}
?>
