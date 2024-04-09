<?php

use InternshipPhp\Modules\Users;

    session_start();
    require_once('../Modules/Users.php');

    try{
        Users::register($_POST['username'], $_POST['email'], $_POST['password'], $_POST['confirm_password']);
        $_SESSION['message'] = 'User Registered';
        header('Location: ../login-register.php');
    }catch (Exception $e){
        $_SESSION['message'] = 'Registration failed: '. $e->getMessage();
        header('Location: ../login-register.php');
    }
?>