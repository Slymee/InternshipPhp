<?php
namespace InternshipPhp\Modules;

use Exception;
use PDO;
use InternshipPhp\Partials\Database;

require_once('../Partials/Database.php');

class Posts{

    public static function create($entryTitle, $dateTime, $entryContent, $username)
    {
        echo $entryTitle ."<br>". $dateTime ."<br>". $entryContent ."<br>". $username;
        die();
    }
}