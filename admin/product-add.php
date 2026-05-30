<?php
require '../init.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'slug' => strtolower(str_replace(' ', '-', $_POST['name'])),
        'description' => $_POST['description'],
        'price' => $_POST['price'],
        'category_id' => $_POST['category_id'],
        'is_active' => 1
    ];

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $data['image'] = upload_file('image', 'products');
    }

    if (isset($_FILES['download']) && $_FILES['download']['size'] > 0) {
        $data['download_url'] = upload_file('download', 'downloads');
    }

    insert('products', $data);
    header('Location: /admin/products.php');
    exit;
}

$categories = getAll("SELECT * FROM categories");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản phẩm</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container" style="margin-top: 40px; max-width: 600px;">
        <h1>➕ Thêm Sản phẩm</h1>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Danh mục:</label>
                <select name="category_id" required>
                    <option>Chọn danh mục...</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo sanitize($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Giá:</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Mô tả:</label>
                <textarea name="description"></textarea>
            </div>
            <div class="form-group">
                <label>Hình ảnh:</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label>File tải xuống:</label>
                <input type="file" name="download">
            </div>
            <button type="submit" class="btn btn-success btn-block">Thêm sản phẩm</button>
        </form>
    </div>
</body>
</html>
