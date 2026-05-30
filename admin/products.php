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
$products = $db->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 30px; }
        .btn { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #764ba2; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
        tr:hover { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Quản Lý Sản Phẩm</h1>
            <a href="dashboard.php" class="btn">← Quay Lại</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá</th>
                    <th>Kho</th>
                    <th>Status</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>₫<?= number_format($p['price'], 0, ',', '.') ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td><?= $p['is_active'] ? '✅ Active' : '❌ Inactive' ?></td>
                    <td>
                        <button class="btn" onclick="alert('Edit: ' + <?= $p['id'] ?>)">Sửa</button>
                        <button class="btn btn-danger" onclick="if(confirm('Xóa?')) alert('Deleted')">Xóa</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
