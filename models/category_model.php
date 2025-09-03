<?php
require_once __DIR__ . '/../config/database_connection.php';
class Category {
    public $category_id;
    public $category_name;
    public $category_description;
    public $category_image_url;
    private $pdo;

    public function __construct($pdo, $data = []) {
        $this->pdo = $pdo;
            }

    public function addCategory() {
        $requiredFields = array('category_name', 'category_description');
        foreach($requiredFields as $field){
            if(empty($_POST[$field])){
                return [
                    'status' => 'error',
                    'message' => $field.' is required',
                    'id'=>null
                ];
            }
        }
        $fields = ['category_name', 'category_description', 'category_image_url'];
        $columns = implode(', ', array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));
        $sql = "INSERT INTO categories ({$columns}) VALUES ({$placeholders})";
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($fields);
            $this->category_id = $this->pdo->lastInsertId();
        }catch(PDOException $e){
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'id'=>null
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Category added successfully',
            'id' => $this->category_id
        ];
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }
}
