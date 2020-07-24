<?php
class Order
{
    private $conn;
    private $table = 'orders';

    public $id;
    public $order_number;
    public $product_id;
    public $user_id;
    public $product_cost;
    public $quantity;
    public $address_id;
    public $order_time;
    public $order_status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addOrder() {
        $query = 'INSERT INTO ' . $this->table . ' 
                    SET
                        order_number = :order_number,
                        product_id = :product_id,
                        user_id = :user_id,
                        product_cost = :product_cost,
                        quantity = :quantity,
                        address_id = :address_id,
                        order_time = CURRENT_TIMESTAMP(),
                        order_status = :order_status';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_number", $this->order_number);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":product_cost", $this->product_cost);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":address_id", $this->address_id);
        $stmt->bindParam(":order_status", $this->order_status);
        try {
            if($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            printf('Exception: %s.\n', $e);
            return false;
        }
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

    public function viewPurchaseHistory()
    {
        $query = 'SELECT * FROM ' . $this->table . ' 
                    WHERE 
                        user_id = :user_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $_SESSION['id']);
        $stmt->execute();
        return $stmt;
    }

    public function viewParticularPurchaseHistory()
    {
        $query = 'SELECT * FROM ' . $this->table . ' 
                    WHERE 
                        id = :id 
                        AND user_id = :user_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        return $stmt;
    }
}
?>