<?php
include_once "db_connect.php";
include_once "functions.php";

sec_session_start();

$_SESSION["setMonth"] = $_GET["setMonth"];
$_SESSION["setYear"] = $_GET["setYear"];

header("Location: ../calculateHours.php");

?>
