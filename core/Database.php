<?php

class Database {
    private $conn;
    
    public function __construct() {
        $config = require __DIR__ . '/../config/database.php';
        
        try {
            $this->conn = new mysqli(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['database']
            );
            
            if ($this->conn->connect_error) {
                throw new Exception('Connection Error: ' . $this->conn->connect_error);
            }
            
            $this->conn->set_charset($config['charset']);
        } catch (Exception $e) {
            die('Database Error: ' . $e->getMessage());
        }
    }
    
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function escape($string) {
        return $this->conn->real_escape_string($string);
    }
}
