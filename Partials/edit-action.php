<?php
    use InternshipPhp\Modules\Posts;

    session_start();
    require_once('../Modules/Posts.php');
    
    try
    {
        Posts::edit($_POST['entry_id']);
        $_SESSION['message'] = "Entry Edited.";
        header("Location: ../edit-entry.php");
    }catch (Exception $e)
    {
        $_SESSION['message'] = "Entry Failed: ". $e->getMessage();
        header("Location: ../edit-entry.php");
    }