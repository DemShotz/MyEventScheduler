function formhash(form, password) {
     // Create a new element input, this will be out hashed password field.

     var p = document.createElement("input");

     // Add the new element to our form

     form.appendChild(p);
     p.name = "p";
     p.type = "hidden";
     p.value = hex_sha512(password.value);

     // Make sure the plaintext password doesn't get sent

     password.value = "";

     // Finally submit the form

     form.submit();
}

function regformhash(form, uid, email, password, conf, radio) {
     //Check each field has a value

     if (uid.value == "" || email.value == "" || password.value == "" || conf.value == "" || radio.value == "") {
          alert("You must provide all the requested details. Please try again");
          return false;
     }

     // Check the username

     re = /^\w+$/;

     if(!re.test(form.username.value)) {
          alert("Username must contain only letters, numbers and underscores. Please try again.");
          form.username.focus();
          return false;
     }

     // Check that the password is long enough (min 6 chars)

     if (password.value.length < 6) {
          alert("Passwords much be at least 6 characters long. Please try again");
          form.password.focus();
          return false;
     }

     //At least one number, one lowercase, one uppercase (and 6 chars)

     var re = /(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).{6,}/;

     if(!re.test(password.value)) {
          alert("Passwords must contain at least one number, one lowercase, and one uppercase. Please try again.");
          return false;
     }

     // Check pass and conf are same

     if (password.value != conf.value) {
          alert("Your password and confirmation do not match. Please try again");
          form.password.focus();
          return false;
     }

     var p = document.createElement("input");

     // Add the new element to our form.

     form.appendChild(p);
     p.name = "p";
     p.type = "hidden";
     p.value = hex_sha512(password.value);

     // No plaintext

     password.value = "";
     conf.value = "";

     // Submit the FORMMMM

     form.submit();
     return true;
}
