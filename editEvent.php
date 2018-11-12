<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/editEvent.inc.php";
include_once "sql-testing/getJobs.php";

$error_msg = "";

$conn = "SELECT * FROM events WHERE eventid='" . $_GET['eventId'] . "' AND id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);

if ($result->num_rows == 0) {
     $error_msg .= "<p class='error'>You're not allowed to edit this event.</p>";
}

if ($result->num_rows > 1) {
     $error_msg .= "<p class='error'>An unknown error occured. Please contact a system admin.</p>";
}

$row = $result->fetch_assoc();

if (!empty($row['custom'])) {
     header("Location: editEventCustom.php?eventId=" . $_GET['eventId']);
}

?>

<!DOCTYPE html>
<head>
     <?php include "header.php"; ?>
     <title>Edit Event</title>
</head>

<body>
<div id="header">
     <h1>Edit Event</h1>
     <a href="index.php">Back</a>
</div>

<?php
if (!empty($error_msg)) {
     echo $error_msg;
}
?>

<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" id="addeventDiv">

     <div class="row">
          <input readonly type="text" style="display: none;" name="oldStuff" id="oldStuff" value="<?php echo $row['eventid'] ?>" />
          <h3>Clicked Date:</h3>
          <input readonly type="text" name="clickedDate" id="clickedDate" class="addEvent" value="<?php echo $row['date'] ?>" />
     </div>

     <div class="row">
          <div class="column1">
               <h3>Start</h3>
               <input type="time" name="timeStart" id="timeStart" class="addEvent"  value="<?php echo $row['timestart'] ?>"/>
          </div>
          <div class="column2">
               <h3>End</h3>
               <input type="time" name="timeEnd" id="timeEnd" class="addEvent"  value="<?php echo $row['timeend'] ?>"/>
          </div>
     </div>

     <div class="row">
          <div class="column">
               <h3>Unpaid Break Time (in minutes)</h3>
               <input type="number" id="breakTime" name="breakTime" class="addEvent" value="<?php echo $row['breaktime'] ?>" />
          </div>
     </div>

     <?php if ($result->num_rows == 1) : ?>
          <div class="row8">
               <select id="jobSelect" name="jobSelect"></select>
               <input type="submit" value="Edit Event" id="eventSet" onclick="return regCheck(this.form, this.form.clickedDate, this.form.timeStart, this.form.timeEnd, this.form.breakTime, this.form.jobSelect)" />
               <input type="button" value="Delete Event" id="deleteEvent" />
          </div>

     <?php endif; ?>

     <div class="row9" style="width: 100%;">
          <p style="margin: 1em 0;" class="orThis">Or <a class="orThis" href="#" onclick="addanotherEvent(); window.location.href = 'addEvent.php'">add another event for this day</a></p>
     </div>
</form>

<script>
     var oldStuff = document.getElementById("oldStuff").value;
     document.getElementById("deleteEvent").addEventListener("click", function() {
          var diag = confirm('Are you sure you want to delete this event?');
          if (diag == true) {
                window.location.href = "sql-testing/deleteEvent.php?eventId=" + oldStuff;
          } else {
               return false;
          }
     });
     var fillSelect = <?php echo json_encode($jsarray); ?>;

     for (i = 0; i < fillSelect.length; i++) {
          var createSelect = document.createElement("option");
          createSelect.innerHTML = fillSelect[i];
          document.getElementById("jobSelect").appendChild(createSelect);
     }

     document.getElementById("jobSelect").value = "<?php echo $row['job'] ?>";
</script>

</body>
</html>
