<?php 
use InternshipPhp\Modules\Posts;

    session_start();
    require_once('../Modules/Posts.php');

    try
    {
        Posts::destroy($_POST['entry_delete']);
        $_SESSION['message'] = 'Entry Deleted!!';
        header("Location: ../my-entries.php");
    }catch (Exception $e)
    {
        $_SESSION['message'] = 'Delete Failed: '. $e->getMessage();
        header("Location: ../my-entries.php");
    }