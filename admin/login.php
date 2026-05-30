<?php
session_start();
require_once '../config.php';
require_once '../core/Auth.php';

if (Auth::isLogin()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (Auth::login($email, $password)) {
        if ($_SESSION['user_role'] === 'admin') {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = '❌ Chỉ admin mới có quyền truy cập';
            session_destroy();
        }
    } else {
        $error = '❌ Email hoặc password không đúng';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); width: 100%; max-width: 400px; margin: 20px; }
        h1 { margin-bottom: 30px; text-align: center; color: #333; font-size: 28px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 6px; font-size: 14px; }
        input:focus { outline: none; border-color: #667eea; }
        button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: 600; }
        button:hover { background: #764ba2; }
        .error { color: #721c24; margin-bottom: 20px; padding: 12px; background: #f8d7da; border-radius: 6px; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>🔐 Admin Login</h1>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Đăng Nhập</button>
        </form>
    </div>
</body>
</html>
