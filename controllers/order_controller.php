<?php
require_once __DIR__ . '/../config/database_connection.php';
require_once __DIR__ . '/../models/order_model.php';

// Validate PDO connection
if (!isset($pdo) || !$pdo instanceof PDO) {
    die("Connection failed: Invalid PDO instance.");
}

// Instantiate the Order model
$orderModel = new Order($pdo,'','','','','','','','','','');

// Fetch orders
try {
    $orders = $orderModel->getOrders();
} catch (Exception $e) {

    die("Error fetching orders: " . $e->getMessage());
}

// Return data
$orderData = json_encode($orders);
$orderNumber = $orderModel->getTotalOrders();
