<?php
include_once '../../core/init.php';
class User
{
    private $conn;
    private $table = 'user';

    public $id;
    public $email_address;
    public $password;
    public $first_name;
    public $last_name;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function isEmailValid()
    {
        if (filter_var($this->email_address, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function isRegistered()
    {
        $query = "SELECT id FROM " . $this->table . " 
                    WHERE 
                        email_address = :email_address 
                        AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $this->email_address = htmlspecialchars(strip_tags($this->email_address));
        $stmt->bindParam(':email_address', $this->email_address);
        $stmt->execute();
        return $stmt;
    }

    public function checkPassword($old_password)
    {
        $id = $_SESSION['id'];
        $query = "SELECT id FROM " . $this->table . " 
                    WHERE 
                        password = :password 
                        AND id = :id";
        $stmt = $this->conn->prepare($query);
        $old_password = md5(htmlspecialchars(strip_tags($old_password)));
        $stmt->bindParam(':password', $old_password);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt;
    }

    public function registerUser()
    {
        $query = 'INSERT INTO ' . $this->table . '
                    SET
                        email_address = :email_address,
                        password = :password,
                        first_name = :first_name,
                        last_name = :last_name,
                        updated_at = CURRENT_TIMESTAMP()';
        $stmt = $this->conn->prepare($query);
        $this->email_address = htmlspecialchars(strip_tags($this->email_address));
        $this->password = md5(htmlspecialchars(strip_tags($this->password)));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $stmt->bindParam(':email_address', $this->email_address);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch(Exception $e) {
            printf('Error: %s.\n', $e);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function isLoggedIn()
    {
        return (isset($_SESSION['id'])) ? true : false;
    }

    public function loginUser()
    {
        $query = "SELECT id FROM " . $this->table . " 
                    WHERE email_address = :email_address 
                    AND password = :password 
                    AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $this->email_address = htmlspecialchars(strip_tags($this->email_address));
        $this->password = md5(htmlspecialchars(strip_tags($this->password)));
        $stmt->bindParam(':email_address', $this->email_address);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();
        return $stmt;
    }

    public function getUserDetails()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function updateUserDetails()
    {
        $id = $_SESSION['id'];
        $query = "UPDATE " . $this->table . " 
                    SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        updated_at = CURRENT_TIMESTAMP() 
                            WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch(Exception $e) {
            printf('Exception: %s.\n', $e);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function updateUserPassword()
    {
        $id = $_SESSION['id'];
        $query = "UPDATE " . $this->table . " 
                    SET 
                        password = :password, 
                        updated_at = CURRENT_TIMESTAMP() 
                            WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->password = md5(htmlspecialchars(strip_tags($this->password)));
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":password", $this->password);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch(Exception $e) {
            printf('Exception: %s.\n', $e);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function deleteUser()
    {
        $id = $_SESSION['id'];
        $query = "UPDATE " . $this->table . " 
                    SET 
                        deleted_at = CURRENT_TIMESTAMP() 
                            WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch(Exception $e) {
            printf('Exception: %s.\n', $e);    
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }
}
?>