<?php
include_once "sql-testing/addJob.inc.php";
include_once "sql-testing/functions.php";
?>

<!DOCTYPE HTML>
<html>
<head>
     <title>Add Job</title>
     <?php include "header.php"; ?>
</head>

<body>
          <div id="header">
               <h1>Add Job</h1>
               <a href="manageJobs.php">Back</a>
          </div>
 <div class="login-container">
<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" name="addJobScript" id="addjobScript">

          <?php
               if(!empty($error_stuff)) {
                    echo $error_stuff;
               }
          ?>
          <div id="jobForm">
               <p>Job Name:</p>
               <input name="jobName" id="jobName" type="text" />

          <div class="row">
               <div class="column1d">
                    <p class="jobDetails">Hourly Wage</p>
                    <input name="hourlyTime" id="hourlyTime" type="number" step="any"/>
               </div>
               <div class="column2d">
                    <p class="jobDetails">Holiday Wage Multiplier</p>
                    <input name="statMultiple" id="statMultiple" type="number" step="any"/>
               </div>
          </div>

          <div class="row2">
               <div class="column1d">
                    <p class="jobDetails">Overtime Wage Multiplier</p>
                    <input name="overtimeMultiple" id="overtimeMultiple" type="number" step="any"/>
               </div>
               <div class="column2d">
                    <p class="jobDetails">Hours worked for OT</p>
                    <input name="otHour" id="otHour" type="number" step="any"/>
               </div>
               <p>Colour to be displayed beside this job's events:</p><input class="jscolor" style="text-align: center;" value="#FF2000" name="jscolor"><br>
               <input id="addJob" type="submit" name="submitthis" value="Add Job" />
          </div>

</form>
</div>
<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/JavaScript" src="scripts/jscolor.js"></script>
<script type="text/JavaScript" src="scripts/jscolor.min.js"></script>
</body>
</html>
