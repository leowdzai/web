# 🚀 Digital Marketplace - cPanel Version

Nền tảng bán sản phẩm số (phần mềm, hosting, digital products) đơn giản cho cPanel.

## ✨ Tính năng

✅ Admin Dashboard (HTML đơn giản)  
✅ Quản lý Sản phẩm & Danh mục  
✅ Quản lý Đơn hàng  
✅ Thanh toán: VNPay + Momo  
✅ Hệ thống Affiliate (Referral & Commission)  
✅ Rút tiền cho Affiliate  
✅ Chỉ ~20 file, dễ deploy trên cPanel  

## 📦 Cài đặt

### 1. Upload lên cPanel
```bash
# Kéo thả tất cả files lên thư mục public_html của cPanel
```

### 2. Truy cập Installation
```
http://yourdomain.com/install.php
```

### 3. Điền thông tin Database
- Database Host: localhost
- Database User: cpanel_username
- Database Name: cpanel_username_marketplace

### 4. Tạo Admin Account
- Email: admin@yourdomain.com
- Password: strong_password

### 5. Truy cập Admin Panel
```
http://yourdomain.com/admin/dashboard.php
```

## 🔑 Cấu hình Payment Gateway

### VNPay
1. Đăng ký: https://sandbox.vnpayment.vn
2. Copy `TMN Code` và `Hash Secret`
3. Dán vào file `.env`:
```
VNPAY_TMN_CODE=1234567890
VNPAY_HASH_SECRET=abcdefghijk...
```

### Momo
1. Đăng ký: https://test-payment.momo.vn
2. Copy credentials
3. Dán vào file `.env`:
```
MOMO_PARTNER_CODE=your_code
MOMO_ACCESS_KEY=your_key
MOMO_SECRET_KEY=your_secret
```

## 📁 Cấu trúc Project

```
web/
├── admin/                 # Admin Panel
├── core/                  # Lõi ứng dụng (Auth, DB, Models)
├── config/                # Cấu hình
├── sql/                   # Database schema
├── payment/               # Xử lý thanh toán
├── install.php            # Setup wizard
├── .env                   # Environment config
└── README.md
```

## 🎯 Các tính năng chính

### Admin Panel
- 📊 Dashboard (Users, Products, Orders, Revenue)
- 📦 Quản lý sản phẩm
- 📋 Quản lý đơn hàng
- 👥 Quản lý users
- 🤝 Quản lý affiliate
- 💳 Duyệt yêu cầu rút tiền

### Affiliate System
- Mỗi user có 1 referral code riêng
- Kiếm 10% hoa hồng từ mỗi đơn hàng của người được referral
- Dashboard tracking chi tiết
- Yêu cầu rút tiền vào ngân hàng

## 🔐 Bảo mật

- Password hashing: bcrypt
- SQL Injection protection: escape queries
- HTTPS recommended
- Payment signature verification

## 📞 Support

Nếu gặp vấn đề:
1. Kiểm tra `.env` config
2. Xem file logs (nếu có)
3. Kiểm tra cấp quyền thư mục: 755
4. Kiểm tra PHP version >= 7.4

## 📄 License

MIT License

---

**Repository**: https://github.com/leowdzai/web
