<?php
require_once __DIR__ . '/../config/database_connection.php';
require_once __DIR__ . '/../models/category_model.php';

if(!isset($pdo)){
    die("Connection failed: " . mysqli_connect_error());
}
$categoryModel = new Category($pdo,[]);
$categories = $categoryModel->getCategories() ? : [];

try{
    $category = $categories;
    return $category;
}catch (PDOException $e){
    return ["error"=>true, "message"=>$e->getMessage()];
}