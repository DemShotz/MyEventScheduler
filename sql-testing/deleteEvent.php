<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$eventid = $_GET['eventId'];

$conn = "SELECT date FROM events WHERE id='" . $_SESSION['user_id'] . "' AND eventid='" . $eventid . "'";
$result = $mysqli->query($conn);
$theDate = $result->fetch_assoc();

$theDate = $theDate['date'];

$monthHeader = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$monthSplit = preg_split("/ /", $theDate);
$pos = array_search($monthSplit[0], $monthHeader);
$_SESSION["setMonth"] = $pos;

$conn = "DELETE FROM events WHERE id='" . $_SESSION['user_id'] . "' AND eventid='" . $eventid . "'";
$result = $mysqli->query($conn);

if($result == false) {
     $error_msg .= "<p class='error'>You're not allowed to modify this event</p>";
     header("Location: ../editEvent.php");
}

header("Location: ../index.php");

?>
