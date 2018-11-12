<?php
include_once "db_connect.php";
include_once "functions.php";
sec_session_start();

$jobname = $_GET['name'];

$conn = "DELETE FROM jobs WHERE id='" . $_SESSION['user_id'] . "' AND jobname='" . $jobname . "'";
$result = $mysqli->query($conn);

$conn = "DELETE FROM events WHERE id='" . $_SESSION['user_id'] . "' AND job='" . $jobname . "'";
$result = $mysqli->query($conn);

header("Location: ../manageJobs.php");
