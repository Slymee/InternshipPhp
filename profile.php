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
    <title>Diary Entry-<?php echo $_SESSION['user'];?></title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    askdjnasd
</body>
</html>