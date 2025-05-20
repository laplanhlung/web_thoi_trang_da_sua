<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bộ Sưu Tập</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .collection-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .collection-card {
            background: #B3E5FC;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
        }
        .collection-card img {
            width: 100%;
            height: 80%;
            border-radius: 5px;
        }
        .collection-card h2 {
            font-size: 1.4em;
            color: #0277BD;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="imagin/logo.webp" alt="Shop Logo">
        </div>
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

    <?php
// bo_suu_tap.php: trang hiển thị các bộ sưu tập
require_once 'connect.php';

// Lấy dữ liệu từ bảng bo_suu_tap
$sql = "SELECT bo_suu_tap_id, ten_bo_suu_tap, hinh_anh 
        FROM bo_suu_tap 
        ORDER BY bo_suu_tap_id";
$result = $conn->query($sql);
?>

<main>
    <section class="collection-section collection-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="collection-card">
                    <h3><?php echo htmlspecialchars($row['ten_bo_suu_tap']); ?></h3>
                    <img src="imagin/<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_bo_suu_tap']); ?>">
                    <?php
                        // Chọn link theo ID
                        if ($row['bo_suu_tap_id'] == 1) {
                            $link = 'bo_suu_tap_mh.php';
                        } elseif ($row['bo_suu_tap_id'] == 2) {
                            $link = 'bo_suu_tap_md.php';
                        } elseif ($row['bo_suu_tap_id'] == 3) {
                            $link = 'bo_suu_tap_mx.php';
                        } elseif ($row['bo_suu_tap_id'] == 4) {
                            $link = 'bo_suu_tap_mt.php';
                        } else {
                            $link = '#';
                        }
                    ?>
                    <a href="<?php echo $link; ?>" class="btn">Xem chi tiết</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Chưa có bộ sưu tập nào.</p>
        <?php endif; ?>
    </section>
</main>

<?php $conn->close(); ?>


    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Shop Thời Trang. All rights reserved.</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/minhthuan.le.923724"><img src="imagin\Facebook.webp" alt="Facebook"></a>
                <a href="https://www.facebook.com/minhthuan.le.923724"><img src="imagin\Insta.webp" alt="Instagram"></a>
                <a href="https://www.facebook.com/minhthuan.le.923724"><img src="imagin\X.webp" alt="Twitter"></a>
            </div>
        </div>
    </footer>
</body>
</html>
