<?php
    use InternshipPhp\Modules\Posts;

    session_start();
    require_once('../Modules/Posts.php');
    
    try
    {
        Posts::edit($_POST['entry_id'], $_POST['entry_title'], $_POST['entry_content']);
        $_SESSION['message'] = "Entry Edited.";
        header("Location: ../edit-entry.php?id=". $_POST['entry_id']);
    }catch (Exception $e)
    {
        $_SESSION['message'] = "Entry Failed: ". $e->getMessage();
        header("Location: ../edit-entry.php". $_POST['entry_id']);
    }