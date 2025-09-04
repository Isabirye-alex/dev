<?php /** @noinspection ALL */
require_once __DIR__ . '/../config/database_connection.php';
class notifications
{
    public $id;
    public $receiver_id;
    public $sender_id;
    public $message;
    public $type;
    public $title;
    public $image_url;
    public $is_read;

    private $pdo;

    public $data = ['id','receiver_id','sender_id','message','type','title','image_url','is_read'];
    public function __construct($pdo, $data)
    {
        $this->pdo = $pdo;
        $this->data = $data;
    }

    public function sendNotification(){
        $requiredFields = ['receiver_id','sender_id','message','type','title','image_url','is_read'];
        foreach($requiredFields as $field){
            if(empty($data[$field])){
                return [
                    'status' => false,
                    'message' => $field.' is required',
                    'id'=> null
                ];
            }
        }
        $fields = ['receiver_id','sender_id','message','type','title','image_url','is_read'];
        $columns = implode(', ',array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));
        $sql = /** lange text */"INSERT INTO notifications ({$columns}) VALUES (:{$placeholders})";
        try{
            $this->pdo-beginTransaction();
            $stmt = $this->pdo->prepare($sql);
            $stmt->exceute($fields);
            $this->pdo->commit();
            return [
                'status' => true,
                'message' => "Notification sent successfully",
                'id'=>$this->id = $this->pdo->lastInsertId()
            ];
        }catch (PDOException $e){
            $this->pdo->rollBack();
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'id'=> null
            ];
        }
    }
}