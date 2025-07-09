<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra trong bảng nhan_vien trước
    $stmt = $conn->prepare("SELECT * FROM nhan_vien WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mat_khau'])) {
            $_SESSION['user_id'] = $user['ma_nhan_vien'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_type'] = 'nhan_vien';
            header("Location: admin/index.php");
            exit;
        }
    }

    // Nếu không tìm thấy trong nhan_vien, kiểm tra trong nguoi_dung
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mat_khau'])) {
            $_SESSION['user_id'] = $user['ma_nguoi_dung'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['user_role'] = 'user';
            $_SESSION['user_type'] = 'nguoi_dung';
            header("Location: trangchu.php");
            exit;
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tên đăng nhập không tồn tại.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">	
<head>	
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng Ký/ Đăng Nhập</title>
	<style>
	body {
  height: 100%;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
}

/* Video nền toàn màn hình */
#background-video {
  position: fixed;
  top: 0;
  left: 0;
  min-width: 100%;
  min-height: 50%;
  object-fit: cover;
  z-index: -1;
  pointer-events: none;
}

.wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100vh;
}

.auth-form {
  background-color: rgba(0, 0, 0, 0.5); /* Nền đen mờ vừa */
    padding: 2rem;
    color: #E0E0E0;
    margin: 2rem auto;
    width: 90%;
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(255, 102, 0, 0.2);
    color: #E0E0E0;
}

.auth-form h2 {
    color: #E0E0E0;
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 1.8rem;
}

.auth-form .form-group {
    margin-bottom: 1.2rem;
}

.auth-form label {
    display: block;
    margin-bottom: 0.5rem;
    color: #E0E0E0;
    font-weight: bold;
}

.auth-form input[type="email"],
.auth-form input[type="password"] {
    width: 100%;
    padding: 10px 15px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;

    background-color: rgba(255, 255, 255, 0.2); /* Trắng trong suốt */
    color: #fff;

    backdrop-filter: blur(4px); /* hiệu ứng mờ nền phía sau */
    -webkit-backdrop-filter: blur(4px); /* cho Safari */
    
    transition: background-color 0.3s, border 0.3s;
}

.auth-form input:focus {
    outline: none;
    box-shadow: 0 0 5px #f8a100;
}

.auth-form button {
    padding: 10px 20px;
    margin-right: 10px;
    background-color: #f8a100;
    color: #1e1d1d;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.auth-form button:hover {
    background-color: #ffa726;
}

/* Responsive form */
@media (max-width: 480px) {
    .auth-form {
        padding: 1.5rem;
    }

    .auth-form h2 {
        font-size: 1.5rem;
    }

    .auth-form button {
        width: 100%;
        margin-bottom: 10px;
    }
}
.btn-dangky {
  display: inline-block;
  padding: 10px 20px;
  background-color: #f8a100;
  color: #1e1d1d;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s;
}
.btn-dangky:hover {
  background-color: #ffa726;
}

/* Phần liên hệ */
#lien-he {
    text-align: center;
    background-color: #2c3e50; /* Màu nền xám tối */
    padding: 30px;
    border-radius: 5px;
    color: white; /* Màu trắng cho chữ */
    margin-top: 3rem; /* Khoảng cách phía trên */
}

#lien-he h2 {
    font-size: 1.8rem; /* Kích thước chữ tiêu đề */
    color: #f8a100; /* Màu cam sáng cho tiêu đề */
    margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
}

#lien-he p {
    font-size: 1.1rem; /* Kích thước chữ cho đoạn văn */
    margin: 10px 0; /* Khoảng cách trên/dưới các đoạn văn */
    line-height: 1.6; /* Khoảng cách giữa các dòng */
}

#lien-he a {
    color: white; /* Màu vàng nhạt cho liên kết */
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease, text-decoration 0.3s ease; /* Hiệu ứng chuyển màu và gạch chân */
}

#lien-he a:hover {
    color: #f8a100; /* Màu cam sáng khi hover */
    text-decoration: underline; /* Gạch chân khi hover */
}

#lien-he a:focus {
    outline: none; /* Loại bỏ viền focus mặc định khi nhấn vào liên kết */
    color: #f8a100; /* Giữ màu khi focus vào liên kết */
}
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
}

.wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  min-height: 100vh;
}

    
	</style>
</head>	
<body>
  <!-- Wrapper bao toàn bộ nội dung trừ video nền -->
  <div class="wrapper">
    
    <!-- Header -->
    <header>
      <h1>🏍E-BIKES</h1>
    </header>
    <!-- Form đăng nhập/đăng ký -->
    <section class="auth-form">
      <h2>Đăng Nhập</h2>
      <form action="dang_nhap.php" method="POST">
        <div class="form-group">
          <label for="username">Email:</label>
          <input type="email" id="username" name="username" required />
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="form-group">
          <button type="submit">Đăng nhập</button>
          <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
          <a href="dangky.html" class="btn-dangky">Đăng ký</a>
        </div>
      </form>
    </section>
    <!-- Footer -->
    <footer id="lien-he">
      <div class="footer-bottom">
        <p>&copy; 2025 <strong>E-BIKES</strong>. Tất cả quyền được bảo vệ.</p>
      </div>
    </footer>

  </div> <!-- Kết thúc wrapper -->

  <!-- Video nền -->
  <video autoplay muted loop id="background-video">
    <source src= "Untitled video - Made with Clipchamp.mp4">
    Trình duyệt không hỗ trợ video.
  </video>
</body>
</html>
	
		
		