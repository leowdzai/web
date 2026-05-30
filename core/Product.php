<?php

require_once 'Database.php';

class Product {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll($limit = 15, $offset = 0) {
        $result = $this->db->query("SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function getById($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM products WHERE id = $id AND is_active = 1");
        return $result ? $result->fetch_assoc() : null;
    }
    
    public function getByCategory($categoryId, $limit = 15, $offset = 0) {
        $categoryId = (int)$categoryId;
        $result = $this->db->query("SELECT * FROM products WHERE category_id = $categoryId AND is_active = 1 ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function search($keyword, $limit = 15, $offset = 0) {
        $keyword = $this->db->escape('%' . $keyword . '%');
        $result = $this->db->query("SELECT * FROM products WHERE (name LIKE '$keyword' OR description LIKE '$keyword') AND is_active = 1 LIMIT $limit OFFSET $offset");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    public function create($data) {
        $name = $this->db->escape($data['name']);
        $description = $this->db->escape($data['description'] ?? '');
        $price = (float)$data['price'];
        $stock = (int)$data['stock'];
        $category_id = (int)$data['category_id'];
        $user_id = $data['user_id'];
        $image = $this->db->escape($data['image'] ?? '');
        
        $sql = "INSERT INTO products (name, description, price, stock, category_id, user_id, image) 
                VALUES ('$name', '$description', $price, $stock, $category_id, $user_id, '$image')";
        
        return $this->db->query($sql);
    }
    
    public function update($id, $data) {
        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $description = $this->db->escape($data['description'] ?? '');
        $price = (float)$data['price'];
        $stock = (int)$data['stock'];
        
        $sql = "UPDATE products SET name = '$name', description = '$description', price = $price, stock = $stock WHERE id = $id";
        return $this->db->query($sql);
    }
    
    public function delete($id) {
        $id = (int)$id;
        return $this->db->query("DELETE FROM products WHERE id = $id");
    }
}

?>
