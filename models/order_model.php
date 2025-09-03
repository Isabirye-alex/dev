<?php
require_once __DIR__ . '/../config/database_connection.php';
class Order
{
    public $id;
    public $user_id;
    public $total_amount;
    public $status;
    public $payment_method;
    public $shipping_address;
    public $is_paid;
    public $created_at;
    public $updated_at;
    public $paid_at;
    private $pdo;

    public function __construct(
        $pdo,
        $id,
        $paid_at,
        $status,
        $is_paid,
        $created_at,
        $payment_method,
        $shipping_address,
        $user_id,
        $updated_at,
        $total_amount




    )
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total_amount = $total_amount;
        $this->status = $status;
        $this->payment_method = $payment_method;
        $this->shipping_address = $shipping_address;
        $this->is_paid = $is_paid;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->paid_at = $paid_at;

    }

    public function getOrders(){
        $sql = "SELECT * FROM orders";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addOrder(){}
    public function getOrdersByStatus() {
        $sql = "SELECT status, COUNT(*) as count 
                FROM orders 
                GROUP BY status";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2️⃣ Get orders grouped by day
    public function getOrdersByDay() {
        $sql = "SELECT DATE(created_at) as order_date, COUNT(*) as count 
                FROM orders 
                GROUP BY DATE(created_at) 
                ORDER BY order_date ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalOrders() {
        $sql = "SELECT COUNT(*) as count FROM orders";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC); // returns ['count' => 12]
    }

}

