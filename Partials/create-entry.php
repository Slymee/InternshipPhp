<?php
    use InternshipPhp\Modules\Posts;

    session_start();
    require_once('../Modules/Posts.php');

    try
    {
        Posts::create($_POST['entry_title'], $_POST['date'], $_POST['entry_content'], $_POST['username']);
        $_SESSION['message'] = "Entry Recorded.";
        header("Location: ../diary-entry.php");
    }catch (Exception $e)
    {
        $_SESSION['message'] = "Entry Failed: ". $e->getMessage();
        header("Location: ../diary-entry.php");
    }