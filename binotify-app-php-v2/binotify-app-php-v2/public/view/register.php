<?php

if (isset($_SESSION["user_id"])) {
  header("location: /");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="public/css/register.css">
  <title>Register - SoundClown</title>
</head>

<body>
  <div class="container title-extension">
    <h1><img src="public/assets/SoundClownfish_black.png" alt="logo" class="logo"> SoundClown</h1>
    <h2>Sign up for free to start listening.</h2>
  </div>

  <hr>

  <div class="container form-extension">
    <form onsubmit="submitRegister(event)">

      <div class="form-section">
        <label for="username">What's your username?</label> <br>
        <input type="text" name="username" onkeyup="usernameChange()" id="input-username" placeholder="Enter your username" required> <br>
        <p id="username-error" class="error"></p>
      </div>

      <div class="form-section">
        <label for="email">What's your email?</label> <br>
        <input type="email" name="email" onkeyup="emailChange()" id="input-email" placeholder="Enter your email" required> <br>
        <p id="email-error" class="error"></p>
      </div>

      <div class="form-section">
        <label for="nama">What should we call you?</label> <br>
        <input type="text" name="nama" id="input-nama" placeholder="Enter a profile name" required> <br>
      </div>

      <div class="form-section">
        <label for="password">Create a password</label> <br>
        <input type="password" name="password" id="input-password" placeholder="Create a password" required> <br>
      </div>

      <div class="form-section">
        <label for="confirm-password">Confirm Password </label> <br>
        <input type="password" name="confirm-password" id="input-confirm-password" placeholder="Confirm your password" required> <br>
        <p id="password-error" class="error"></p>
      </div>

      <div class="container">
        <input type="submit" value="Sign Up" id="submit-button">
        <br>
        <p>
          Want to try SoundClown? <a href="/">Continue as guest</a>.
        </p>
        <br>
        <p>Have an account? <a href="/login">Log in</a>.</p>
      </div>

    </form>
  </div>
  <script src="public/js/lib.js"></script>
  <script src="public/js/register.js"></script>
</body>

</html>