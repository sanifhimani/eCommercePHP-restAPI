<?php
class Address
{
    private $conn;
    private $table = 'address';

    public $id;
    public $flat_number;
    public $street_number;
    public $street_name;
    public $city;
    public $province;
    public $postal_code;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAddressDetails()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function addressExists()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        LOWER(flat_number) = :flat_number 
                        AND LOWER(street_number) = :street_number 
                        AND LOWER(street_name) = :street_name 
                        AND LOWER(city) = :city 
                        AND LOWER(province) = :province 
                        AND LOWER(postal_code) = :postal_code";
        $stmt = $this->conn->prepare($query);
        $this->flat_number = strtolower(htmlspecialchars(strip_tags($this->flat_number)));
        $this->street_number = strtolower(htmlspecialchars(strip_tags($this->street_number)));
        $this->street_name = strtolower(htmlspecialchars(strip_tags($this->street_name)));
        $this->city = strtolower(htmlspecialchars(strip_tags($this->city)));
        $this->province = strtolower(htmlspecialchars(strip_tags($this->province)));
        $this->postal_code = strtolower(htmlspecialchars(strip_tags($this->postal_code)));
        $stmt->bindParam(":flat_number", $this->flat_number);
        $stmt->bindParam(":street_number", $this->street_number);
        $stmt->bindParam(":street_name", $this->street_name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":postal_code", $this->postal_code);
        $stmt->execute();
        return $stmt;
    }

    public function addAddressToDatabase()
    {
        $query = "INSERT INTO " . $this->table . " 
                    SET 
                        flat_number = :flat_number, 
                        street_number = :street_number, 
                        street_name = :street_name, 
                        city = :city, 
                        province = :province, 
                        postal_code = :postal_code";
        $stmt = $this->conn->prepare($query);
        $this->flat_number = strtoupper(htmlspecialchars(strip_tags($this->flat_number)));
        $this->street_number = htmlspecialchars(strip_tags($this->street_number));
        $this->street_name = ucwords(htmlspecialchars(strip_tags($this->street_name)));
        $this->city = ucfirst(htmlspecialchars(strip_tags($this->city)));
        $this->province = ucfirst(htmlspecialchars(strip_tags($this->province)));
        $this->postal_code = strtoupper(htmlspecialchars(strip_tags($this->postal_code)));
        $stmt->bindParam(":flat_number", $this->flat_number);
        $stmt->bindParam(":street_number", $this->street_number);
        $stmt->bindParam(":street_name", $this->street_name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":postal_code", $this->postal_code);
        try {
            if ($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $e) {
            printf('Exception: %s.\n', $e);
            return 0;
        }
        printf('Error: %s.\n', $stmt->error);
        return 0;
    }

    public function checkAddressById()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }
}
?>