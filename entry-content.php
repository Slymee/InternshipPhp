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
?>

<?php
    include('./Partials/Database.php');
    $db = new Database();
    $conn = $db->getConnection();
    
    // $selectSQL = "SELECT username, entry_title, file_name, created_at FROM posts WHERE id = :id AND username = :username";
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
    <link rel="stylesheet" href="./Resources/css/entry-content.css">
    <title>Diary Entry - <?php echo $row['entry_title'];?></title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    
    <section class="main-container">
        <?php include('./Components/sidebar.php');?>

        <div class="content-container">
            <div>
                <h2>Entry Title: <span class="entry-title-span"><?php echo $row['entry_title'];?></span></h2>
                <h2>Entry Date: <span class="entry-title-span"><?php echo $row['created_at'];?></span></h2>
            </div>

            <div class="entry-content-container">
                <?php 
                    $filePath = __DIR__ . '/Storage/' . $row['file_name'];
                    $content = file_get_contents($filePath);
                    echo $content;
                ?>
            </div>
        </div>
    </section>
</body>
</html>

<?php
    $db->closeConnection();
?>