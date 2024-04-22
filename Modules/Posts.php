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

        $_SESSION['entryTitle'] = $entryTitle;
        $_SESSION['date'] = $date;
        $_SESSION['entryContent'] = $entryContent;

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

        unset($_SESSION['entryTitle']);
        unset($_SESSION['date']);
        unset($_SESSION['entryContent']);
    }

    public static function destroy($entryID)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if(empty($entryID))
        {
            $db->closeConnection();
            throw new Exception('ID field cannot be empty!!');
        }

        if(!is_numeric($entryID))
        {
            $db->closeConnection();
            throw new Exception('ID must be numeric!');
        }

        $entryDeleteSQL = "DELETE FROM posts WHERE id = :entryID";
        $statement = $conn->prepare($entryDeleteSQL);
        $statement->bindParam(':entryID', $entryID);

        if(!$statement->execute())
        {
            $db->closeConnection();
            throw new Exception('Record does not exist!');
        }

        $db->closeConnection();
    }

    public static function edit($entryID, $entryTitle, $entryContent)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if(empty($entryID) || empty($entryTitle))
        {
            $db->closeConnection();
            throw new Exception('Required fields cannot be empty!');
        }

        $fileNameSQL = "SELECT file_name FROM posts WHERE id = :id";
        $statement = $conn->prepare($fileNameSQL);
        $statement->bindParam(':id', $entryID);
        $statement->execute();

        $fileName = $statement->fetchColumn();
        if($filePath = dirname(__DIR__) .'/Storage/'. $fileName)
        {
            file_put_contents($filePath, '');
            file_put_contents($filePath, $entryContent);
        }
        else
        {
            $db->closeConnection();
            throw new Exception("Content edit failed!");
        }

        $updateSQL = "UPDATE posts SET entry_title = :entry_title WHERE id = :id";
        $statement = $conn->prepare($updateSQL);
        $statement->bindParam(':entry_title', $entryTitle);
        $statement->bindParam(':id', $entryID);
        $statement->execute();

        $db->closeConnection();
    }
}