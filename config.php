<?php
// ====== CẤU HÌNH DATABASE ======
define('DB_HOST', 'localhost');
define('DB_USER', 'root');              // Sửa thành user cPanel
define('DB_PASS', '');                  // Sửa thành password
define('DB_NAME', 'marketplace');       // Sửa thành tên database

// ====== CẤU HÌNH ỨNG DỤNG ======
define('SITE_NAME', 'Digital Marketplace');
define('SITE_URL', 'http://localhost');
define('ADMIN_EMAIL', 'admin@marketplace.local');

// ====== CẤU HÌNH THANH TOÁN ======
define('VNPAY_CODE', '');
define('VNPAY_SECRET', '');
define('MOMO_CODE', '');
define('MOMO_KEY', '');

// ====== CẤU HÌNH AFFILIATE ======
define('COMMISSION_RATE', 10);
define('MIN_WITHDRAW', 100000);

define('UPLOAD_DIR', __DIR__ . '/uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');

?>
