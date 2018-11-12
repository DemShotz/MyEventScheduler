<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/fixPref.inc.php";

$conn = "SELECT clock FROM members WHERE id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);
if ($result == false) {
     $error_msg .= "<p class='error'>An error occured, please contact the system admin.</p>";
}

$pref = $result->fetch_assoc();
$pref = $pref['clock'];

?>

<!DOCTYPE html>
<html>
<head>
     <?php include "header.php" ?>
     <title> Fix Your Preference</title>
</head>
<body>
     <div id="header">
          <h1>Fix Your Preference</h1>
          <a href="index.php">Back</a>
     </div>

     <?php
          if (!empty($error_msg)) {
               echo $error_msg;
          }
     ?>

     <form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" class="fixPref">
          <div class="row3" style="text-align: center; margin-top: 40px;">
               <label for="12">12 hour clock:</label><input type="radio" name="clockRadio" class="option-input radio" value="12" id="12" /> <br>
               <label for="24">24 hour clock:</label><input type="radio" name="clockRadio" class="option-input radio" value="24" id="24" /> <br>
               <input type="submit" value="Submit" class="editJob" />
          </div>
     </form>

     <script>
          var pref = <?php echo $pref; ?>;
          if (pref == 12) {
               document.getElementById("12").setAttribute("checked", "checked");
          } else if (pref == 24) {
               document.getElementById("24").setAttribute("checked", "checked");
          } else {
               document.getElementById("12").setAttribute("checked", "checked");
          }
     </script>
</body>
</html>
