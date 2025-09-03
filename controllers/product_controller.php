<?php
require_once __DIR__ . '/../models/product_model.php';
require_once __DIR__ . '/../config/database_connection.php';

// Ensure PDO is available
if (!isset($pdo) || !$pdo instanceof PDO) {
    die("Database connection not found.");
}

$productModel = new Product($pdo, []);

// Handle add product form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['add_product'])) {
    try {
        // Map form fields to model
        $productModel->product_name             = $_POST['product_name'] ?? '';
        $productModel->product_selling_price    = $_POST['product_selling_price'] ?? 0;
        $productModel->product_stock_price      = $_POST['product_stock_price'] ?? 0;
        $productModel->product_discounted_price = $_POST['product_discounted_price'] ?? null;
        $productModel->product_stock            = $_POST['product_stock'] ?? 0;
        $productModel->product_status           = $_POST['product_status'] ?? 1;
        $productModel->product_description      = $_POST['product_description'] ?? '';
        $productModel->product_category_id      = $_POST['product_category_id'] ?? null;
        $productModel->product_brand_id         = $_POST['product_brand_id'] ?? null;
        $productModel->percentage_discount      = $_POST['percentage_discount'] ?? 0;

        // Handle file upload if exists
        if (isset($_FILES['product_image_url']) && $_FILES['product_image_url']['error'] === 0) {
            $targetDir = __DIR__ . '/../uploads/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $filename = uniqid() . '_' . basename($_FILES['product_image_url']['name']);
            $targetPath = $targetDir . $filename;

            if (move_uploaded_file($_FILES['product_image_url']['tmp_name'], $targetPath)) {
                $productModel->product_image_url = '/uploads/' . $filename;
            }
        }

        // Handle dynamic tags mapping from checkboxes
        $productModel->tags = [];
        if (!empty($_POST['tags']) && is_array($_POST['tags'])) {
            // tags[] checkboxes return an array of tag IDs
            $productModel->tags = array_map('intval', $_POST['tags']);
        }

        // Save the product
        $new_product = $productModel->addProduct();

        if ($new_product['status'] === 'success') {
            echo "<div class='alert alert-success'> Product added with ID: {$new_product['id']}</div>";
        } else {
            echo "<div class='alert alert-danger'> Error: {$new_product['message']}</div>";
        }

//        header("Location: /views/all-products.php");

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Database Error: {$e->getMessage()}</div>";
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>General Error: {$e->getMessage()}</div>";
    }
}

// Fetch existing products
try {
    $products = $productModel->getProducts() ?: [];
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
