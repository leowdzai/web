<?php
require 'init.php';
require 'includes/header.php';

if (is_login()) {
    $user = getRow("SELECT * FROM users WHERE id = " . current_user());
    $affiliate = getRow("SELECT * FROM affiliates WHERE user_id = " . current_user());
?>

<div class="page-header">
    <h1>👋 Chào mừng, <?php echo sanitize($user['name']); ?>!</h1>
</div>

<div class="grid grid-3" style="margin-bottom: 40px;">
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 32px; margin-bottom: 10px;">📋</div>
            <div class="card-title">Đơn hàng của bạn</div>
            <div class="card-price"><?php echo count_rows('orders', 'user_id = ' . current_user()); ?></div>
            <a href="/orders.php" class="btn btn-primary" style="margin-top: 10px;">Xem chi tiết</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 32px; margin-bottom: 10px;">🤝</div>
            <div class="card-title">Affiliate của bạn</div>
            <div class="card-price">₫<?php echo format_price($affiliate['available_balance'] ?? 0); ?></div>
            <a href="/affiliate.php" class="btn btn-primary" style="margin-top: 10px;">Chi tiết</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <div style="font-size: 32px; margin-bottom: 10px;">🛒</div>
            <div class="card-title">Giỏ hàng</div>
            <div class="card-price"><?php echo count(get_cart()); ?> sản phẩm</div>
            <a href="/cart.php" class="btn btn-primary" style="margin-top: 10px;">Xem giỏ</a>
        </div>
    </div>
</div>

<?php } else { ?>

<div class="page-header">
    <h1>🎉 Chào mừng đến <?php echo SITE_NAME; ?></h1>
    <p>Nền tảng bán sản phẩm số (phần mềm, hosting, digital products)</p>
</div>

<div style="text-align: center; margin: 40px 0;">
    <a href="/register.php" class="btn btn-success" style="margin-right: 10px; padding: 15px 30px; font-size: 16px;">📝 Đăng ký</a>
    <a href="/login.php" class="btn btn-primary" style="padding: 15px 30px; font-size: 16px;">🔑 Đăng nhập</a>
</div>

<?php } ?>

<h2 style="margin: 40px 0 20px 0;">📦 Sản phẩm nổi bật</h2>

<?php
$featured = getAll("SELECT * FROM products WHERE is_active = 1 ORDER BY views DESC LIMIT 8");
?>

<div class="grid grid-4">
    <?php foreach ($featured as $p): ?>
    <div class="card">
        <?php if ($p['image']): ?>
            <img src="<?php echo $p['image']; ?>" class="card-image" alt="<?php echo sanitize($p['name']); ?>">
        <?php else: ?>
            <div class="card-image" style="display: flex; align-items: center; justify-content: center; background: #e0e0e0;">📦</div>
        <?php endif; ?>
        <div class="card-body">
            <div class="card-title"><?php echo sanitize($p['name']); ?></div>
            <div class="card-price">₫<?php echo format_price($p['price']); ?></div>
            <div class="card-footer">
                <button class="btn btn-primary" onclick="addToCart(<?php echo $p['id']; ?>)" style="flex: 1;">🛒 Thêm</button>
                <a href="/product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary" style="flex: 1; margin-left: 10px;">👁️ Xem</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require 'includes/footer.php'; ?>
<script src="/js/main.js"></script>
