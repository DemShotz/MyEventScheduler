<?php
include_once "sql-testing/db_connect.php";
include_once "sql-testing/functions.php";

sec_session_start();

if (login_check($mysqli) == true) {
     $logged = "in";
} else {
     $logged = "out";
}
?>

<!DOCTYPE html>
<html>
<head>
     <title>Secure Log-In</title>
     <?php include "header.php"; ?>
</head>
<body>
     <div id="header">
          <h1>Login</h1>
          <a href="index.php">Back</a>
     </div>

     <?php
          if (isset($_GET["error"])) {
               if ($_GET["error"] == "pass") {
                    echo "<p class='error'>Incorrect Password!</p>";
               } else if ($_GET["error"] == "email") {
                    echo "<p class='error'>Incorrect Email!</p>";
               } else if ($_GET["error"] == "checkbrute") {
                    echo "<p class='error'>Your account has been locked. Try again in 2 hours.</p>";
               } else {
                    echo "<p class='error'>An unknown error occured</p>";
               }
          }
     ?>

     <div class="login-container">

     <form action="sql-testing/process_login.php" method="post" name="login_form" class="login-form">
          <div class="row3">
               <p class="loginp">Email:</p>
          </div>
          <div class="row3">
               <input type="text" name="email" class="login" />
          </div>
          <div class="row3">
               <p class="loginp">Password:</p>
          </div>
          <div class="row3">
               <input type="password" name="password" id="password" class="login" />
          </div>
          <div class="row7">
          <label for="remember_me">Remember Me</label><input id="remember_me" type="checkbox" value="1" name="remember_me" class="option-input radio"/>
          </div>
          <input id="login" type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
          
          <div class="login-info">
               <?php
                    if (login_check($mysqli) == true) {
                         echo '<p class="logincheck">Currently logged ' . $logged . " as " . htmlentities($_SESSION["username"]) . '.</p>';
                         echo '<p class="logincheck">Do you want to change user? <a href="sql-testing/logout.php">Log out</a>.</p>';
                    } else {
                         echo '<p class="logincheck">Currently logged ' . $logged . '.</p>';
                         echo "<p class='logincheck'>If you don't have a login, please <a href='register.php'>register</a></p>";
                    }
               ?>
          </div>
          
     </form>
     </div>

     <script>
          document.getElementsByTagName("body")[0].addEventListener("keypress", function(event) {
               if (event.which == 13 || event.keyCode == 13) {
                    formhash(document.getElementsByClassName("login-form")[0], document.getElementById("password"));
               }
               });
     </script>

</body>
</html>
