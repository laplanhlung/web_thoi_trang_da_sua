<?php
require_once 'connect.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$item = null;
$error = '';
$show_form = false;

if ($id !== '') {
    $stmt = $conn->prepare("SELECT * FROM san_pham WHERE san_pham_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        $error = "Không tìm thấy sản phẩm!";
    }
    $stmt->close();
} else {
    $error = "Sản phẩm không hợp lệ!";
}

// Xử lý khi submit form đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_submit'])) {
    $show_form = true;
    $ho_ten = htmlspecialchars($_POST['ho_ten']);
    $dia_chi = htmlspecialchars($_POST['dia_chi']);
    $sdt = htmlspecialchars($_POST['sdt']);
    $email = htmlspecialchars($_POST['email']);
    $ghi_chu = htmlspecialchars($_POST['ghi_chu']);
    // Ở đây bạn có thể lưu vào CSDL hoặc gửi email, demo chỉ hiển thị lại thông tin
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mua ngay<?= $item ? ' - ' . htmlspecialchars($item['san_pham']) : '' ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-detail { max-width: 400px; margin: 40px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
        .product-detail img { width: 70%; max-width: 250px; object-fit: cover; }
        .price { color:#e74c3c; font-size:1.2em; font-weight:bold; margin: 10px 0; }
        .btn { background:#3498db; color:#fff; border:none; padding:10px 18px; border-radius:3px; cursor:pointer; }
        .btn:hover { background:#2980b9; }
        .error { color: red; text-align: center; margin-top: 40px; }
        .order-form { max-width: 400px; margin: 30px auto; background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.08);}
        .order-form input, .order-form textarea { width: 100%; padding: 8px; margin: 8px 0; border-radius: 4px; border: 1px solid #ccc;}
        .order-form label { font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <div class="logo"><img src="imagin/logo.webp" alt="Logo"></div>
        <h1>Shop Thời Trang</h1>
    </header>
    <div class="container">
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
            <div style="text-align:center;margin-top:20px;">
                <a href="san_pham.php">Quay lại danh sách sản phẩm</a>
            </div>
        <?php elseif ($show_form): ?>
            <div class="order-form">
                <h2>Đặt hàng thành công!</h2>
                <p><strong>Họ tên:</strong> <?= $ho_ten ?></p>
                <p><strong>Địa chỉ:</strong> <?= $dia_chi ?></p>
                <p><strong>SĐT:</strong> <?= $sdt ?></p>
                <p><strong>Email:</strong> <?= $email ?></p>
                <p><strong>Ghi chú:</strong> <?= $ghi_chu ?></p>
                <p>Cảm ơn bạn đã đặt hàng!</p>
                <a href="san_pham.php">Quay lại danh sách sản phẩm</a>
            </div>
        <?php else: ?>
        <div class="product-detail">
            <?php $img = $item['hinh_anh'] ?: 'imagin/default.jpg'; ?>
            <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['san_pham']) ?>">
            <h2><?= htmlspecialchars($item['san_pham']) ?></h2>
            <p class="price"><?= number_format($item['gia_san_pham'],0,',','.') ?> VND</p>
            <form method="post" class="order-form">
                <h3>Nhập thông tin đặt hàng</h3>
                <label>Họ tên*</label>
                <input type="text" name="ho_ten" required>
                <label>Địa chỉ*</label>
                <input type="text" name="dia_chi" required>
                <label>Số điện thoại*</label>
                <input type="text" name="sdt" required>
                <label>Email</label>
                <input type="email" name="email">
                <label>Ghi chú</label>
                <textarea name="ghi_chu"></textarea>
                <button class="btn" type="submit" name="order_submit">Xác nhận mua</button>
            </form>
            <br>
            <a href="san_pham.php">Quay lại danh sách sản phẩm</a>
        </div>
        <?php endif; ?>
    </div>
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Shop Thời Trang. All rights reserved.</p>
    </footer>
<?php $conn->close(); ?>
</body>
</html>