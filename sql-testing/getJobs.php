<?php
$conn = "SELECT * FROM jobs WHERE id='" . $_SESSION['user_id'] . "'";
$result = $mysqli->query($conn);
$jsarray = array();

while ($row = $result->fetch_assoc()) {
     $jsarray[] = $row["jobname"];
}

 ?>
