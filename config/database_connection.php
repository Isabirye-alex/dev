<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "root";
$dbname = "my-admin";
$port = "3308";

$dsn = "mysql:host=$host;dbname=$dbname";
try{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
}catch (PDOException $e){
//    die("Connection failed: " . $e->getMessage());
    echo "Connection failed: " . $e->getMessage();
}

