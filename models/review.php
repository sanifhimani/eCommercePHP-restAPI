<?php
class Review
{
    private $conn;
    private $table = 'review';

    public $id;
    public $product_id;
    public $user_id;
    public $rating;
    public $image;
    public $comment;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllReviews()
    {
        $query = "SELECT * FROM " . $this->table . " 
                    WHERE 
                        product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
        return $stmt;
    }

    public function addReview()
    {
        $query = "INSERT INTO " . $this->table . " 
                    SET 
                        product_id = :product_id, 
                        user_id = :user_id, 
                        rating = :rating, 
                        image = :image, 
                        comment = :comment, 
                        created_at = CURRENT_TIMESTAMP()";
        $stmt = $this->conn->prepare($query);
        $this->comment = htmlspecialchars(strip_tags($this->comment));
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":comment", $this->comment);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            printf("Exception: " . $e);
            return false;
        }
        printf("Error: " . $stmt->error);
        return false;
    }
}
?>