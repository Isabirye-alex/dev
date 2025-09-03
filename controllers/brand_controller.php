<?php
require_once __DIR__ . '/../models/brand_model.php';
require_once __DIR__ . '/../config/database_connection.php';

if(!isset($pdo)){
    die("Connection failed: " . mysqli_connect_error());
}
$brandModel = new Brand($pdo, '','');

try{
    $brands = $brandModel->getBrands();
    }catch (PDOException $e){
    return ['success'=>false,'message'=>$e->getMessage()];
}