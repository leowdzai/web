<?php
require '../init.php';

if (is_login()) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (login($email, $password)) {
        header('Location: /index.php');
        exit;
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
    <title>🔑 Đăng nhập - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .login-container h1 { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>🔑 Đăng nhập</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
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
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Chưa có tài khoản? <a href="/register.php">Đăng ký ngay</a>
        </p>
    </div>
</body>
</html>
