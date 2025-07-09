<?php
include 'connect.php'; // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu khớp
    if ($password !== $confirm_password) {
        echo "Mật khẩu không khớp!";
        exit;
    }

    // Kiểm tra email đã tồn tại trong bảng nguoi_dung
    $checkEmail = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) {
        echo "Email đã được sử dụng!";
        exit;
    }

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Thêm vào bảng nguoi_dung
    $stmtUser = $conn->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau) VALUES (?, ?, ?)");
    $stmtUser->bind_param("sss", $fullname, $email, $hashed_password);
    
    if (!$stmtUser->execute()) {
        echo "Lỗi khi tạo tài khoản!";
        exit;
    }

    // Chuyển hướng hoặc thông báo thành công tại đây
}

$conn->close(); // Đóng kết nối
?>
<!-- HTML thông báo đăng ký thành công -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký thành công</title>
  <style>
    body {
      background: linear-gradient(to right, #f8a100, #ffcc70);
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .success-box {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }

    .success-box h1 {
      color: #f8a100;
      margin-bottom: 20px;
    }

    .success-box p {
      color: #333;
      font-size: 16px;
      margin-bottom: 30px;
    }

    .success-box a {
      display: inline-block;
      padding: 12px 25px;
      background-color: #f8a100;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .success-box a:hover {
      background-color: #e29400;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <h1>🎉 Đăng ký thành công!</h1>
    <p>Chúc mừng bạn đã đăng ký tài khoản E-BIKES.</p>
    <a href="dang_nhap.php">🔙 Quay lại đăng nhập</a>
  </div>
</body>
</html>