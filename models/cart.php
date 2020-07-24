<?php
class Cart
{
    private $conn;
    private $table = 'cart';

    public $id;
    public $user_id;
    public $ip_address;
    public $product_id;
    public $quantity;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCart() 
    {
        $query = 'SELECT * FROM ' . $this->table . ' 
                    WHERE 
                        ip_address = :ip_address';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip_address', $this->ip_address);
        $stmt->execute();
        return $stmt;
    }

    public function getUserCart()
    {
        $query = 'SELECT * FROM ' . $this->table . ' 
                    WHERE 
                        user_id = :user_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function addProductToCart() 
    {
        $query = 'INSERT INTO ' . $this->table . '
                     SET
                        ip_address = :ip_address,
                        product_id = :product_id,
                        quantity = :quantity';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip_address', $this->ip_address);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $err) {
            printf('Exception: %s.\n', $err);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function addProductToUserCart()
    {
        $query = 'INSERT INTO ' . $this->table . '
                     SET
                        user_id = :user_id,
                        product_id = :product_id,
                        quantity = :quantity';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $err) {
            printf('Exception: %s.\n', $err);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function updateUserCart() 
    {
        $query = 'UPDATE ' . $this->table . ' 
                    SET 
                        quantity = :quantity 
                        WHERE 
                            user_id = :user_id 
                            AND product_id = :product_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->execute();
        return $stmt;
    }

    public function updateCart()
    {
        $query = 'UPDATE ' . $this->table . ' 
                    SET 
                        quantity = :quantity 
                        WHERE 
                            ip_address = :ip_address 
                            AND product_id = :product_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip_address', $this->ip_address);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->execute();
        return $stmt;
    }

    public function removeCartItem()
    {
        $query = 'DELETE FROM ' . $this->table . ' 
                    WHERE 
                        id = :id 
                        AND ip_address = :ip_address';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":ip_address", $this->ip_address);
        $stmt->execute();
        return $stmt;
    }

    public function removeUserCartItem() 
    {
        $query = 'DELETE FROM ' . $this->table . ' 
                    WHERE 
                        id = :id 
                        AND user_id = :user_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt;
    }
}
?>