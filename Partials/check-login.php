<?php
    function isLoggedIn()
    {
        if(isset($_SESSION['isLoggedIn'])
        && isset($_SESSION['user']))
        {
            return true;
        }
        return false;
    }
?>