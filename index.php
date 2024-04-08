<?php
    session_start();
    require('./Partials/check-login.php');
    if(!isLoggedIn())
        header('location: ./login-register.php');
?>