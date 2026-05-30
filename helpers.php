<?php

function format_price($price) {
    return number_format($price, 0, ',', '.');
}

function format_date($date, $format = 'd/m/Y H:i') {
    return date($format, strtotime($date));
}

function sanitize($str) {
    return htmlspecialchars(strip_tags($str), ENT_QUOTES, 'UTF-8');
}

function get_cart() {
    start_session();
    return $_SESSION['cart'] ?? [];
}

function add_to_cart($product_id, $qty = 1) {
    start_session();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }
}

function remove_from_cart($product_id) {
    start_session();
    unset($_SESSION['cart'][$product_id]);
}

function clear_cart() {
    start_session();
    $_SESSION['cart'] = [];
}

function get_cart_total() {
    $cart = get_cart();
    $total = 0;
    
    foreach ($cart as $product_id => $qty) {
        $product = getRow("SELECT price FROM products WHERE id = $product_id AND is_active = 1");
        if ($product) {
            $total += $product['price'] * $qty;
        }
    }
    
    return $total;
}

function upload_file($file, $dir = 'products') {
    if (!isset($_FILES[$file]) || $_FILES[$file]['error'] !== 0) {
        return null;
    }
    
    $filename = time() . '_' . basename($_FILES[$file]['name']);
    $target = UPLOAD_DIR . $dir . '/' . $filename;
    
    if (!is_dir(UPLOAD_DIR . $dir)) {
        mkdir(UPLOAD_DIR . $dir, 0755, true);
    }
    
    if (move_uploaded_file($_FILES[$file]['tmp_name'], $target)) {
        return UPLOAD_URL . $dir . '/' . $filename;
    }
    
    return null;
}

?>
