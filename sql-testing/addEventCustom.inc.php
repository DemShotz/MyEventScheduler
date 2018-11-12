<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$error_msg = "";

if (isset($_POST['clickedDate'], $_POST['customText'])) {
     $conn = "INSERT INTO events (id, date, custom) VALUES ('" . $_SESSION['user_id'] . "', '" . $_POST['clickedDate'] . "', '" . $_POST['customText'] . "')";
     $result = $mysqli->query($conn);
     if ($result === false) {
          $error_msg .= "<p class='error'>An unknown error occured. Please contact the system admin</p>";
     }

     $monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
     $monthSplit = preg_split("/ /", $_POST["clickedDate"]);
     $pos = array_search($monthSplit[0], $monthHeader);
     $_SESSION["setMonth"] = $pos;
     header("Location: ../index.php");
}
