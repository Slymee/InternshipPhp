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
                    <tr>
                        <td>Dom</td>
                        <td>6000</td>
                    </tr>
                    <tr class="active-row">
                        <td>Melissa</td>
                        <td>5150</td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </section>
</body>
</html>