# 🚀 Digital Marketplace - cPanel Version

Nền tảng bán sản phẩm số (phần mềm, hosting, digital products) đơn giản cho cPanel.

## 💡 Cách Dùng

### 1️⃣ **Tải Code Về**
```bash
git clone https://github.com/leowdzai/web.git
cd web
```

### 2️⃣ **Sửa File config.php**

Mở `config.php` và sửa thông tin:

```php
define('DB_HOST', 'localhost');           // Sửa host
define('DB_USER', 'cpanel_username');     // Sửa user
define('DB_PASS', 'password');            // Sửa password
define('DB_NAME', 'database_name');       // Sửa tên database
define('APP_URL', 'https://yourdomain.com');  // Sửa domain
```

### 3️⃣ **Tạo Database**

- Vào cPanel → MySQL → Tạo database mới
- Import file `sql/schema.sql` vào database đó
- Hoặc dùng phpMyAdmin để import

### 4️⃣ **Upload Lên cPanel**

- Upload toàn bộ folder lên `public_html`
- Hoặc dùng Git pull trên cPanel

### 5️⃣ **Tạo Admin Account**

Chạy lệnh SQL trong phpMyAdmin:

```sql
INSERT INTO users (email, password, name, role) 
VALUES ('admin@yourdomain.com', '$2y$10$[bcrypt_hash]', 'Admin', 'admin');
```

Hoặc dùng PHP:
```php
<?php
require 'core/Database.php';
$db = new Database();
$hash = password_hash('password123', PASSWORD_BCRYPT);
$db->query("INSERT INTO users (email, password, name, role) VALUES ('admin@yourdomain.com', '$hash', 'Admin', 'admin')");
?>
```

### 6️⃣ **Đăng Nhập Admin**

```
http://yourdomain.com/admin/login.php
```

## ⚙️ Cấu Hình Payment

### VNPay
1. Đăng ký: https://sandbox.vnpayment.vn
2. Sửa `config.php`:
```php
define('VNPAY_TMN_CODE', 'your_code');
define('VNPAY_HASH_SECRET', 'your_secret');
```

### Momo
1. Đăng ký: https://test-payment.momo.vn
2. Sửa `config.php`:
```php
define('MOMO_PARTNER_CODE', 'your_code');
define('MOMO_ACCESS_KEY', 'your_key');
define('MOMO_SECRET_KEY', 'your_secret');
```

## 📁 Cấu Trúc Project

```
web/
├── config.php              # ⚙️ CẤU HÌNH (sửa ở đây)
├── core/                   # Lõi ứng dụng
│   ├── Database.php       # Kết nối DB
│   ├── Auth.php           # Đăng nhập/đăng ký
│   ├── Product.php        # Sản phẩm
│   ├── Order.php          # Đơn hàng
│   ├── Affiliate.php      # Hệ thống affiliate
│   └── Payment.php        # Thanh toán
├── admin/                  # Admin Panel
│   ├── login.php          # Đăng nhập
│   ├── dashboard.php      # Dashboard
│   ├── products.php       # Quản lý sản phẩm
│   ├── orders.php         # Quản lý đơn hàng
│   ├── users.php          # Quản lý users
│   ├── affiliates.php     # Quản lý affiliate
│   ├── withdrawals.php    # Duyệt rút tiền
│   └── logout.php         # Đăng xuất
├── sql/                    # Database
│   └── schema.sql         # SQL schema
└── README.md              # Tài liệu
```

## ✨ Tính Năng

✅ Admin Dashboard (Users, Products, Orders, Revenue)  
✅ Quản lý sản phẩm & danh mục  
✅ Quản lý đơn hàng  
✅ Thanh toán VNPay & Momo  
✅ Hệ thống Affiliate (Referral & Commission)  
✅ Duyệt rút tiền  
✅ Session management  
✅ Security (bcrypt password, SQL escape)  

## 🔐 Bảo Mật

- Password: bcrypt hashing
- SQL: prepared statements & escape
- Session: secure tokens
- HTTPS: recommended

## 📞 Thắc Mắc?

1. Kiểm tra `config.php` - thông tin kết nối database
2. Kiểm tra file `sql/schema.sql` - import vào database
3. Kiểm tra quyền folder (755 cho folder, 644 cho file)
4. Kiểm tra PHP version >= 7.4

---

**Repository**: https://github.com/leowdzai/web
