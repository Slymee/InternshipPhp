<?php
    session_start();
    require('./Partials/check-login.php');

    if(!isLoggedIn())
    {
        $_SESSION['message'] = "Please Login to continue.";
        header('location: ./login-register.php');
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Resources/css/nav-bar.css">
    <link rel="stylesheet" href="./Resources/css/change-password.css">
    <title>Diary Entry-Change Password</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="container">
        <div class="form-div">
            asdasd
        </div>
    </section>
</body>
</html>