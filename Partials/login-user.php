<?php

use InternshipPhp\Modules\Users;

session_start();
require_once('../Modules/Users.php');

try
{
    $_SESSION['user'] = Users::login($_POST['username_or_email'], $_POST['password']);
    $_SESSION['isLoggedIn'] = true;
    header('Location: ../index.php');
}catch (Exception $e)
{
    $_SESSION['message'] = 'Login failed: '. $e->getMessage();
    header('Location: ../login-register.php');
}