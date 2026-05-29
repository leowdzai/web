<?php
session_start();
require_once '../core/Database.php';
require_once '../core/Auth.php';
require_once '../core/Product.php';

if (!Auth::isAdmin()) {
    header('Location: login.php');
    exit;
}

$product = new Product();
$products = $product->getAll(100);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { margin-bottom: 30px; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #333; color: white; }
        tr:hover { background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Manage Products</h1>
            <button class="btn" onclick="goBack()">← Back</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>₫<?= number_format($p['price']) ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>
                        <button class="btn" onclick="edit(<?= $p['id'] ?>)">Edit</button>
                        <button class="btn btn-danger" onclick="delete_product(<?= $p['id'] ?>)">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script>
        function goBack() { window.location.href = 'dashboard.php'; }
        function edit(id) { alert('Edit product ' + id); }
        function delete_product(id) { 
            if (confirm('Delete this product?')) {
                alert('Product deleted');
            }
        }
    </script>
</body>
</html>
