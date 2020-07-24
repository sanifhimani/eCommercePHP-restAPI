<?
include_once '../../core/init.php';
class UserAddress
{
    private $conn;
    private $table = 'user_address';

    public $mapping_id;
    public $user_id;
    public $address_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getUserAddressDetails()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function checkMappingExists()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        user_id = :user_id 
                        AND address_id = :address_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":address_id", $this->address_id);
        $stmt->execute();
        return $stmt;
    }

    public function isValidMapping()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        user_id = :user_id 
                        AND mapping_id = :mapping_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":mapping_id", $this->mapping_id);
        $stmt->execute();
        return $stmt;
    }

    public function setAddressMapping()
    {
        $query = "INSERT INTO " . $this->table . " 
                    SET 
                    user_id = :user_id, 
                    address_id = :address_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":address_id", $this->address_id);
        $stmt->execute();
        return $stmt;
    }

    public function deleteAddressMapping()
    {
        $query = "DELETE FROM " . $this->table . " 
                    WHERE 
                        user_id = :user_id 
                        AND address_id = :address_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":address_id", $this->address_id);
        $stmt->execute();
        return $stmt;
    }

    public function updateAddressMapping()
    {
        $query = "UPDATE " . $this->table . " 
                    SET 
                        address_id = :address_id 
                        WHERE 
                            mapping_id = :mapping_id 
                            AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":address_id", $this->address_id);
        $stmt->bindParam(":mapping_id", $this->mapping_id);
        $stmt->bindParam(":user_id", $this->user_id);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            printf('Exception: %s.\n', $e);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }
}
?>