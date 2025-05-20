<?php
require_once 'connect.php';

// Thiết lập múi giờ cho chính xác (Asia/Ho_Chi_Minh)
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Bắt đầu phiên làm việc
session_start();

// Đếm số lần truy cập trang trong phiên hiện tại
if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    $_SESSION['visit_count']++;
}

// Lấy thông tin lần truy cập trước từ cookie
$last_visit = isset($_COOKIE['last_visit']) ? $_COOKIE['last_visit'] : 'Chưa có dữ liệu';

// Cập nhật cookie lần truy cập hiện tại (lưu trữ 30 ngày)
setcookie(
    'last_visit',
    date('d-m-Y H:i:s'),
    time() + 30*24*60*60,
    '/'
);

// Lấy tất cả sản phẩm
$sql = "SELECT * FROM san_pham ORDER BY san_pham_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Thời Trang</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { display: flex; align-items: flex-start; }
        .sidebar { width: 220px; margin-right: 30px; }
        .content { flex: 1; margin-left: 0; }
        .product-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: flex-start; }
        .product-card { width: 220px; background: #fff; padding: 10px; border-radius: 5px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .product-card img { width: 80%; max-width: 150px; max-height: 187px; object-fit: cover; }
        .price { color:#e74c3c; font-size:1em; font-weight:bold; margin: 5px 0 0; }
        .btn { background:#3498db; color:#fff; border:none; padding:8px 12px; border-radius:3px; cursor:pointer; margin-top:8px; text-decoration:none; display:inline-block; }
        .btn:hover { background:#2980b9; }
        @media (max-width: 900px) {
            .container { flex-direction: column; }
            .sidebar { width: 100%; margin: 0 0 20px 0; }
            .content { margin-left: 0; }
            .product-container { justify-content: center; }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <img src="imagin/logo.webp" alt="Shop Logo">
        </div>
        <h1>Shop Thời Trang</h1>
        <!-- Thông tin session và cookie -->
        <div class="info" style="text-align:center; margin-top:10px; color:#555;">
            <p>Lần truy cập trang này trong phiên: <strong><?= $_SESSION['visit_count'] ?></strong></p>
            <p>Lần truy cập cuối: <strong><?= htmlspecialchars($last_visit) ?></strong></p>
        </div>
    </header>

    <!-- Navigation Bar -->
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
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Danh Mục Sản Phẩm</h2>
            <ul>
                <li><a href="san_pham.php#ao">👕 Áo</a></li>
                <li><a href="san_pham.php#quan">👖 Quần</a></li>
                <li><a href="san_pham.php#dam_vay">👗 Đầm - Váy</a></li>
                <li><a href="san_pham.php#giay">👠 Giày</a></li>
                <li><a href="san_pham.php#phu_kien">🎒 Phụ kiện</a></li>
                <li><a href="san_pham.php#trang_suc">⌚ Trang sức</a></li>
            </ul>
        </aside>

        <!-- Nội dung chính -->
        <main class="content">
            <h2 style="text-align:center;">Tất cả sản phẩm</h2>
            <div class="product-container">
                <?php while ($item = $result->fetch_assoc()): ?>
                    <?php $img = $item['hinh_anh'] ?: 'imagin/default.jpg'; ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['san_pham']) ?>">
                        <h3><?= htmlspecialchars($item['san_pham']) ?></h3>
                        <p class="price"><?= number_format($item['gia_san_pham'],0,',','.') ?> VND</p>
                        <a class="btn" href="mua_ngay.php?id=<?= urlencode($item['san_pham_id']) ?>">Mua ngay</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>

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

    <!-- Cookie Consent Banner -->
    <div id="cookie-consent" style="
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: rgba(0,0,0,0.8);
        color: #fff;
        padding: 15px;
        text-align: center;
        font-size: 14px;
        z-index: 1000;
        display: none;
    ">
        Chúng tôi sử dụng cookie để cải thiện trải nghiệm của bạn.
        <button id="accept-cookies" style="
            margin: 0 10px;
            padding: 8px 12px;
            background: #2ecc71;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        ">Chấp nhận</button>
        <button id="decline-cookies" style="
            margin: 0 10px;
            padding: 8px 12px;
            background: #e74c3c;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        ">Từ chối</button>
    </div>

    <script>
    // Hàm đặt cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var d = new Date();
            d.setTime(d.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + d.toUTCString();
        }
        document.cookie = name + "=" + (value||"")  + expires + "; path=/";
    }
    // Hàm lấy cookie theo tên
    function getCookie(name) {
        var parts = document.cookie.split(';');
        for(var i=0; i<parts.length; i++) {
            var c = parts[i].trim();
            if (c.indexOf(name + "=") == 0) {
                return c.substring(name.length+1);
            }
        }
        return null;
    }
    // Cookie consent logic (ẩn/hiện banner)
    window.onload = function() {
        if (!getCookie('cookie_consent')) {
            document.getElementById('cookie-consent').style.display = 'block';
        }
        document.getElementById('accept-cookies').onclick = function() {
            setCookie('cookie_consent', 'accepted', 365);
            document.getElementById('cookie-consent').style.display = 'none';
        };
        document.getElementById('decline-cookies').onclick = function() {
            setCookie('cookie_consent', 'declined', 365);
            document.getElementById('cookie-consent').style.display = 'none';
        };
    };
    </script>

</body>
</html>