<?php
require_once __DIR__ . '/../../models/user_model.php';
require_once __DIR__ . '/../../config/database_connection.php';

if (!isset($pdo)) {
    die('Connection failed: ' . mysqli_connect_error());
}

$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $userModel->registerUser();

    if ($result['status'] == 'success') {
        //Redirect to Log in page upon successful registration
        header('Location: ../login/login.php');
        exit;
    } else {
        $error = $result['message'];
    }
}