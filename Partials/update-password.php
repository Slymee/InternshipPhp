<?php
    use InternshipPhp\Modules\Users;

    session_start();
    require_once('../Modules/Users.php');

    try{
        Users::changePassword($_POST['old_password'], $_POST['new_password'], $_POST['confirm_password'], $_POST['username']);
        $_SESSION['message'] = 'Password Updated.';
        header('Location: ../change-password.php');
    }catch (Exception $e){
        $_SESSION['message'] = 'Password Update Failed: '. $e->getMessage();
        header('Location: ../change-password.php');
    }
?>