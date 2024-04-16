<?php

use InternshipPhp\Partials\Database;
use PDO;

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
    include('./Partials/Database.php');
    $db = new Database();
    $conn = $db->getConnection();
    $count = 1;

    $statement =$conn->prepare("SELECT id, entry_title FROM posts WHERE username = :username");
    $statement->bindParam(':username', $_SESSION['user']);
    $statement->execute();

    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Resources/css/nav-bar.css">
    <link rel="stylesheet" href="./Resources/css/side-bar.css">
    <link rel="stylesheet" href="./Resources/css/my-entry.css">
    <title>Diary Entry - My Entries</title>
</head>
<body>
    <?php include('./Components/navbar.php');?>
    <section class="main-container">
        <?php include('./Components/sidebar.php');?>

        <div class="content-container">
            <div class="title-container"><span>
                My Entry
            </span></div>

            <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Entry Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rows as $row){?>
                    <tr>
                        <td><?php echo $count?></td>
                        <td><?php echo $row['entry_title']?></td>
                        <td><a href=""><button>Edit</button></a></td>
                        <td><a href=""><button>Delete</button></a></td>
                    </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>
            </div>
        </div>
    </section>
</body>
</html>