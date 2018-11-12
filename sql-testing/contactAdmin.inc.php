<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

if (isset($_POST['commentBox'])) {
     $emailtext = $_POST['commentBox'];
     $headers = 'From: admin@myeventscheduler.com';

     mail('kitsulalex@shaw.ca', 'Website Feedback', $emailtext, $headers);
}
?>
