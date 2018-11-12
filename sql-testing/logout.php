<?php
include_once "functions.php";
sec_session_start();

// Unset all session VALUES
$_SESSION = array();

// Get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie
setcookie(session_name(), "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
setcookie("LoginPersistence", "", time() - 42000, "/");

// Destroy session
session_destroy();
header("Location: ../index.php");

?>
