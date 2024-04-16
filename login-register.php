<?php 
  session_start();

  if(isset($_SESSION['isLoggedIn'])
  && isset($_SESSION['user']))
  {
    header('Location: ./index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./Resources/css/login-register.css">
  <title>Login & Registration Form</title>
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form action="./Partials/login-user.php" method="post">
        <input type="text" placeholder="Enter your email or username" name="username_or_email" value="<?php if(isset($_SESSION['usernameOrEmail'])) echo $_SESSION['usernameOrEmail']?>">
        <input type="password" placeholder="Enter your password" name="password">
        <a href="#">Forgot password?</a>
        <input type="submit" class="button" value="Login">
        <span class="message-span"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?></span>
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
         <label for="check">Signup</label>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>Signup</header>
      <form action="./Partials/register-user.php" method="post">
        <input type="text" placeholder="Enter your username" name="username" id="" value="<?php if(isset($_SESSION['registerUsername'])) echo $_SESSION['registerUsername']; ?>">
        <input type="text" placeholder="Enter your email" name="email" value="<?php if(isset($_SESSION['registerEmail'])) echo $_SESSION['registerEmail']; ?>">
        <input type="password" placeholder="Create a password" name="password">
        <input type="password" placeholder="Confirm your password" name="confirm_password">
        <input type="submit" class="button" value="Signup">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
</body>
</html>

<?php
    unset($_SESSION['message']);
    unset($_SESSION['usernameOrEmail']);
    unset($_SESSION['registerUsername']);
    unset($_SESSION['registerEmail']);
?>