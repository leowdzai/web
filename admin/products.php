<?php
require '../init.php';
require_admin();

$products = getAll("SELECT * FROM products ORDER BY created_at DESC LIMIT 50");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sản phẩm</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container" style="margin-top: 40px;">
        <h1>📦 Quản lý Sản phẩm</h1>
        <a href="/admin/product-add.php" class="btn btn-success">➕ Thêm sản phẩm</a>

        <table style="margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Lượt xem</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo sanitize($p['name']); ?></td>
                    <td>₫<?php echo format_price($p['price']); ?></td>
                    <td><?php echo $p['views']; ?></td>
                    <td>
                        <a href="/admin/product-edit.php?id=<?php echo $p['id']; ?>" class="btn btn-primary">Sửa</a>
                        <a href="/admin/product-delete.php?id=<?php echo $p['id']; ?>" class="btn btn-danger" onclick="return confirm('Xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
