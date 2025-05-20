<?php
include "connect.php"; // Kết nối với cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và tránh lỗi SQL injection
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $noi_dung = $_POST['noi_dung'];
    $ngay_gui = date('Y-m-d H:i:s'); // Lấy thời gian gửi

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email không hợp lệ.";
        exit;
    }

    // Sử dụng prepared statement để tránh SQL injection
    $sql = "INSERT INTO lien_he (lien_he_ho_ten, lien_he_email, lien_he_sdt, lien_he_noi_dung, lien_he_ngay_gui) 
            VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        // Gán giá trị cho các tham số trong prepared statement
        $stmt->bind_param("sssss", $ho_ten, $email, $sdt, $noi_dung, $ngay_gui);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            echo "Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.";

            // Gửi email thông báo đến quản trị viên (email của bạn)
            $to = "your-email@example.com";  // Địa chỉ email bạn muốn nhận
            $subject = "Có liên hệ mới từ khách hàng";
            $message = "
                <h2>Thông tin liên hệ mới</h2>
                <p><strong>Họ và tên:</strong> $ho_ten</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Số điện thoại:</strong> $sdt</p>
                <p><strong>Nội dung:</strong><br>$noi_dung</p>
                <p><strong>Ngày gửi:</strong> $ngay_gui</p>
            ";

            // Tiêu đề email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: no-reply@example.com" . "\r\n";  // Địa chỉ email gửi (không phải là email người dùng)

            // Gửi email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email thông báo đã được gửi thành công.";
            } else {
                echo "Có lỗi xảy ra khi gửi email.";
            }
        } else {
            echo "Có lỗi xảy ra khi lưu dữ liệu: " . $stmt->error;
        }

        // Đóng statement
        $stmt->close();
    } else {
        echo "Có lỗi xảy ra: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
