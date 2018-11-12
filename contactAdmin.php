<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/contactAdmin.inc.php";
?>

<!doctype HTML>
<html>
<head>
     <?php include 'header.php' ?>
     <title>Contact Website Creator</title>
</head>
<body>

<div id="header">
     <h1>Contact Website Creator</h1>
     <a href="index.php">Back</a>
</div>

<div class="row" style="height: 5%;">
     <p style="text-align: center; font-size: 2vh;">Questions? Comments? Concerns? Type them in the box below! *Stupid comments will be ignored and your IP will be banned*</p>
</div>

<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" style="text-align: center;">
     <div class="row">
          <textarea id="customText" name="commentBox" type="paragraph" autocomplete="off">Type here!</textarea>
     </div>
     <div class="row">
          <input type="submit" value="Send Message" class="register" />
     </div>
</form>

</body>
</html>
