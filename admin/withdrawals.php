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
$withdrawals = $db->query("SELECT w.*, u.email FROM affiliate_withdrawals w JOIN affiliates a ON w.affiliate_id = a.id JOIN users u ON a.user_id = u.id ORDER BY w.created_at DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyệt Rút Tiền</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 30px; }
        .btn { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #764ba2; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💳 Duyệt Rút Tiền</h1>
            <a href="dashboard.php" class="btn">← Quay Lại</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Số Tiền</th>
                    <th>Số TK</th>
                    <th>Status</th>
                    <th>Ngày</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($withdrawals as $w): ?>
                <tr>
                    <td><?= htmlspecialchars($w['email']) ?></td>
                    <td><strong>₫<?= number_format($w['amount'], 0, ',', '.') ?></strong></td>
                    <td><?= htmlspecialchars($w['bank_account']) ?></td>
                    <td><?= ucfirst($w['status']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($w['created_at'])) ?></td>
                    <td>
                        <?php if ($w['status'] === 'pending'): ?>
                            <button class="btn btn-success" onclick="alert('Approved: ' + <?= $w['id'] ?>)">Duyệt</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
