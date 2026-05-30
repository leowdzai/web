<?php
require '../init.php';

if (is_login()) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($password !== $confirm) {
        $error = '❌ Password không khớp';
    } elseif (strlen($password) < 6) {
        $error = '❌ Password phải có ít nhất 6 ký tự';
    } elseif (register($email, $name, $password)) {
        login($email, $password);
        header('Location: /index.php');
        exit;
    } else {
        $error = '❌ Email đã tồn tại hoặc lỗi khác';
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Đăng ký - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .register-container h1 { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>📝 Đăng ký</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Tên:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Xác nhận Password:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-success btn-block">Đăng ký</button>
        </form>

        <p style="text-align: center; margin-top: 20px;">
            Đã có tài khoản? <a href="/login.php">Đăng nhập</a>
        </p>
    </div>
</body>
</html>
