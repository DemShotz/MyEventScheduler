<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/addEvent.inc.php";
include_once "sql-testing/getJobs.php";
?>

<script>
     var fillSelect = <?php echo json_encode($jsarray); ?>;
     if (fillSelect.length == 0) {
          alert("You have no jobs made. Please make a job before you add events.");
          window.location.href = "index.php";
     }
</script>

<!DOCTYPE html>
<head>
     <?php include "header.php"; ?>
     <title>Add Event</title>
</head>

<body>
<div id="header" class="addeventDiv">
     <h1>Add Event</h1>
     <a href="index.php">Back</a>
</div>

<?php
if (!empty($error_msg)) {
     echo $error_msg;
}
?>

<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" id="addeventDiv">
     <div class="row">
          <h3>Clicked Date:</h3>
          <input readonly type="text" name="clickedDate" id="clickedDate" class="addEvent">
     </div>

     <div class="row">
          <div class="column1">
               <h3>Start</h3>
               <input type="time" name="timeStart" id="timeStart" class="addEvent" />
          </div>
          <div class="column2">
               <h3>End</h3>
               <input type="time" name="timeEnd" id="timeEnd" class="addEvent" />
          </div>
     </div>

     <div class="row2">
          <div class="column">
               <h3>Unpaid Break Time (in minutes)</h3>
               <input type="number" id="breakTime" name="breakTime" class="addEvent" value="0" />
          </div>
     </div>

     <div class="row" style="margin: 1em 0; height: auto;">
          <select id="jobSelect" name="jobSelect"></select>
          <input type="submit" value="Add Event" id="eventSet" onclick="return regCheck(this.form, this.form.clickedDate, this.form.timeStart, this.form.timeEnd, this.form.breakTime, this.form.jobSelect)" />
     </div>

     <div class="row9" style="margin: 0.75em 0;">
          <h3>Or you can <a class="orThis" href="addEventCustom.php">add a custom note</a></h3>
     </div>

</form>

<script>
     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var day = sessionStorage.getItem("day");
     var month = sessionStorage.getItem("month");
     var year = sessionStorage.getItem("year");
     var textArea = document.getElementById("clickedDate");

     textArea.value = monthHeader[month] + " " + day + " " + year;

     for (i = 0; i < fillSelect.length; i++) {
          var createSelect = document.createElement("option");
          createSelect.innerHTML = fillSelect[i];
          document.getElementById("jobSelect").appendChild(createSelect);
     }
</script>

</body>
</html>
