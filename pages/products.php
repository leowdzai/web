<?php
require '../init.php';

$paging = paginate($_GET['page'] ?? 1, 12);
$products = getAll("SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC LIMIT {$paging['limit']} OFFSET {$paging['offset']}");
$total = count_rows('products', 'is_active = 1');
$pages = ceil($total / $paging['limit']);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📦 Sản phẩm - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php require '../includes/header.php'; ?>

    <div class="page-header">
        <h1>📦 Sản phẩm</h1>
        <p><?php echo $total; ?> sản phẩm đang có sẵn</p>
    </div>

    <div class="grid grid-4">
        <?php foreach ($products as $p): ?>
        <div class="card">
            <?php if ($p['image']): ?>
                <img src="<?php echo $p['image']; ?>" class="card-image" alt="<?php echo sanitize($p['name']); ?>">
            <?php else: ?>
                <div class="card-image" style="display: flex; align-items: center; justify-content: center; background: #e0e0e0;">📦</div>
            <?php endif; ?>
            <div class="card-body">
                <div class="card-title"><?php echo sanitize($p['name']); ?></div>
                <div class="card-price">₫<?php echo format_price($p['price']); ?></div>
                <div class="card-description"><?php echo sanitize(substr($p['description'], 0, 100)); ?>...</div>
                <div class="card-footer">
                    <button class="btn btn-primary" onclick="addToCart(<?php echo $p['id']; ?>)">🛒 Thêm</button>
                    <a href="/product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary" style="flex: 1; margin-left: 10px;">👁️ Xem</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
    <div style="text-align: center; margin-top: 40px;">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="btn <?php echo $i == $paging['page'] ? 'btn-primary' : 'btn btn-secondary'; ?>" style="margin: 0 5px;"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>

    <?php require '../includes/footer.php'; ?>
    <script src="/js/main.js"></script>
</body>
</html>
