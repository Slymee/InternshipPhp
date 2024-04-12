<?php
namespace InternshipPhp\Modules;

use Exception;
use InternshipPhp\Partials\Database;

require_once('../Partials/Database.php');

class Posts{



    public static function create($entryTitle, $date, $entryContent, $username)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if (empty($entryTitle) || empty($date) || empty($entryContent) || empty($username))
        {
            $db->closeConnection();
            throw new Exception("All feilds should be filled!!");
        }

        $fileName = $username ."-". time() ."-". $entryTitle .".txt";
        $filePath = dirname(__DIR__). '/Storage/'. $fileName;
        file_put_contents($filePath, $entryContent);


        $columnNames = ['username', 'entry_title', 'file_path', 'created_at'];
        $columnValues = [':username', ':entry_title', ':file_path', ':created_at'];

        $columns = implode(", ", $columnNames);
        $values = implode(", ", $columnValues);

        $insertStatement = $conn->prepare("INSERT INTO posts ($columns) VALUES ($values)");
        $insertStatement->bindParam(':username', $username);
        $insertStatement->bindParam(':entry_title', $entryTitle);
        $insertStatement->bindParam(':file_path', $filePath);
        $insertStatement->bindParam(':created_at', $date);

        $insertStatement->execute();

        $db->closeConnection();
    }
}