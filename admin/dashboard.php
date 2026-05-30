<?php
require '../init.php';
require_admin();

if (!is_admin()) {
    header('Location: /admin/login.php');
    exit;
}

$users_count = count_rows('users');
$products_count = count_rows('products', 'is_active = 1');
$orders_count = count_rows('orders', 'payment_status = "paid"');
$revenue = getRow("SELECT SUM(total_amount) as total FROM orders WHERE payment_status = 'paid'");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-card .number {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
        }
        .admin-menu {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>📊 Admin Dashboard</h1>
            <a href="/logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="admin-grid">
            <div class="stat-card">
                <div style="font-size: 28px;">👥</div>
                <div class="number"><?php echo $users_count; ?></div>
                <div>Users</div>
            </div>
            <div class="stat-card">
                <div style="font-size: 28px;">📦</div>
                <div class="number"><?php echo $products_count; ?></div>
                <div>Sản phẩm</div>
            </div>
            <div class="stat-card">
                <div style="font-size: 28px;">📋</div>
                <div class="number"><?php echo $orders_count; ?></div>
                <div>Đơn hàng</div>
            </div>
            <div class="stat-card">
                <div style="font-size: 28px;">💰</div>
                <div class="number">₫<?php echo format_price($revenue['total'] ?? 0); ?></div>
                <div>Doanh thu</div>
            </div>
        </div>

        <div class="admin-menu">
            <a href="/admin/products.php" class="btn btn-primary">📦 Sản phẩm</a>
            <a href="/admin/orders.php" class="btn btn-primary">📋 Đơn hàng</a>
            <a href="/admin/users.php" class="btn btn-primary">👥 Users</a>
            <a href="/admin/affiliates.php" class="btn btn-primary">🤝 Affiliate</a>
        </div>
    </div>
</body>
</html>
