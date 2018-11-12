<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";

sec_session_start();

$conn = "SELECT * FROM events WHERE id='" . $_SESSION['user_id'] . "' AND custom=''";
$result = $mysqli->query($conn);
$jsarray = array();
$customarray = array();

while ($row = $result->fetch_assoc()) {
     $conn2 = "SELECT colour FROM jobs WHERE id='" . $_SESSION['user_id'] . "' AND jobname ='" . $row['job'] . "'\n";
     $result1 = $mysqli->query($conn2);
     if ($result1->num_rows > 1) {
          echo "potato";
     }

     if (empty($row['timestart']) || empty($row['timeend'])) {
          $customarray[] = $row['date'] . " " . $row['custom'] . " " . $row['eventid'];
     } else {
          $jsarray[] = $row['date'] . " from " . $row['timestart'] . " until " . $row['timeend'] . " with " . $row['breaktime'] . " event id " . $row['eventid'] . " color='" . $result1->fetch_assoc()['colour'];
     }
}

$conn = "SELECT clock FROM members WHERE id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);
$clock = $result->fetch_assoc();
$clock = $clock['clock'];

?>

<!DOCTYPE HTML>
<html>
<head>
     <title>Calculate Hours</title>
     <?php include_once "header.php"; ?>
</head>

<body>

<?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
     <script> alert('Please choose an end date after your selected start date'); </script>
<?php endif; ?>

<div id="header">
     <h1 id="date"></h1>
     <a href="index.php" onclick="calculateReturn();">Back</a>
     <a href="#" id="returnCurrent" style="display: none;" onclick="returnCurrent()">Return</a>
</div>

<div id="calculate">
     <div style="height: 100%">
          <table>
          <tbody id="potato">
               <tr>
                   <th id="0">S</th>
                   <th id="1">M</th>
                   <th id="2">T</th>
                   <th id="3">W</th>
                   <th id="4">T</th>
                   <th id="5">F</th>
                   <th id="6">S</th>
               </tr>
               <tr id="firstRow">
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
               <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
               <tr style="display: none;" id="addedPotato">
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
               </tr>
          </tbody>
          </table>
     </div>
</div>
<div class="calculation-container">
     <h2 id="startMe">Select Start Date</h2>
     <h2 id="endMe">Select End Date</h2>
</div>
 <div class="bottom-nav">
               <a onclick="swipeRight()" href="#" id="swipeRight"> &rsaquo; </a>
               <a onclick="swipeLeft()" href="#" id="swipeLeft"> &lsaquo; </a>
               <?php if (login_check($mysqli) == true) : ?>
                    <p class="session">Logged in as <?php echo htmlentities($_SESSION["username"]);?>! <a href="sql-testing/logout.php">Logout</a>.</p>
               <?php else : ?>
                    <p class="session">You are not logged in. <a href="login.php">Log in.</a></p>
               <?php endif; ?>
               </div>
<form action="sql-testing/calculateHours.inc.php" style="display: none;" method="post">
     <input name="starting" type="text" id="starting" />
     <input name="ending" type="text" id="ending" />
</form>

<script src="scripts/script.js" type="text/javascript"></script>

<script>
     <?php if (isset($_SESSION["user_id"])) : ?>
          <?php if (isset($_SESSION["setMonth"])) : ?>
               var setMonth = <?php echo $_SESSION["setMonth"]; ?>;
               var year = <?php echo $_SESSION["setYear"]; ?>;
          <?php endif;
               unset($_SESSION["setMonth"]);
               unset($_SESSION['setYear']);
          ?>
          var rowArray = <?php echo json_encode($jsarray); ?>;
          var customArray = <?php echo json_encode($customarray); ?>;
          var thePref = <?php echo $clock; ?>;
     <?php endif; ?>
          makeCalendar();
          var madeUp = document.getElementsByClassName("madeUp");
          var eventInfo = document.getElementsByClassName("event-info");
          for (i = 0; i < madeUp.length; i++) {
               madeUp[i].removeAttribute("onclick");
               madeUp[i].removeEventListener("click", clickedThis);
               madeUp[i].addEventListener("click", selectThis);
          }
          for (i = 0; i < eventInfo.length; i++) {
               eventInfo[i].removeAttribute("onclick");
               eventInfo[i].removeEventListener("click", stopProp);
          }

          document.getElementById("swipeRight").addEventListener("click", stopListeners);
          document.getElementById("swipeLeft").addEventListener("click", stopListeners);

          function stopListeners() {
               var madeUp = document.getElementsByClassName("madeUp");
               var eventInfo = document.getElementsByClassName("event-info");

               for (i = 0; i < madeUp.length; i++) {
                    if (madeUp[i].className.length > 0) {
                         madeUp[i].removeAttribute("style");
                         var splitThis = madeUp[i].className.split("-");
                         if (setMonth == splitThis[1] && year == splitThis[2] && madeUp[i].firstChild.data == splitThis[0]) {
                              madeUp[i].style.backgroundColor = "gray";
                         }
                    }
               }


               for (i = 0; i < madeUp.length; i++) {
                    madeUp[i].removeAttribute("onclick");
                    madeUp[i].removeEventListener("click", clickedThis);
                    madeUp[i].addEventListener("click", selectThis);
               }
               for (i = 0; i < eventInfo.length; i++) {
                    eventInfo[i].removeAttribute("onclick");
                    eventInfo[i].removeEventListener("click", stopProp);
               }
          }
</script>

</body>
</html>
