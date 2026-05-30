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
$users = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Users</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 30px; }
        .btn { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #764ba2; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👥 Quản Lý Users</h1>
            <a href="dashboard.php" class="btn">← Quay Lại</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Tên</th>
                    <th>Role</th>
                    <th>Ngày Tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                            <strong style="color: #dc3545;">🔴 Admin</strong>
                        <?php else: ?>
                            <span style="color: #28a745;">🟢 User</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
