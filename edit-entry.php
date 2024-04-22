<?php

use InternshipPhp\Partials\Database;

    session_start();
    require('./Partials/check-login.php');
    if(!isLoggedIn())
    {
        $_SESSION['message'] = "Please Login to continue.";
        session_write_close();
        header('location: ./login-register.php');
    }
?>

<?php
    if(!isset($_GET['id']))
    {
        $_SESSION['message'] = "Page not found!";
        header('Location: ./my-entries.php');
    }

    include('./Partials/Database.php');
    $db = new Database();
    $conn = $db->getConnection();

    $columns = ['username', 'entry_title', 'file_name', 'created_at'];
    $selectSQL = "SELECT ". implode(', ', $columns) ." FROM posts WHERE id = :id AND username = :username";
    $statement = $conn->prepare($selectSQL);
    $statement->bindParam(':id', $_GET['id']);
    $statement->bindParam(':username', $_SESSION['user']);
    $statement->execute();

    $row =  $statement->fetch(PDO::FETCH_ASSOC);
?>

<?php
    if($_SESSION['user'] != $row['username'])
    {
        $_SESSION['message'] = "Page not found!";
        header('Location: ./my-entries.php');
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
    <title>Diary Entry - Edit Entry</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="main-container">
        <?php include('./Components/sidebar.php');?>

        <div class="content-container">
            <div class="form-container">
                <div class="form-title-container">
                    <span class="form-title">Diary Entry Edit</span>
                </div>
                <form action="./Partials/edit-action.php" method="post">
                    <div>Entry Date: <?php echo $row['created_at'];?></div>
                    <input type="text" placeholder="Entry Title" name="entry_title" value="<?php echo $row['entry_title']?>">
                    <textarea name="entry_content" placeholder="Entry Here"><?php 
                            $filePath = __DIR__ . '/Storage/' . $row['file_name'];
                            $content = file_get_contents($filePath);
                            echo $content;
                        ?></textarea>
                    <input type="hidden" name="entry_id" value="<?php echo $_GET['id']?>">
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
?>