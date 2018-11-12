<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once 'sql-testing/editJob.inc.php';

$jobname = $_GET['name'];

$conn = "SELECT * FROM jobs WHERE jobname='" . $jobname . "' AND id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);

if($result->num_rows == 0) {
     echo "You do not have permission to modify this job.";
     exit;
}

while ($row = $result->fetch_assoc()) {
     $jobname = $row['jobname'];
     $hourlytime = $row['hourlytime'];
     $statmultiple = $row['statmultiple'];
     $overtimemultiple = $row['overtimemultiple'];
     $othour = $row['othour'];
     $jscolor = $row['colour'];
}
?>

<!DOCTYPE HTML>
<html>
<head>
     <title>Edit Job</title>
     <?php include "header.php"; ?>
</head>

<body>

<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" name="addJobScript" id="addjobScript">
          <div id="header">
               <h1>Edit Job</h1>
               <a href="manageJobs.php">Back</a>
          </div>

          <?php
               if(!empty($error_stuff)) {
                    echo $error_stuff;
               }
          ?>

          <input style="display: none;" name="oldName" id="oldName" type="text" value="<?php echo $jobname; ?>" />

          <div class="row">
               <p>Job Name:</p>
               <input name="jobName" id="jobName" type="text" value="<?php echo $jobname; ?>" />
          </div>

          <div class="row">
               <div class="column1d">
                    <p class="jobDetails">Hourly Wage</p>
                    <input name="hourlyTime" id="hourlyTime" type="number" value="<?php echo $hourlytime; ?>" step="any"/>
               </div>
               <div class="column2d">
                    <p class="jobDetails">Holiday Wage Multiplier</p>
                    <input name="statMultiple" id="statMultiple" type="number" value="<?php echo $statmultiple; ?>" step="any"/>
               </div>
          </div>

          <div class="row">
               <div class="column1d">
                    <p class="jobDetails">Overtime Wage Multiplier</p>
                    <input name="overtimeMultiple" id="overtimeMultiple" type="number" value="<?php echo $overtimemultiple; ?>" step="any"/>
               </div>
               <div class="column2d">
                    <p class="jobDetails">Hours worked for OT</p>
                    <input name="otHour" id="otHour" type="number" value="<?php echo $othour; ?>" step="any"/>
               </div>
               <p>Colour to be displayed beside this job's events:</p><input class="jscolor" style="text-align: center;" value="<?php echo $jscolor ?>" name="jscolor"><br>
               <input type="submit" name="submitthis" value="Edit Job" class="editJob">
          </div>
</form>


<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/JavaScript" src="scripts/jscolor.js"></script>
<script type="text/JavaScript" src="scripts/jscolor.min.js"></script>

</body>
</html>
