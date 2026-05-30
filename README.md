# 🚀 Digital Marketplace - New Version

Web bán hàng số hoàn toàn mới, đơn giản và hiệu quả cho cPanel.

## ✨ Tính năng

✅ **Frontend hoàn chỉnh**
- Trang chủ, danh sách sản phẩm
- Chi tiết sản phẩm
- Giỏ hàng, checkout
- Lịch sử đơn hàng

✅ **Backend đầy đủ**
- User authentication
- Product management
- Order processing
- Payment gateway (VNPay, Momo)
- Affiliate system

✅ **Admin Panel**
- Dashboard thống kê
- Quản lý sản phẩm
- Quản lý đơn hàng
- Quản lý users
- Quản lý affiliate

## 🛠 Cài đặt

### 1. Tải code
```bash
git clone https://github.com/leowdzai/web.git
cd web
```

### 2. Sửa config.php
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_password');
define('DB_NAME', 'your_database');
define('SITE_URL', 'https://yourdomain.com');
```

### 3. Import database
- Mở phpMyAdmin
- Tạo database mới
- Import file `database.sql`

### 4. Upload lên cPanel
- Upload toàn bộ folder lên `public_html`

### 5. Tạo admin account
```sql
INSERT INTO users (email, password, name, role) 
VALUES ('admin@domain.com', '$2y$10$...hash...', 'Admin', 'admin');
```

### 6. Truy cập
- **Frontend**: http://yourdomain.com
- **Admin**: http://yourdomain.com/admin/login.php

---

**Repository**: https://github.com/leowdzai/web
