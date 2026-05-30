<?php

function start_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function login($email, $password) {
    $user = getRow("SELECT * FROM users WHERE email = '" . escape($email) . "' LIMIT 1");
    
    if ($user && password_verify($password, $user['password'])) {
        start_session();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    return false;
}

function register($email, $name, $password) {
    // Kiểm tra email đã tồn tại
    if (getRow("SELECT id FROM users WHERE email = '" . escape($email) . "'")) {
        return false;
    }
    
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $user_id = insert('users', [
        'email' => $email,
        'name' => $name,
        'password' => $hash,
        'role' => 'user'
    ]);
    
    if ($user_id) {
        // Tạo affiliate account
        $code = 'REF' . strtoupper(substr(md5(microtime()), 0, 8));
        insert('affiliates', [
            'user_id' => $user_id,
            'referral_code' => $code,
            'commission_rate' => COMMISSION_RATE
        ]);
        return $user_id;
    }
    return false;
}

function is_login() {
    start_session();
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return is_login() && $_SESSION['user_role'] === 'admin';
}

function current_user() {
    return $_SESSION['user_id'] ?? null;
}

function logout() {
    start_session();
    session_destroy();
}

function require_login() {
    if (!is_login()) {
        header('Location: /login.php');
        exit;
    }
}

function require_admin() {
    if (!is_admin()) {
        header('Location: /admin/login.php');
        exit;
    }
}

?>
