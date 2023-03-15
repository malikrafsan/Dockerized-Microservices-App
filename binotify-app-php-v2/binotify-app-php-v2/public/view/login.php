<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="public/css/login.css">
  <title>Login - SoundClown</title>
</head>

<body>
  <div class="title">

    <h1><img src="public/assets/SoundClownfish_black.png" alt="logo" class="logo"> SoundClown</h1>
    <hr />
  </div>
  <div class="column side">
    &nbsp;
  </div>

  <div class="column middle">
    <div>
      <div>
        <form onsubmit="login(event)">
          <label for="email_uname">Email address or username<br></label>
          <input type="text" name="email_uname" onkeyup="unameChange()" id="email_uname" placeholder="Email address or username" required>
          <p id="username-error"></p>
          <label for="password">Password<br></label>
          <input type="password" name="password" onkeyup="passwordChange()" id="password" placeholder="Password" required>
          <p id="password-error"></p>
          <div class="login">
            <input type="submit" value="LOG IN" name="Login" onclick="login(event)" />
          </div>

        </form>
        <hr />
        <div class="reg">
          <h3>Don't have an account?</h3>
          <a href="register">
            <button type="button" class="signup">
              SIGN UP FOR SOUNDCLOWN
            </button>
          </a>
          <p class="or">or</p>
          <a href="/">
            <button type="button" class="signup">
              CONTINUE AS GUEST
            </button>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="column side">
    &nbsp;
  </div>
  <script defer async src="public/js/lib.js"></script>
  <script defer async src="public/js/login.js"></script>
</body>


</html>