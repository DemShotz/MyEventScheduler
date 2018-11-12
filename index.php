<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";

sec_session_start();

if (isset($_SESSION['user_id'])) {
     $conn = "SELECT * FROM events WHERE id='" . $_SESSION['user_id'] . "'";
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
               $customarray[] = $row['date'] . " 56split698f " . $row['custom'] . " 56split698f " . $row['eventid'];
          } else {
               $jsarray[] = $row['date'] . " from " . $row['timestart'] . " until " . $row['timeend'] . " with " . $row['breaktime'] . " event id " . $row['eventid'] . " color='" . $result1->fetch_assoc()['colour'] . " jobName=" . $row['job'];
          }
     }

     $conn = "SELECT clock FROM members WHERE id='" . $_SESSION['user_id'] . "'";
     $result = $mysqli->query($conn);
     $clock = $result->fetch_assoc();
     $clock = $clock['clock'];

     if ($clock == 0) {
          $unset = 1;
     } else {
          $unset = 0;
     }

     if (isset($_SESSION["setMonth"])) {
          $setMonth = $_SESSION["setMonth"];
     }
}

ob_start();
?>

<!DOCTYPE html>
<html>
     <head>
          <?php include "header.php"; ?>
          <title>My Event Scheduler</title>
     </head>
     <body>

     <?php if (isset($_COOKIE["_welcome"])) : ?>
     <div id="header">
          <h1 id="date"></h1>
          <a onclick="resetMenu()" href="#" id="dropdownList">Menu</a>
          <a href="#" id="returnCurrent" style="display: none;" onclick="returnCurrent()">Return</a>
     </div>
     <div id="menu">
         <div id="manageRow1">
            <a href="manageJobs.php" id="manageJobs">Manage Jobs</a>
            <a onclick="calculateFix();" id="calculateHours">Calculate Hours</a>
         </div>
         <div id="manageRow2">
            <a href="fixPref.php" id="fixPref">12/24 Hour Preference</a>
            <a href="contactAdmin.php" id="contactAdmin">Contact Website Creator</a>
         </div>
         <?php if ($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.myeventscheduler.myeventscheduler") : ?>
         <div id="manageRow3">
            <a onClick="Android.androidSettings();" href="#" id="androidSettings">Android Settings</a>
         </div>
         <?php endif; ?>
     </div>
     <div id="content">
          <div id="body">
               <table>
               <tbody id="potato">
                    <tr id="theDays">
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

               <div class="bottom-nav">
                    <a onclick="swipeRight()" href="#" id="swipeRight"> &rsaquo; </a>
                    <a onclick="swipeLeft()" href="#" id="swipeLeft"> &lsaquo; </a>
                    <?php if (login_check($mysqli) == true) : ?>
                         <p class="session">Logged in as <?php echo htmlentities($_SESSION["username"]);?>! <a href="sql-testing/logout.php">Logout</a>.</p>
                    <?php else : ?>
                         <p class="session">You are not logged in. <a href="login.php">Log in.</a></p>
                    <?php endif; ?>
               </div>

     <script>
          <?php if (isset($_SESSION['user_id'])) : ?>

               if (sessionStorage.getItem("month")) {
                    setMonth = parseInt(sessionStorage.getItem("month"));
                    year = parseInt(sessionStorage.getItem("year"));
                    sessionStorage.removeItem("month");
                    sessionStorage.removeItem("day");
                    sessionStorage.removeItem("year");
               }

               <?php if (isset($setMonth)) : ?>
                    var setMonth = <?php echo $setMonth; ?>;
               <?php endif;
                    unset($_SESSION["setMonth"]);
               ?>
               var rowArray = <?php echo json_encode($jsarray); ?>;
               var customArray = <?php echo json_encode($customarray); ?>;
               var unSet = <?php echo $unset; ?>;
               var thePref = <?php echo $clock; ?>;

               if (unSet == 1) {
                    var setThis = confirm("You have not set a 12/24 hour time preference, would you like to go do this?");
                    if (setThis == true) {
                         window.location.href = "fixPref.php";
                    }
               }
          <?php endif; ?>

          <?php if (!isset($_SESSION['user_id'])) : ?>
               document.getElementById("dropdownList").removeAttribute("onclick");
               document.getElementById("dropdownList").addEventListener("click", function() {alert("Please create an account before opening the menu.")});
          <?php endif; ?>

          makeCalendar();
     </script>

     <?php else : ?>

          <div id="header">
               <h1>Welcome!</h1>
          </div>
          <div class="login-info">
               <p style="text-align: center; text-decoration: underline;">How do I use this website?</p>

               <p class="params" style="margin-top: 1em;">First: Create an account from the login button on the home page.</p>
               <p class="params">Second: Create a job from the manage jobs tab on the top of the screen.</p>
               <p class="params">Third: Click on the date you want to set an event for and fill out all the requested information.</p>
               <p class="params" style="margin-top: 1em; text-decoration: underline;"><a href="index.php">Click here to enter!</a></p>
          </div>

          <?php setcookie("_welcome", "content", time() + (10 * 365 * 24 * 60 * 60)); ?>

          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- potato-ad -->
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-6328554368230452"
               data-ad-slot="9947910128"
               data-ad-format="auto"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>


     <?php endif; ?>
</body>
</html>
<?php ob_end_flush(); ?>
