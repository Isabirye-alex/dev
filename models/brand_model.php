<?php

require_once __DIR__ . '/../config/database_connection.php';

class Brand {
    public $id;
    public $name;
    private $pdo;

    public function __construct($pdo,$id, $name)
    {
        $this->pdo=$pdo;
        $this->id=$id;
        $this->name=$name;
    }

    public function addBrand():array
    {
        $requiredFields = ['name'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                return ['success'=>false,'message'=> 'Brand' . $field . 'is required'];
            }
        }
        $fields = ['name'];
        $columns = implode(',', array_keys($fields));
        $placeholders = ': ' . implode(', :', array_keys($fields));
        $sql = /** land text */ "INSERT INTO brands ({$columns}) VALUES ({$placeholders})";

        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($fields);
            $this->pdo->commit();
            return ['success'=>true,'message'=> 'Brand added successfully'];
        }catch (PDOException $e){
            $this->pdo->rollBack();
            return ['success'=>false,'message'=> 'Database Error: ' . $e->getMessage(), 'id'=>null];
        }

    }

    public function getBrands():array {
        $sql =  "SELECT * FROM brands";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $brands;
        } catch (PDOException $e) {
            return ['success'=>false,'message'=> 'Database Error: ' . $e->getMessage(), 'id'=>null];
        }
    }
}
