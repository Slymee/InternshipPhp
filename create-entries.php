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
    <link rel="stylesheet" href="./Resources/css/nav-bar.css">
    <link rel="stylesheet" href="./Resources/css/side-bar.css">
    <link rel="stylesheet" href="./Resources/css/entries.css">
    <title>Diary Entry - Create Entry</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="main-container">
        <?php include('./Components/sidebar.php');?>

        <div class="content-container">
            <div class="form-container">
                <div class="form-title-container">
                    <span class="form-title">Diary Entry</span>
                </div>
                <form action="./Partials/create-entry.php" method="post">
                    <input type="text" placeholder="Entry" name="entry_title" value="<?php if(isset($_SESSION['entryTitle'])) echo $_SESSION['entryTitle']; ?>">
                    <input type="date" name="date" id="" value="<?php if(isset($_SESSION['date'])) echo $_SESSION['date']; ?>">
                    <textarea name="entry_content" placeholder="Entry here"><?php if(isset($_SESSION['entryContent'])) echo $_SESSION['entryContent']; ?></textarea>
                    <input type="hidden" name="username" value="<?php echo $_SESSION['user']?>">
                    <input type="submit" value="Enter">
                    <span class="message-span"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?></span>
                </form>
            </div>
        </div>
    </section>
</body>
</html>

<?php
unset($_SESSION['message']);
unset($_SESSION['entryTitle']);
unset($_SESSION['date']);
unset($_SESSION['entryContent']);
?>