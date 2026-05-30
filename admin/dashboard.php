<?php
session_start();
require_once '../config.php';
require_once '../core/Auth.php';
require_once '../core/Database.php';

if (!Auth::isAdmin()) {
    header('Location: login.php');
    exit;
}

$db = new Database();

$users = $db->query("SELECT COUNT(*) as count FROM users")->fetch_assoc();
$products = $db->query("SELECT COUNT(*) as count FROM products WHERE is_active = 1")->fetch_assoc();
$orders = $db->query("SELECT COUNT(*) as count FROM orders WHERE payment_status = 'paid'")->fetch_assoc();
$revenue = $db->query("SELECT SUM(final_amount) as total FROM orders WHERE payment_status = 'paid'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 28px; }
        .logout { background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; }
        .logout:hover { background: #c82333; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { font-size: 14px; color: #999; margin-bottom: 10px; text-transform: uppercase; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #667eea; }
        .menu { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .menu a { display: inline-block; margin-right: 15px; margin-bottom: 10px; padding: 10px 15px; background: #667eea; color: white; text-decoration: none; border-radius: 4px; }
        .menu a:hover { background: #764ba2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>📊 Admin Dashboard</h1>
                <p>Chào mừng, <?= htmlspecialchars($_SESSION['user_name']) ?></p>
            </div>
            <form method="POST" style="margin: 0;">
                <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
            </form>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3>👥 Tổng User</h3>
                <div class="number"><?= $users['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>📦 Sản Phẩm</h3>
                <div class="number"><?= $products['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>📋 Đơn Hàng</h3>
                <div class="number"><?= $orders['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>💰 Doanh Thu</h3>
                <div class="number">₫<?= number_format($revenue['total'] ?? 0, 0, ',', '.') ?></div>
            </div>
        </div>
        
        <div class="menu">
            <a href="products.php">📦 Quản Lý Sản Phẩm</a>
            <a href="orders.php">📋 Quản Lý Đơn Hàng</a>
            <a href="users.php">👥 Quản Lý Users</a>
            <a href="affiliates.php">🤝 Quản Lý Affiliate</a>
            <a href="withdrawals.php">💳 Duyệt Rút Tiền</a>
        </div>
    </div>
</body>
</html>
