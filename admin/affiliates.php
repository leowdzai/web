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
$affiliates = $db->query("SELECT a.*, u.email, u.name, COUNT(ar.id) as referral_count FROM affiliates a JOIN users u ON a.user_id = u.id LEFT JOIN affiliate_referrals ar ON a.id = ar.affiliate_id GROUP BY a.id ORDER BY a.total_commission DESC LIMIT 100")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Affiliate</title>
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
            <h1>🤝 Quản Lý Affiliate</h1>
            <a href="dashboard.php" class="btn">← Quay Lại</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Referral Code</th>
                    <th>Referrals</th>
                    <th>Tổng Hoa Hồng</th>
                    <th>Số Dư</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($affiliates as $aff): ?>
                <tr>
                    <td><?= htmlspecialchars($aff['email']) ?></td>
                    <td><code><?= $aff['referral_code'] ?></code></td>
                    <td><?= $aff['referral_count'] ?></td>
                    <td>₫<?= number_format($aff['total_commission'] ?? 0, 0, ',', '.') ?></td>
                    <td>₫<?= number_format($aff['available_balance'], 0, ',', '.') ?></td>
                    <td><?= $aff['is_active'] ? '✅ Active' : '❌ Inactive' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
