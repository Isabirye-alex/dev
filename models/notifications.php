<?php
require_once __DIR__ . '/../config/database_connection.php';

class Notifications
{
    public $id;
    public $user_id;
    public $title;
    public $message;
    public $is_read;
    public $imageUrl;
    public $created_at;

    private $pdo;
    private $data;

    public function __construct($pdo, $data = [])
    {
        $this->pdo = $pdo;
        $this->data = $data;
    }

    /**
     * Send a new notification
     */
    public function sendNotification()
    {
        $requiredFields = ['user_id', 'title', 'message'];
        foreach ($requiredFields as $field) {
            if (!isset($this->data[$field]) || $this->data[$field] === '') {
                return [
                    'status' => false,
                    'message' => $field . ' is required',
                    'id' => null
                ];
            }
        }

        $sql = "INSERT INTO notifications (user_id, title, message, is_read, imageUrl) 
                VALUES (:user_id, :title, :message, :is_read, :imageUrl)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $this->data['user_id'],
                ':title'   => $this->data['title'],
                ':message' => $this->data['message'],
                ':is_read' => $this->data['is_read'] ?? 0,
                ':imageUrl'=> $this->data['imageUrl'] ?? null
            ]);
            $this->id = $this->pdo->lastInsertId();

            return [
                'status' => true,
                'message' => "Notification sent successfully",
                'id' => $this->id
            ];
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
                'id' => null
            ];
        }
    }

    /**
      Get notifications by user
     */
    public function getNotificationsByUser($userId, $unreadOnly = false)
    {
        $sql = "SELECT * FROM notifications WHERE user_id = :user_id";
        if ($unreadOnly) $sql .= " AND is_read = 0";
        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mark a single notification as read
     */
    public function markAsRead($notificationId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $notificationId]);
    }

    /**
      Mark all notifications as read for a user
     */
    public function markAllAsRead($userId)
    {
        $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':user_id' => $userId]);
    }
}
