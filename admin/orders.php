<?php
require '../init.php';
require_admin();

$orders = getAll("SELECT o.*, u.email, u.name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 50");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Đơn hàng</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container" style="margin-top: 40px;">
        <h1>📋 Quản lý Đơn hàng</h1>

        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách</th>
                    <th>Số tiền</th>
                    <th>Thanh toán</th>
                    <th>Status</th>
                    <th>Ngày</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><?php echo $o['order_number']; ?></td>
                    <td><?php echo sanitize($o['email']); ?></td>
                    <td>₫<?php echo format_price($o['total_amount']); ?></td>
                    <td><?php echo ucfirst($o['payment_method'] ?? 'N/A'); ?></td>
                    <td><?php echo ucfirst($o['payment_status']); ?></td>
                    <td><?php echo format_date($o['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
