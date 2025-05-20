<?php
// khuyen_mai.php: trang khuyến mãi động theo định dạng của san_pham.php
require_once 'connect.php';

// Lấy dữ liệu khuyến mãi
$sql = "SELECT id, ten_san_pham, hinh_anh, gia_cu, gia_moi FROM khuyen_mai ORDER BY id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chương Trình Khuyến Mãi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .product-card { width: 250px; background: #fff; padding: 10px; border-radius: 5px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .product-card img { width: 75%; height: auto; max-width: 150px; max-height: 187px; object-fit: cover; }
        .price { color:#e74c3c; font-size:1em; font-weight:bold; margin: 5px 0 0; }
        .btn { background:#3498db; color:#fff; border:none; padding:8px 12px; border-radius:3px; cursor:pointer; margin-top:-4px; }
        .btn:hover { background:#2980b9; }
    </style>
</head>
<body>
    <header>
        <div class="logo"><img src="imagin/logo.webp" alt="Logo"></div>
        <h1>Shop Thời Trang</h1>
    </header>
    <nav class="navbar">
        <ul class="menu">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="san_pham.php">Sản phẩm</a></li>
            <li><a href="bo_suu_tap.php">Bộ sưu tập</a></li>
            <li><a href="khuyen_mai.php">Khuyến mãi</a></li>
            <li><a href="lien_he.html">Liên hệ</a></li>
        </ul>
    </nav>
    <div class="container">
        <main class="content">
            <h2>Chương Trình Khuyến Mãi</h2>
            <div class="product-container">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $img = $row['hinh_anh'] ?: 'imagin/default.jpg'; ?>
                        <div class="product-card">
                            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['ten_san_pham']) ?>">
                            <h2><?= htmlspecialchars($row['ten_san_pham']) ?></h2>
                            <p class="price">
                                <del><?= number_format($row['gia_cu'],0,',','.') ?> VND</del>
                                <?= number_format($row['gia_moi'],0,',','.') ?> VND
                            </p>
                            <a class="btn" href="mua_ngay.php?id=<?= $item['san_pham_id'] ?>">Mua ngay</a>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Chưa có chương trình khuyến mãi nào.</p>
                <?php endif; ?>
                <?php $conn->close(); ?>
            </div>
        </main>
    </div>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Shop Thời Trang. All rights reserved.</p>
    </footer>
</body>
</html>
