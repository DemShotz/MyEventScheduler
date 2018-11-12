<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";

sec_session_start();
?>

<!DOCTYPE html>
<html>
<head>
     <title>Manage Jobs</title>
     <?php include "header.php"; ?>
</head>

<body>
     <div id="header">
          <h1>Manage Jobs</h1>
          <a href="index.php" onclick="hideJobList()">Back</a>
     </div>

     <div id="jobContainer">
     </div>

     <?php if (!isset($_SESSION['user_id'])) : ?>
          <script>
               alert('Please sign in or create an account first!');
               window.location.href = "index.php";
          </script>
     <?php endif; ?>

     <div class="row4">
          <a href="addJob.php" id="addJob">Add Job</a>
     </div>

     <script type="text/javascript" src="scripts/script.js"></script>

</body>
</html>

<?php

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

$conn = "SELECT * FROM jobs WHERE id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);

if ($result->num_rows == 0) {
     echo "<h2>You have no jobs made yet. Please make a job!</h2>";
}

$jsarray = array();

while ($row = $result->fetch_assoc()) {
     $innerarray = array();
     $innerarray[] = $row['jobname'];
     $innerarray[] = $row['hourlytime'];
     $innerarray[] = $row['statmultiple'];
     $innerarray[] = $row['overtimemultiple'];
     $innerarray[] = $row['othour'];
     $jsarray[] = $innerarray;
}

for ($i = 0; $i < count($jsarray); $i++) {
     $thisarray = json_encode($jsarray[$i]);
?>
     <script type="text/javascript">
          var setMe = 0;
          var jobArray = <?php echo $thisarray ?>;
          var insertHere = document.getElementById("jobContainer");

          var createOuter = document.createElement("div");
          createOuter.setAttribute("class", "job-list");

          var createH1 = document.createElement("h2");
          var createH1inner = document.createTextNode(jobArray[0]);
          createH1.appendChild(createH1inner);

          createOuter.appendChild(createH1);

          for (i = 1; i < 5; i++) {
               var setmeArray = ["Hourly Wage: $", "Statutory Holiday Multiplier: x", "Overtime Wage Multiplier: x", "Hours Overtime Starts After: "]
               var createH3 = document.createElement("h3");
               var createH3inner = document.createTextNode(setmeArray[setMe] + jobArray[i]);
               createH3.appendChild(createH3inner);
               createOuter.appendChild(createH3);
               setMe = setMe + 1;
          }
          var createContainer = document.createElement("p");
          createContainer.setAttribute("class", "delete-container");

          var createEdit = document.createElement("a");
          createEdit.setAttribute("class", "edit-button");
          createEdit.setAttribute("onclick", "editJob(event)");
          createEdit.innerHTML = "Edit Job";

          var createDelete = document.createElement("a");
          createDelete.setAttribute("class", "delete-button");
          createDelete.setAttribute("onclick", "deleteJob(event)");
          createDelete.innerHTML = "Delete Job";

          createContainer.appendChild(createEdit);
          createContainer.appendChild(createDelete);
          createOuter.appendChild(createContainer);
          insertHere.appendChild(createOuter);

     </script>
<?php } ?>
