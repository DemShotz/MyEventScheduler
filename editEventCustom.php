<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/editEventCustom.inc.php";

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

?>

<!DOCTYPE html>
<html>
<head>
     <?php include "header.php"; ?>
     <title>Edit Note</title>
</head>
<body>

<div id="header" class="addeventDiv">
     <h1>Edit Note</h1>
     <a href="index.php">Back</a>
</div>

<?php
if (!empty($error_msg)) {
     echo $error_msg;
}
?>

<form id="customEvent" action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post">

     <input readonly type="text" id="oldstuff" name="oldstuff" style="display: none;" value="<?php echo $row['eventid'] ?>" />

     <div class="row">
          <h3>Clicked Date:</h3>
          <input readonly type="text" name="clickedDate" id="clickedDate" class="addEvent" value="<?php echo $row['date'] ?>" />
     </div>

     <div class="row">
          <textarea id="customText" name="customText" type="paragraph" autocomplete="off"></textarea>
          <p class="limit">0/50</p>
     </div>

     <div class="row">
          <input type="submit" value="Edit Note" id="eventSet" />
          <input type="button" value="Delete Note" id="deleteEvent" />
     </div>

     <div class="row" style="width: 100%;">
          <p>Or <a href="#" onclick="addanotherEvent(); storeAcross(); window.location.href = 'addEventCustom.php'">Add another note for this day</a></p>
     </div>

</form>

<script src="scripts/script.js"></script>

<script>
     var oldStuff = document.getElementById("oldstuff").value;
     document.getElementById("customText").innerHTML = "<?php echo $row['custom'] ?>";
     document.getElementById("deleteEvent").addEventListener("click", function() {
          var diag = confirm('Are you sure you want to delete this note?');
          if (diag == true) {
                window.location.href = "sql-testing/deleteEvent.php?eventId=" + oldStuff;
          } else {
               return false;
          }
     });

     document.getElementById("customText").addEventListener("keydown", limitText);
     document.getElementById("customText").addEventListener("keyup", limitText);
     document.getElementsByClassName("limit")[0].innerHTML = document.getElementById("customText").value.length + "/" + "50";

     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
</script>

</body>
</html>
