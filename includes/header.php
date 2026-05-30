<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand"><?php echo SITE_NAME; ?></div>
            <div class="navbar-menu">
                <a href="/" class="nav-link">🏠 Trang chủ</a>
                <a href="/products.php" class="nav-link">📦 Sản phẩm</a>
                <?php if (is_login()): ?>
                    <a href="/affiliate.php" class="nav-link">🤝 Affiliate</a>
                    <a href="/orders.php" class="nav-link">📋 Đơn hàng</a>
                    <a href="/profile.php" class="nav-link">👤 <?php echo sanitize($_SESSION['user_name']); ?></a>
                    <a href="/logout.php" class="nav-link">🚪 Logout</a>
                <?php else: ?>
                    <a href="/login.php" class="nav-link">🔑 Login</a>
                    <a href="/register.php" class="nav-link">📝 Register</a>
                <?php endif; ?>
                <a href="/cart.php" class="nav-link nav-cart">🛒 <span class="cart-count"><?php echo count(get_cart()); ?></span></a>
            </div>
        </div>
    </nav>

    <div class="container">
