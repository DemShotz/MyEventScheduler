<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/addEventCustom.inc.php";
?>


<!DOCTYPE html>
<html>
<head>
     <?php include "header.php"; ?>
     <title>Add Note</title>
</head>
<body>

<div id="header" class="addeventDiv">
     <h1>Add Note</h1>
     <a href="index.php">Back</a>
</div>

<?php
if (!empty($error_msg)) {
     echo $error_msg;
}
?>

<form id="customEvent" action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post">

     <div class="row">
          <h3>Clicked Date:</h3>
          <input readonly type="text" name="clickedDate" id="clickedDate" class="addEvent">
     </div>

     <div class="row">
          <textarea id="customText" name="customText" type="paragraph" autocomplete="off"></textarea>
          <p class="limit">0/50</p>
     </div>

     <div class="row">
          <input type="submit" value="Add Note" />
     </div>

</form>

<script src="scripts/script.js"></script>

<script>
     document.getElementById("customText").addEventListener("keydown", limitText);
     document.getElementById("customText").addEventListener("keyup", limitText);

     var monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     var setYear = sessionStorage.getItem("year", year);
     var theMonth = sessionStorage.getItem("month", setMonth);
     var theDate = sessionStorage.getItem("day", clickedDate);
     var textArea = document.getElementById("clickedDate");

     textArea.value = monthHeader[theMonth] + " " + theDate + " " + setYear;
</script>

</body>
</html>
