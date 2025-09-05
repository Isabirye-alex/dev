<?php
require_once __DIR__ . '/../config/database_connection.php';
require_once __DIR__ . '/../models/roles.php';

if (!isset($pdo)) {
    die('Connection failed: ' . mysqli_connect_error());
}

$rolesModel = new Roles($pdo);

try {
    $roles = $rolesModel->getRoles();
} catch (PDOException $e) {
    die('Error fetching roles: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    try {
        $newRole = $rolesModel->addRole(['name' => $name]);
        if ($newRole['status']) {
            echo "<p style='color:green'>{$newRole['message']}</p>";
        } else {
            echo "<p style='color:red'>{$newRole['message']}</p>";
        }
    } catch (PDOException $e) {
        die('Error adding role: ' . $e->getMessage());
    }
}
