<?php
namespace InternshipPhp\Modules;

use Exception;
use PDO;
use InternshipPhp\Partials\Database;

require_once('../Partials/Database.php');

class Posts{

    public static function create($entryTitle, $dateTime, $entryContent, $username)
    {
        $db = new Database();
        $conn = $db->getConnection();

        // echo $entryTitle ."<br>". $dateTime ."<br>". $entryContent ."<br>". $username;
        // die();

        if (empty($entryTitle) || empty($dateTime) || empty($entryContent) || empty($username))
        {
            $db->closeConnection();
            throw new Exception("All feilds should be filled!!");
        }

        $fileName = $username ."-". time() ."-". $entryTitle .".txt";
        $filePath = 'Storage/'. $fileName;
        file_put_contents($filePath, $entryContent);

        
    }
}