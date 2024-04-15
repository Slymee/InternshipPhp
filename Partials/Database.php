<?php
declare(strict_types=1);
namespace InternshipPhp\Partials;

use PDO;
use PDOException;

class Database {
    private $connection;
    private const DB_HOST = '127.0.0.1';
    private const DB_NAME = 'core_php_practice';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';

        public function __construct()
        {
            try
            {
                // $this->connection = new PDO('mysql:host='. self::DB_HOST, self::DB_USER, self::DB_PASSWORD);
                // $this->connection->query("CREATE DATABASE IF NOT EXISTS ". self::DB_NAME);
                $this->connection = new PDO('mysql:host='. self::DB_HOST . ';dbname='. self::DB_NAME, self::DB_USER, self::DB_PASSWORD);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e)
            {
                echo "Failed to connect to database: ". $e->getMessage();
                die();
            }
        }

        public function getConnection(): PDO
        {
            return $this->connection;
        }

        public function closeConnection()
        {
            $this->connection = null;
        }
}
?>