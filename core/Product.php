<?php

class Product {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll($limit = 15, $offset = 0) {
        $result = $this->db->query("SELECT * FROM products WHERE is_active = 1 LIMIT $limit OFFSET $offset");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $id = (int)$id;
        $result = $this->db->query("SELECT * FROM products WHERE id = $id");
        return $result->fetch_assoc();
    }
    
    public function create($data) {
        $name = $this->db->escape($data['name']);
        $description = $this->db->escape($data['description']);
        $price = (float)$data['price'];
        $stock = (int)$data['stock'];
        $category_id = (int)$data['category_id'];
        $user_id = Auth::userId();
        $image = $data['image'] ?? '';
        $file_path = $data['file_path'] ?? '';
        
        $sql = "INSERT INTO products (name, description, price, stock, category_id, user_id, image, file_path) 
                VALUES ('$name', '$description', $price, $stock, $category_id, $user_id, '$image', '$file_path')";
        
        return $this->db->query($sql);
    }
    
    public function update($id, $data) {
        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $price = (float)$data['price'];
        $stock = (int)$data['stock'];
        
        $sql = "UPDATE products SET name = '$name', price = $price, stock = $stock WHERE id = $id";
        return $this->db->query($sql);
    }
    
    public function delete($id) {
        $id = (int)$id;
        return $this->db->query("DELETE FROM products WHERE id = $id");
    }
}
