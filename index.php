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
    <link rel="stylesheet" href="./Resources/css/index.css">
    <title>Diary Entry-Home</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="main-container">
        <div class="form-container">
            <div class="form-title-container">
                <span class="form-title">Diary Entry</span>
            </div>
            <form action="./Partials/create-entry.php" method="post">
                <input type="text" placeholder="Entry Title" name="entry_title">
                <input type="datetime-local" name="datetime" id="">
                <textarea name="entry_content" placeholder="Entry here"></textarea>
                <input type="hidden" name="username" value="<?php echo $_SESSION['user']?>">
                <input type="submit" value="Enter">
                <span class="message-span"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?></span>
            </form>
        </div>
    </section>
</body>
</html>

<?php
    unset($_SESSION['message']);
?>