<?php
    use InternshipPhp\Modules\Users;

    session_start();
    require_once('../Modules/Users.php');

    try{
        if(Users::changeProfilePicture($_SESSION['user'], $_FILES['image']))
        {
            $_SESSION['message'] = 'Picture successfully uploaded.';
            header('Location: ../profile.php');
        }else{
            $_SESSION['message'] = 'Picture upload error.';
            header('Location: ../profile.php');
        }
    }catch (Exception $e){
        $_SESSION['message'] = 'Picture upload failed: '. $e->getMessage();
        header('Location: ../profile.php');
    }
?>