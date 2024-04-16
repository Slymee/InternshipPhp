<?php
declare(strict_types=1);
namespace InternshipPhp\Modules;

use DateTime;
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
            throw new Exception("All fields should be filled!!");
        }

        function dateValidator($date, $format = 'Y-m-d')
        {
            $dateObject = DateTime::createFromFormat($format, $date);
            return $dateObject && $dateObject->format($format) == $date;
        }

        if(!dateValidator($date))
        {
            $db->closeConnection();
            throw new Exception("Invalid Date Format!!");
        }

        $fileName = $username ."-". time() ."-". $entryTitle .".txt";
        $filePath = dirname(__DIR__). '/Storage/'. $fileName;
        file_put_contents($filePath, $entryContent);


        $columnNames = ['username', 'entry_title', 'file_name', 'created_at'];
        $columnValues = [':username', ':entry_title', ':file_name', ':created_at'];

        $columns = implode(", ", $columnNames);
        $values = implode(", ", $columnValues);

        $insertStatement = $conn->prepare("INSERT INTO posts ($columns) VALUES ($values)");
        $insertStatement->bindParam(':username', $username);
        $insertStatement->bindParam(':entry_title', $entryTitle);
        $insertStatement->bindParam(':file_name', $fileName);
        $insertStatement->bindParam(':created_at', $date);

        $insertStatement->execute();

        $db->closeConnection();
    }
}