<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";
include_once "sql-testing/contactAdmin.inc.php";
?>

<!doctype HTML>
<html>
<head>
     <?php include 'header.php' ?>
     <title>Contact Admin</title>
</head>
<body>

<div id="header">
     <h1>Contact Admin</h1>
     <a href="index.php">Back</a>
</div>

<div class="row" style="height: 5%;">
     <p style="text-align: center; font-size: 2vh;">Questions? Comments? Concerns? Type them in the box below!</p>
</div>

<form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" style="text-align: center;">
     <div class="row">
          <textarea id="customText" name="commentBox" type="paragraph" autocomplete="off">Type here!</textarea>
     </div>
     <div class="row4">
          <input type="submit" value="Send Message" class="register" />
     </div>
</form>

</body>
</html>
