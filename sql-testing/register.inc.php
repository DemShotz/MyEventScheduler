<?php
include_once "db_connect.php";
include_once "psl-config.php";

$error_msg = "";

if(isset($_POST["username"], $_POST["email"], $_POST["p"])) {
     // Sanitize and validate the data passed in
     $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
     $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
     $email = filter_var($email, FILTER_VALIDATE_EMAIL);
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          // Not a valid email
          $error_msg .= '<p class="error">The email address you entered is not valid</p>';
     }

     $password = filter_input(INPUT_POST, "p", FILTER_SANITIZE_STRING);
     if(strlen($password) != 128) {
          // The hashed password should be 128 characters long.
          // If it's not, something odd has happened
          $error_msg .= '<p class="error">Invalid password configuration.</p>';
     }

     // Username validility and password validility have been checked client side. This should be adequate as no one gains an advantage from breaking these rules

     $prep_stmt = "SELECT id FROM members WHERE email = ? LIMIT 1";
     $stmt = $mysqli->prepare($prep_stmt);

     //Check existing email
     if ($stmt) {
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $stmt->store_result();

          if($stmt->num_rows == 1) {
               // A user with this email address already exists
               $error_msg .= '<p class="error">A user with this email address already exists</p>';
               $stmt->close();
          }
     } else {
          $error_msg .= '<p class="error">Database error Line 41</p>';
          $stmt->close();
     }

     // check existing username
     $prep_stmt = "SELECT id FROM members WHERE username = ? LIMIT 1";
     $stmt = $mysqli->prepare($prep_stmt);

     if($stmt) {
          $stmt->bind_param("s", $username);
          $stmt->execute();
          $stmt->store_result();

          if($stmt->num_rows == 1) {
               // A user with this username already exists
               $error_msg .= '<p class="error">A user with this username already exists</p>';
               $stmt->close();
          }
     } else {
          $error_msg .= '<p class="error">Database error line 60</p>';
          $stmt->close();
     }

     // TODO:
     //We'll also have to account for the situation where the user doesn't have rights to do registration
     //by checking what type of user is attempting to do the operation.

     if(empty($error_msg)) {
          // Create hashed password using the password_hash function.
          // This function salts it with a random salt and can be verifyed with the password_verify function.
          $password = password_hash($password, PASSWORD_BCRYPT);

          //Insert the new user into the db

          if($insert_stmt = $mysqli->prepare("INSERT INTO members (username, email, password, clock) VALUES (?, ?, ?, ?)")) {
               $insert_stmt->bind_param("ssss", $username, $email, $password, $_POST['timeRadio']);
               //Execute the prepared query
               if (! $insert_stmt->execute()) {
                    header("Location: ../error.php?err-Registration failiure: INSERT");
               }
          }
          header("Location: ../register_success.php");
     }
}
?>
