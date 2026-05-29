<?php
session_start();
require_once '../core/Database.php';
require_once '../core/Auth.php';

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
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: #333; color: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .logout { background: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .logout:hover { background: #c82333; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stat-card h3 { font-size: 14px; color: #666; margin-bottom: 10px; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #007bff; }
        .menu { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .menu a { display: inline-block; margin-right: 15px; color: #007bff; text-decoration: none; }
        .menu a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <button class="logout" onclick="logout()">Logout</button>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <div class="number"><?= $users['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Products</h3>
                <div class="number"><?= $products['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Orders</h3>
                <div class="number"><?= $orders['count'] ?></div>
            </div>
            <div class="stat-card">
                <h3>Revenue</h3>
                <div class="number">₫<?= number_format($revenue['total'] ?? 0) ?></div>
            </div>
        </div>
        
        <div class="menu">
            <a href="products.php">📦 Manage Products</a>
            <a href="orders.php">📋 Orders</a>
            <a href="users.php">👥 Users</a>
            <a href="affiliates.php">🤝 Affiliates</a>
            <a href="withdrawals.php">💳 Withdrawals</a>
        </div>
    </div>
    
    <script>
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html>
