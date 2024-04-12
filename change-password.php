<?php
    session_start();
    require('./Partials/check-login.php');
    if(!isLoggedIn())
    {
        $_SESSION['message'] = "Please Login to continue.";
        session_write_close();
        header('location: ./login-register.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./Resources/css/nav-bar.css">
  <link rel="stylesheet" href="./Resources/css/login-register.css">
  <title>Login & Registration Form</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Change Password</header>
      <form action="./Partials/update-password.php" method="post">
        <input type="password" placeholder="Enter old password" name="old_password">
        <input type="password" placeholder="Enter new password" name="new_password">
        <input type="password" placeholder="Confirm new password" name="confirm_password">
        <input type="hidden" name="username" value="<?php echo $_SESSION['user'];?>">
        <input type="submit" class="button" value="Change Password">
        <span class="message-span"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?></span>
      </form>
    </div>
  </div>
</body>
</html>

<?php
    unset($_SESSION['message']);    
?>
