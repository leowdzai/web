function addToCart(productId) {
    fetch('/api/cart/add.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelector('.cart-count').textContent = data.cart_count;
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    });
}

function removeFromCart(productId) {
    if (confirm('Xóa sản phẩm khỏi giỏ hàng?')) {
        fetch('/api/cart/remove.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
