CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE NOT NULL,
    is_active TINYINT DEFAULT 1
);

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    category_id INT,
    user_id INT,
    image VARCHAR(255),
    file_path VARCHAR(255),
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    order_number VARCHAR(50) UNIQUE,
    total_amount DECIMAL(12,2),
    final_amount DECIMAL(12,2),
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    transaction_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10,2),
    total DECIMAL(12,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE IF NOT EXISTS affiliates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE,
    referral_code VARCHAR(50) UNIQUE,
    commission_rate DECIMAL(5,2) DEFAULT 10,
    available_balance DECIMAL(15,2) DEFAULT 0,
    withdrawn_amount DECIMAL(15,2) DEFAULT 0,
    is_active TINYINT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS affiliate_referrals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    affiliate_id INT,
    referred_user_id INT,
    FOREIGN KEY (affiliate_id) REFERENCES affiliates(id),
    FOREIGN KEY (referred_user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS affiliate_commissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    affiliate_id INT,
    order_id INT,
    referral_id INT,
    commission_amount DECIMAL(12,2),
    status ENUM('pending', 'approved') DEFAULT 'pending',
    FOREIGN KEY (affiliate_id) REFERENCES affiliates(id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (referral_id) REFERENCES affiliate_referrals(id)
);

CREATE TABLE IF NOT EXISTS affiliate_withdrawals (
    id INT PRIMARY KEY AUTO_INCREMENT,
    affiliate_id INT,
    amount DECIMAL(15,2),
    bank_account VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (affiliate_id) REFERENCES affiliates(id)
);
