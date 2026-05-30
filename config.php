<?php

// ====== CẤU HÌNH KẾT NỐI DATABASE ======
// Sửa thông tin của bạn vào đây

define('DB_HOST', 'localhost');
define('DB_USER', 'root');              // Sửa thành tên user cPanel của bạn
define('DB_PASS', '');                  // Sửa thành password database
define('DB_NAME', 'marketplace');       // Sửa thành tên database của bạn

// ====== CẤU HÌNH ỨNG DỤNG ======
define('APP_URL', 'http://yourdomain.com');  // Sửa thành domain của bạn
define('APP_NAME', 'Digital Marketplace');
define('APP_DEBUG', true);

// ====== CẤU HÌNH VNPAY ======
define('VNPAY_TMN_CODE', '');
define('VNPAY_HASH_SECRET', '');
define('VNPAY_URL', 'https://sandbox.vnpayment.vn/paygate');

// ====== CẤU HÌNH MOMO ======
define('MOMO_PARTNER_CODE', '');
define('MOMO_ACCESS_KEY', '');
define('MOMO_SECRET_KEY', '');
define('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create');

// ====== AFFILIATE CONFIG ======
define('AFFILIATE_COMMISSION_RATE', 10); // 10% hoa hồng
define('MIN_WITHDRAW', 100000);          // 100k VND tối thiểu rút tiền

?>
