<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Sản Phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php
// san_pham.php: trang sản phẩm động với ảnh nhỏ hơn và căn chỉnh text
require_once 'connect.php';


// Lấy dữ liệu
$sql = "SELECT san_pham_id, gia_san_pham, san_pham, hinh_anh FROM san_pham ORDER BY san_pham_id";
$result = $conn->query($sql);

// Tổ chức theo nhóm
$groups = [
    'AO' => ['title' => '👕 Áo',       'id'=>'ao',         'items'=>[]],
    'QU' => ['title' => '👖 Quần',      'id'=>'quan',      'items'=>[]],
    'DA' => ['title' => '👗 Đầm - Váy', 'id'=>'dam_vay',   'items'=>[]],
    'GI' => ['title' => '👠 Giày',      'id'=>'giay',      'items'=>[]],
    'PK' => ['title' => '🎒 Phụ kiện',  'id'=>'phu_kien',  'items'=>[]],
    'TS' => ['title' => '⌚ Trang sức', 'id'=>'trang_suc', 'items'=>[]]
];
if ($result) {
    while ($r = $result->fetch_assoc()) {
        $pref = strtoupper(substr($r['san_pham_id'], 0, 2));
        if (isset($groups[$pref])) {
            $groups[$pref]['items'][] = $r;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Sản Phẩm</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .product-card { width: 250px; background: #fff; padding: 10px; border-radius: 5px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        /* Ảnh nhỏ hơn 25% */
        .product-card img { width: 75%; height: auto; max-width: 150px; max-height: 187px; object-fit: cover; }
        /* Căn chỉnh giá và nút mua ngay lên trên */
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
            <li><a href="lien_he.php">Liên hệ</a></li>
        </ul>
    </nav>
    <div class="container">
        <main class="content">
            <h2>Danh sách sản phẩm</h2>
            <?php foreach ($groups as $g): ?>
                <?php if (count($g['items'])>0): ?>
                    <h3 id="<?= $g['id'] ?>"><?= $g['title'] ?></h3>
                    <div class="product-container">
                        <?php foreach ($g['items'] as $item): ?>
                            <div class="product-card">
                                <?php $img = $item['hinh_anh']?: 'imagin/default.jpg'; ?>
                                <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['san_pham']) ?>">
                                <h2><?= htmlspecialchars($item['san_pham']) ?></h2>
                                <p class="price"><?= number_format($item['gia_san_pham'],0,',','.') ?> VND</p>
                                <a class="btn" href="mua_ngay.php?id=<?= $item['san_pham_id'] ?>">Mua ngay</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </main>
    </div>
</body>
 <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?= date('Y') ?> Shop Thời Trang. All rights reserved.</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/minhthuan.le.923724"><img src="imagin/Facebook.webp" alt="Facebook"></a>
                <a href="https://www.instagram.com/minhthuan.le.923724"><img src="imagin/Insta.webp" alt="Instagram"></a>
                <a href="https://twitter.com/minhthuan_le"><img src="imagin/X.webp" alt="Twitter"></a>
            </div>
        </div>
    </footer>
</html>
<?php $conn->close(); ?>
