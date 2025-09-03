<?php
require_once  __DIR__ . '/../config/database_connection.php';

class User{
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

    public function __construct($pdo,$id,$firstname,$lastname,$email,$password,$role,$status,$created_at,$updated_at,$usertype){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->usertype = $usertype;

    }
    public function registerUser():array{
        $requiredFields = ['firstname', 'lastname', 'email', 'role', 'password'];
        foreach ($requiredFields as $field) {
            if(empty($_POST[$field])){
                return [
                    'status'=>'error',
                    'message'=>'Required field '.$field.' is empty',
                    'id'=>null
                ];
            }
        }
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            return [
                'status'=>'error',
                'message'=>'Invalid email format',
                'id'=>null
            ];
        }

        if(strlen($_POST["password"]) < 8){
            return [
                'status'=>'error',
                'message'=>'Password should be at least 8 characters',
                'id'=>null
            ];
        }
        $fields = ['firstname', 'lastname', 'email', 'password'];
        $columns = implode(',', array_keys($fields));
        $placeholders = ':'.implode(',:', array_keys($fields));
        $sql = /** lang text */
        "
        INSERT INTO users($columns) VALUES($placeholders) ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($fields);
        return [
            'status'=>'success',
            'message'=>'User registered successfully',
            'id'=>$this->pdo->lastInsertId()
        ];
    }

    public function loginUser(){
        $requiredFields = ['email', 'password'];
        foreach ($requiredFields as $field) {
            if(empty($_POST[$field])){
                return [
                    'status'=>'error',
                    'message'=>'Required field '.$field.' is empty',
                    'id'=>null
                ];
            }
        }
        $fields = ['email', 'password'];
        $columns = implode(',', array_keys($fields));
        $placeholders = ':'.implode(',:', array_keys($fields));

    }

    public function fetchUsers()
    {
        $sql = /** lang text */ "SELECT * FROM users";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
