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
                <h2>My Entry</h2>
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
                        <td><a href="./entry-content.php?id=<?php echo $row['id']?>"><?php echo $row['entry_title']?></a></td>
                        <td><a href=""><button class="utility-button">Edit</button></a></td>
                        <td><button class="utility-button" onclick="confirmDelete(<?php echo $row['id']?>)">Delete</button></td>

                        <div class="delete-form" style="display: none;">
                        <form action="./Partials/delete-action.php" method="post" id="entry-delete-<?php echo $row['id']?>">
                                <input type="hidden" name="entry_delete" value="<?php echo $row['id']?>">
                                <input type="submit" value="submit">
                            </form>
                        </div>

                    </tr>
                    <?php $count++; } ?>
                </tbody>
            </table>
            </div>
            <span class="message-span"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']?></span>
        </div>
    </section>
    <script src="./Resources/js/my-entries.js"></script>
</body>
</html>

<?php
    $db->closeConnection();
    unset($_SESSION['message']);
?>