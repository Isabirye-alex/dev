<?php
require_once __DIR__ . '/../config/database_connection.php';

class User
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $role;
    public $status;
    public $created_at;
    public $updated_at;
    public $usertype;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /** ✅ Register a new user */
    public function registerUser(): array
    {
        $requiredFields = ['firstname', 'lastname', 'email', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return [
                    'status' => 'error',
                    'message' => 'Required field ' . $field . ' is empty',
                    'id' => null
                ];
            }
        }

        // Validate email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format',
                'id' => null
            ];
        }

        // Validate password length
        if (strlen($_POST["password"]) < 8) {
            return [
                'status' => 'error',
                'message' => 'Password should be at least 8 characters',
                'id' => null
            ];
        }

        // Hash password
        $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // Prepare SQL
        $sql = "INSERT INTO users (firstname, lastname, email, password, usertype, status) 
                VALUES (:firstname, :lastname, :email, :password, :role, :status)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':firstname' => $_POST['firstname'],
            ':lastname' => $_POST['lastname'],
            ':email' => $_POST['email'],
            ':password' => $hashedPassword,
            ':role' => $_POST['role'] ?? 'user',
            ':status' => 1
        ]);

        return [
            'status' => 'success',
            'message' => 'User registered successfully',
            'id' => $this->pdo->lastInsertId()
        ];
    }

    /** Login a user */
    public function loginUser(): array
    {
        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return [
                    'status' => 'error',
                    'message' => 'Required field ' . $field . ' is empty',
                    'id' => null
                ];
            }
        }

        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $_POST['email']]);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['password'])) {
            // Store session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['role'] = $user['role'];

            return [
                'status' => 'success',
                'message' => 'Login successful',
                'id' => $user['id']
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Invalid email or password',
                'id' => null
            ];
        }
    }


    public function fetchUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
