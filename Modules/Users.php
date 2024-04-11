<?php
namespace InternshipPhp\Modules;

use Exception;
use PDO;
use InternshipPhp\Partials\Database;

require_once('../Partials/Database.php');

class Users{
    // private $username;
    // private $email;
    // private $password;

    // public function __construct($username, $email, $password){
    //     $this->username = $username;
    //     $this->email = $email;
    //     $this->password =$password;
    // }
    

    public static function register($username, $email, $password, $confirmPassword){
        $db = new Database();
        $conn = $db->getConnection();

        //INPUT VALIDATION
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $db->closeConnection();
            throw new Exception('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $db->closeConnection();
            throw new Exception('Invalid email address.');
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $db->closeConnection();
            throw new Exception('Invalid password. Must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number.');
        }

        if ($password != $confirmPassword){
            $db->closeConnection();
            throw new Exception('Password mismatch!!');
        }

        $columnNames = ['username', 'email', 'password'];
        $columnValues = [':username', ':email', ':password'];

        $columns = implode(", ", $columnNames);
        $values = implode(", ", $columnValues);

        

        $statement = $conn->prepare("INSERT INTO users ($columns) VALUES ($values)");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->bindParam(':username', $username);

        $password = password_hash($password, PASSWORD_DEFAULT);

        $statement->execute();

        $db->closeConnection();
    }



    public static function login($usernameOrEmail, $password)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if(empty($usernameOrEmail) || empty($password))
        {
            $db->closeConnection();
            throw new Exception('All fields are required!');
        }

        $userSQL = "SELECT * FROM users WHERE username = :username OR email = :email";
        $statement = $conn->prepare($userSQL);
        $statement->bindParam(':username', $usernameOrEmail);
        $statement->bindParam(':email', $usernameOrEmail);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password, $user['password']))
        {
            $db->closeConnection();
            return $user['username'];
        }

        $db->closeConnection();
        throw new Exception('Invalid Credentials!');
    }

    
    public static function changePassword($oldPassword, $newPassword, $confirmPassword, $username)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if(empty($oldPassword) || empty($newPassword) || empty($confirmPassword))
        {
            $db->closeConnection();
            throw new Exception('All fields are required!');
        }

        if($newPassword != $confirmPassword)
        {
            $db->closeConnection();
            throw new Exception('Password mismatch!');
        }

        $passwordSQL = "SELECT password FROM users WHERE username = :username";
        $selectStatement = $conn->prepare($passwordSQL);
        $selectStatement->bindParam(':username', $username);
        $selectStatement->execute();

        $user = $selectStatement->fetch(PDO::FETCH_ASSOC);

        if(!password_verify($oldPassword, $user['password']))
        {
            $db->closeConnection();
            throw new Exception('Incorrect old Password!');
        }

        if(password_verify($newPassword, $user['password']))
        {
            $db->closeConnection();
            throw new Exception("Old password can't be new password!");
        }

        $passwordUpdateSQL = "UPDATE users SET password = :newPassword WHERE username = :username";
        $updateStatement = $conn->prepare($passwordUpdateSQL);
        $updateStatement->bindParam(':newPassword', $newPassword);
        $updateStatement->bindParam(':username', $username);

        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateStatement->execute();

        $db->closeConnection();
    }


    public static function changeProfilePicture($username, $file)
    {
        $db = new Database();
        $conn = $db->getConnection();

        if(!isset($file))
        {
            $db->closeConnection();
            throw new Exception('File not selected!');
        }

        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExtention = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if(!in_array($fileExtention, $allowedTypes))
        {
            $db->closeConnection();
            throw new Exception('Invalid file type!');
        }

        if($fileSize > (5 * 1024 * 1024))
        {
            $db->closeConnection();
            throw new Exception('Image greater than 5Mb!');
        }

        $fileNewName = $_SESSION['user'] .time(). 'Profile' .'.'. $fileExtention;
        $uploadPath = '../Storage/' . $fileNewName;

        $pathForDatabase = './Storage/' . $fileNewName;


        if (move_uploaded_file($fileTmpName, $uploadPath))
        {
            $columnNames = ['username', 'image_path'];
            $columnValues = [':username', ':image_path'];

            $columns = implode(", ", $columnNames);
            $values = implode(", ", $columnValues);

            $statement = $conn->prepare("INSERT INTO user_image ($columns) VALUES ($values)");
            $statement->bindParam(':username', $username);
            $statement->bindParam(':image_path', $pathForDatabase);
            $statement->execute();

            $db->closeConnection();
            return true;
        }
        $db->closeConnection();
        return false;
    }
}