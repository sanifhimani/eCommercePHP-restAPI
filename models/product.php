<?php
class Product
{
    private $conn;
    private $table = 'product';

    public $id;
    public $category_id;
    public $product_name;
    public $product_description;
    public $product_image;
    public $cost;
    public $quantity_available;
    public $keywords;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProducts()
    {
        $query = 'SELECT 
                    id, 
                    product_name, 
                    product_image, 
                    cost, 
                    quantity_available
                    FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getSingleProduct()
    {
        $query = 'SELECT 
                    id, 
                    product_name, 
                    product_description, 
                    product_image, 
                    cost, 
                    quantity_available
                    FROM ' . $this->table . ' 
                        WHERE 
                            id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function getAvailableQuantity()
    {
        $query = 'SELECT 
                    quantity_available 
                    FROM ' . $this->table . ' 
                        WHERE 
                            id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function changeAvailableQuantity() 
    {
        $query = 'UPDATE ' . $this->table . ' 
                        SET
                            quantity_available = :quantity_available
                            WHERE 
                                id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quantity_available', $this->quantity_available);
        $stmt->execute();
        return $stmt;
    }

    public function getProductCost() {
        $query = 'SELECT 
                    cost 
                    FROM ' . $this->table . ' 
                        WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }
}
?>