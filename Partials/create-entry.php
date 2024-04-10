<?php
    use InternshipPhp\Modules\Posts;

    session_start();
    require_once('../Modules/Posts.php');

    try{
        Posts::create($_POST['entry_title'], $_POST['datetime'], $_POST['entry_content'], $_POST['username']);
    }catch (Exception $e){
        $_SESSION['message'] = "Entry Failed: ". $e->getMessage();
        header("Location: ../index.php");
    }