<?php

class Auth {
    public static function login($email, $password) {
        $db = new Database();
        $email = $db->escape($email);
        
        $result = $db->query("SELECT * FROM users WHERE email = '$email'");
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        }
        return false;
    }
    
    public static function register($email, $password, $name) {
        $db = new Database();
        $email = $db->escape($email);
        $name = $db->escape($name);
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $result = $db->query("INSERT INTO users (email, password, name, role) VALUES ('$email', '$hash', '$name', 'user')");
        
        if ($result) {
            $userId = $db->getConnection()->insert_id;
            // Create affiliate account
            $code = 'REF-' . strtoupper(substr(md5(microtime()), 0, 8));
            $db->query("INSERT INTO affiliates (user_id, referral_code, commission_rate) VALUES ($userId, '$code', 10)");
            return $userId;
        }
        return false;
    }
    
    public static function logout() {
        session_destroy();
    }
    
    public static function isLogin() {
        return isset($_SESSION['user_id']);
    }
    
    public static function isAdmin() {
        return self::isLogin() && $_SESSION['user_role'] === 'admin';
    }
    
    public static function userId() {
        return $_SESSION['user_id'] ?? null;
    }
}
