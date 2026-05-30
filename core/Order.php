<?php

require_once 'Database.php';

class Order {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($userId, $items, $total, $paymentMethod) {
        $userId = (int)$userId;
        $orderNumber = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);
        $total = (float)$total;
        $paymentMethod = $this->db->escape($paymentMethod);
        
        $sql = "INSERT INTO orders (user_id, order_number, total_amount, final_amount, payment_method, payment_status) 
                VALUES ($userId, '$orderNumber', $total, $total, '$paymentMethod', 'pending')";
        
        if ($this->db->query($sql)) {
            $orderId = $this->db->lastInsertId();
            
            // Thêm item vào order
            foreach ($items as $item) {
                $productId = (int)$item['product_id'];
                $qty = (int)$item['quantity'];
                $price = (float)$item['price'];
                $itemTotal = $qty * $price;
                
                $this->db->query("INSERT INTO order_items (order_id, product_id, quantity, price, total) 
                                  VALUES ($orderId, $productId, $qty, $price, $itemTotal)");
            }
            
            return $orderId;
        }
        return false;
    }
    
    public function getById($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM orders WHERE id = $id");
        return $result ? $result->fetch_assoc() : null;
    }
    
    public function getByUserId($userId, $limit = 50, $offset = 0) {
        $userId = (int)$userId;
        $result = $this->db->query("SELECT * FROM orders WHERE user_id = $userId ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function getAll($limit = 50, $offset = 0) {
        $result = $this->db->query("SELECT o.*, u.email, u.name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT $limit OFFSET $offset");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function updatePaymentStatus($orderId, $status, $transactionId = null) {
        $orderId = (int)$orderId;
        $status = $this->db->escape($status);
        
        if ($transactionId) {
            $transactionId = $this->db->escape($transactionId);
            return $this->db->query("UPDATE orders SET payment_status = '$status', transaction_id = '$transactionId' WHERE id = $orderId");
        }
        
        return $this->db->query("UPDATE orders SET payment_status = '$status' WHERE id = $orderId");
    }
}

?>
