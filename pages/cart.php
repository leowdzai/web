<?php
require '../init.php';
start_session();

if (!is_login()) {
    header('Location: /login.php');
    exit;
}

$user_id = current_user();
$cart = get_cart();
$total = get_cart_total();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🛒 Giỏ hàng - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php require '../includes/header.php'; ?>

    <div class="page-header">
        <h1>🛒 Giỏ hàng</h1>
    </div>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info">Giỏ hàng của bạn trống. <a href="/products.php">Tiếp tục mua sắm →</a></div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $product_id => $qty): 
                    $product = getRow("SELECT * FROM products WHERE id = $product_id");
                    if ($product):
                ?>
                <tr>
                    <td><?php echo sanitize($product['name']); ?></td>
                    <td>₫<?php echo format_price($product['price']); ?></td>
                    <td><?php echo $qty; ?></td>
                    <td>₫<?php echo format_price($product['price'] * $qty); ?></td>
                    <td><button class="btn btn-danger" onclick="removeFromCart(<?php echo $product_id; ?>)">Xóa</button></td>
                </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 30px; font-size: 18px;">
            <strong>Tổng cộng: ₫<?php echo format_price($total); ?></strong>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="/products.php" class="btn btn-primary">← Tiếp tục mua sắm</a>
            <a href="/checkout.php" class="btn btn-success">Thanh toán →</a>
        </div>
    <?php endif; ?>

    <?php require '../includes/footer.php'; ?>
    <script src="/js/main.js"></script>
</body>
</html>
