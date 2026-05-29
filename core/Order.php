<?php

class Order {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function create($items, $total, $paymentMethod) {
        $userId = Auth::userId();
        $orderNumber = 'ORD-' . date('YmdHis') . '-' . rand(1000, 9999);
        $total = (float)$total;
        
        $sql = "INSERT INTO orders (user_id, order_number, total_amount, final_amount, payment_method, payment_status) 
                VALUES ($userId, '$orderNumber', $total, $total, '$paymentMethod', 'pending')";
        
        if ($this->db->query($sql)) {
            $orderId = $this->db->getConnection()->insert_id;
            
            // Add items
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
        return $result->fetch_assoc();
    }
    
    public function getByUserId($userId) {
        $userId = (int)$userId;
        $result = $this->db->query("SELECT * FROM orders WHERE user_id = $userId ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function updatePaymentStatus($orderId, $status, $transactionId) {
        $orderId = (int)$orderId;
        $status = $this->db->escape($status);
        $transactionId = $this->db->escape($transactionId);
        
        return $this->db->query("UPDATE orders SET payment_status = '$status', transaction_id = '$transactionId' WHERE id = $orderId");
    }
}
