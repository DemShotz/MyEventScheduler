<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$error_msg = "";

if(isset($_POST['clickedDate'])) {
     $oldstuff = $_POST['oldStuff'];
     $date = $_POST["clickedDate"];
     $starttime = $_POST["timeStart"];
     $endtime = $_POST["timeEnd"];
     $breaktime = $_POST["breakTime"];
     $job = $_POST["jobSelect"];

     $conn = "SELECT * FROM jobs WHERE id='" . $_SESSION['user_id'] . "' AND jobname='" . $job . "'";
     $result = $mysqli->query($conn);
     if ($result->num_rows > 1) {
          $error_msg = "<p class='error'>Some error occured. Please contact the system admin</p>";
     }
     $result = $result->fetch_assoc();

     $start = preg_split("/:/", $starttime);
     $start[0] = (float)$start[0];
     $start[1] = (float)$start[1];
     $start[1] = $start[1] / 60;
     $start = $start[0] + $start[1];

     $end = preg_split("/:/", $endtime);
     $end[0] = (float)$end[0];
     $end[1] = (float)$end[1];
     $end[1] = $end[1] / 60;
     $end = $end[0] + $end[1];

     if ($start > $end) {
          $start = abs(24 - $start);
          $counter = $start + $end;
     } else {
          $break = $breaktime / 60;
          $counter = abs($start - $end);
          $counter = $counter - $break;
     }

     if ($counter > $result['othour']) {
          $secondpart = $counter - $result['othour'];
          $money = $result['othour'] * $result['hourlytime'];
          $money = $money + ($secondpart * $result['overtimemultiple'] * $result['hourlytime']);
     } else {
          $money = $counter * $result['hourlytime'];
     }

     $conn = "UPDATE events SET id='" . $_SESSION['user_id'] . "', date='" . $date . "', timestart='" . $starttime . "', timeend='" . $endtime . "', breaktime='" . $breaktime . "', job='" . $job . "', eventpay='" . $money . "' WHERE id='" . $_SESSION['user_id'] . "' AND eventid='" . $oldstuff . "'";
     $result = $mysqli->query($conn);

     if ($result == false) {
          $error_msg .= $mysqli->error;
     }

     $monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     $monthSplit = preg_split("/ /", $date);
     $pos = array_search($monthSplit[0], $monthHeader);
     $_SESSION["setMonth"] = $pos;

     header("Location: ../index.php");
}
?>
