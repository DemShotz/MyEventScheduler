<?php
include_once "sql-testing/register.inc.php";
include_once "sql-testing/functions.php";
?>
<!DOCTYPE html>
<html>
<head>
     <title>Register</title>
     <?php include 'header.php' ?>
</head>

<body>

     <div id="header">
          <h1>Register</h1>
          <a href="index.php">Back</a>
     </div>

     <?php
     if(!empty($error_msg)) {
          echo $error_msg;
     }
     ?>
 <div class="login-container">
     <form action="<?php echo esc_url($_SERVER["REQUEST_URI"]) ?>" method="post" name="registration_form" class="registration-form">
     <div class="row3">
          Username:
     </div>
     <div class="row3">
          <input type="text" name="username" id="username" />
     </div>
     <div class="row3">
          Email:
     </div>
     <div class="row3">
          <input type="text" name="email" id="email" />
     </div>
     <div class="row3">
          Password:
     </div>
     <div class="row3">
          <input type="password" name="password" id="password" />
     </div>
     <div class="row3">
          Confirm Password:
     </div>
     <div class="row3">
          <input type="password" name="confirmpwd" id="confirmpwd" />
     </div>
     <div class="row3">
          <label for="12hour">12 hour time</label><input type="radio" class="option-input radio" name="timeRadio" id="12hour" value="12" checked="checked"/>
     </div>
     <div class="row3" style="margin-bottom: 30px">
          <label for="24hour">24 hour time</label><input type="radio" class="option-input radio" name="timeRadio" id="24hour" value="24" />
     </div>
     <div class="row3">
          <input class="register" type="button" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd, this.form.timeRadio);" />
     </div>
     </form>


<div class="login-info">
     <p style="text-align: center;">Return to the <a href="index.php">Login page</a>.</p>

     <p class="params" style="margin-top: 1em;">Usernames may contain only digits, upper and lower case letters, and underscores</p>
     <p class="params">Emails must be a valid email format</p>
     <p class="params">Passwords must be at least 6 characters long</p>
     <p class="params" style="text-decoration: underline;">Passwords must contain:</p>
          <ul class="params">
               <li>At least one uppercase letter (A-Z)</li>
               <li>At least one lowercase letter (a-z)</li>
               <li>At least one number (0-9)</li>
          </ul>
     <p class="params">Your password and confirmation must match exactly</p>
</div>
</div>

</body>
</html>
