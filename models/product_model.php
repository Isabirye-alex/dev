<?php
/** @noinspection ALL */
require_once __DIR__ . '/../config/database_connection.php';

class Product {
    public $id;
    public $product_name;
    public $product_selling_price;
    public $product_stock_price;
    public $product_discounted_price;
    public $product_image_url;
    public $product_stock;
    public $product_status;
    public $product_description;
    public $product_category_id;
    public $product_brand_id;
    public $product_creation_date;
    public $product_update_date;
    public $product_delete_date;
    public $percentage_discount;

    // Tags as an array of IDs
    public $tags = [];  // e.g. [1, 3, 5]

    private $pdo;

    public function __construct($pdo, $data = []) {
        $this->pdo = $pdo;
    }

    public function addProduct():array {
        $requiredFields = [
            'product_name',
            'product_selling_price',
            'product_stock_price',
            'product_image_url',
            'product_description',
            'product_category_id',
            'product_brand_id',
            'product_stock'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return [
                    'status' => 'error',
                    'message' => "The field {$field} is required",
                    'id' => null
                ];
            }
        }

        try {
            // Begin transaction
            $this->pdo->beginTransaction();
            // Insert into products
            $productFields = [
                'name' => $this->product_name,
                'description' => $this->product_description,
                'category_id' => $this->product_category_id,
                'brand_id' => $this->product_brand_id,
                'stock_price' => $this->product_stock_price,
                'stock' => $this->product_stock,
            ];
            $columns = implode(', ', array_keys($productFields));
            $placeholders = ':' . implode(', :', array_keys($productFields));
            $sql = "INSERT INTO new_products ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($productFields);
            $this->id = $this->pdo->lastInsertId();

            // Insert into product_prices
            $priceFields = [
                'product_id' => $this->id,
                'actual_sale_price' => $this->product_selling_price,
                'selling_price' => $this->product_discounted_price,
            ];
            $columns = implode(', ', array_keys($priceFields));
            $placeholders = ':' . implode(', :', array_keys($priceFields));
            $sql = "INSERT INTO product_prices ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($priceFields);

            // Insert into product_images
            $imageFields = [
                'product_id' => $this->id,
                'image_url' => $this->product_image_url,
            ];
            $columns = implode(', ', array_keys($imageFields));
            $placeholders = ':' . implode(', :', array_keys($imageFields));
            $sql = "INSERT INTO product_images ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($imageFields);

            // Insert into product_tag_map using implode
            if (!empty($this->tags)) {
                $placeholdersArr = [];
                $values = [];
                foreach ($this->tags as $tagId) {
                    $placeholdersArr[] = "(?, ?)";
                    $values[] = $this->id;   // product_id
                    $values[] = $tagId;      // tag_id
                }
                $placeholdersStr = implode(', ', $placeholdersArr);
                $sql = "INSERT INTO product_tag_map (product_id, tag_id) VALUES {$placeholdersStr}";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($values);
            }

            // Commit transaction
            $this->pdo->commit();

            return [
                'status' => 'success',
                'message' => 'Product added successfully',
                'id' => $this->id
            ];

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'id' => null
            ];
        }
    }

    public function getProducts() {
        $sql = "/** lang text */ 
            SELECT 
                p.*,
                ANY_VALUE(pp.selling_price) AS product_price, 
                ANY_VALUE(pp.percentage_discount) AS product_discount, 
                ANY_VALUE(pp.selling_price) AS product_discounted_price,
                ANY_VALUE(pp.start_date) AS product_price_start_date,
                ANY_VALUE(pp.end_date) AS product_price_end_date,
                ANY_VALUE(pi.image_url) AS product_image_url,
                GROUP_CONCAT(pt.tag_name) AS product_tags
            FROM new_products p
            JOIN product_prices pp ON pp.product_id = p.id
            JOIN product_images pi ON pi.product_id = p.id
            LEFT JOIN product_tag_map ptm ON ptm.product_id = p.id
            LEFT JOIN product_tags pt ON pt.id = ptm.tag_id
            GROUP BY p.id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
