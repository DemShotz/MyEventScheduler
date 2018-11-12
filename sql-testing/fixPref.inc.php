<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$error_msg = "";

if (isset($_POST['clockRadio'])) {
     $conn = "UPDATE members SET clock='" . $_POST['clockRadio'] . "' WHERE id='" .  $_SESSION['user_id'] . "'";
     $result = $mysqli->query($conn);

     if ($result == false) {
          $error_msg = "An error occured. Please contact the system admin.";
     }
     header("Location: ../index.php");
}
