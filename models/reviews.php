<?php
require_once __DIR__ . '/../config/database_connection.php';
class reviews
{
    public $id;
    public $product_id;
    public $user_id;
    public $comment;
    public $rating;
    public $created_at;
    public $updated_at;

    private $pdo;

    public $data = ['product_id', 'user_id', 'comment', 'rating', 'created_at', 'updated_at'];
    public function __construct($pdo, $data)
    {
        $this->pdo = $pdo;
        $this->data = $data;
    }

    public function fetchReviews(){
        $sql = /** lang text */ "SELECT * FROM reviews ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}