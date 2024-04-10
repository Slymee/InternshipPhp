<?php
namespace InternshipPhp\Modules;

use Exception;
use PDO;
use InternshipPhp\Partials\Database;

require_once('../Partials/Database.php');

class Posts{

    public static function create($entryTitle, $date, $entryContent, $username)
    {
        $db = new Database();
        $conn = $db->getConnection();

        // echo $entryTitle ."<br>". $dateTime ."<br>". $entryContent ."<br>". $username;
        // die();

        if (empty($entryTitle) || empty($date) || empty($entryContent) || empty($username))
        {
            $db->closeConnection();
            throw new Exception("All feilds should be filled!!");
        }

        $fileName = $username ."-". time() ."-". $entryTitle .".txt";
        $filePath = 'D:\wamp64\www\InternshipPhp\Storage/'. $fileName;
        file_put_contents($filePath, $entryContent);

        $userIdSQL = "SELECT id FROM users WHERE username = :username";
        $selectStatement = $conn->prepare($userIdSQL);
        $selectStatement->bindParam(':username', $username);
        $selectStatement->execute();

        $userId = $selectStatement->fetchColumn();

        $columnNames = ['user_id', 'entry_title', 'file_path', 'created_at'];
        $columnValues = [':user_id', ':entry_title', ':file_path', ':created_at'];

        $columns = implode(", ", $columnNames);
        $values = implode(", ", $columnValues);

        $insertStatement = $conn->prepare("INSERT INTO posts ($columns) VALUES ($values)");
        $insertStatement->bindParam(':user_id', $userId);
        $insertStatement->bindParam(':entry_title', $entryTitle);
        $insertStatement->bindParam(':file_path', $filePath);
        $insertStatement->bindParam(':created_at', $date);

        $insertStatement->execute();

        $db->closeConnection();
    }


    
    public static function update()
    {

    }
}