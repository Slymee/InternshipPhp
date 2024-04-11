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
    <link rel="stylesheet" href="./Resources/css/profile.css">
    <title>Diary Entry - <?php echo $_SESSION['user'];?></title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="main-container">
        <div class="user-details-container">
            <div class="profile-pic-container">
                <img src="" alt="" srcset="">
            </div>
            <div class="user-details">
                <?php echo $_SESSION['user'];?>
            </div>
            <div class="pic-utility">
                <form action="./Partials/change-picture.php" method="post" id="picture-form" enctype="multipart/form-data">
                    <input type="file" name="image" id="file-input-button">
                    <input type="submit" value="Submit" id="sumbit-pic">
                </form>
                <button id="file-trigger-button">Upload Profile Picture</button>
            </div>
            <span class="error-message"><?php if(isset($_SESSION['message'])) echo $_SESSION['message'];?></span>
        </div>
        <div class="profile-container">tho,ihriot</div>      
    </section>
    <script src="./Resources/js/profile.js"></script>
</body>
</html>
<?php
    unset($_SESSION['message']);
?>