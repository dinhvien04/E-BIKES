<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: dang_nhap.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ho_ten'])) {
    $ho_ten = $_POST['ho_ten'];
    $email = $_POST['email'];
    $so_dien_thoai = $_POST['so_dien_thoai'];
    $dia_chi = $_POST['dia_chi'];
    $cccd = $_POST['cccd'];
    $ngay_sinh = $_POST['ngay_sinh'];

    $update_sql = "UPDATE nguoi_dung SET ho_ten=?, email=?, so_dien_thoai=?, dia_chi=?, cccd=?, ngay_sinh=? WHERE ma_nguoi_dung=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssssssi', $ho_ten, $email, $so_dien_thoai, $dia_chi, $cccd, $ngay_sinh, $user_id);
    
    if ($update_stmt->execute()) {
        $message = '<p style="color:green;text-align:center;">Cập nhật thông tin thành công!</p>';
    } else {
        $message = '<p style="color:red;text-align:center;">Có lỗi xảy ra khi cập nhật thông tin.</p>';
    }
}

// Lấy thông tin người dùng mới nhất sau mọi thao tác POST
$sql = "SELECT ho_ten, email, so_dien_thoai, dia_chi, cccd, ngay_sinh FROM nguoi_dung WHERE ma_nguoi_dung = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo '<p style="color:red;text-align:center;">Không tìm thấy thông tin người dùng.</p>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="css/vidu.css">
    <style>
        body { background: #23272b; color: #fff; font-family: Arial, sans-serif; }
        .profile-box { max-width: 650px; margin: 60px auto; background: #31363b; border-radius: 12px; box-shadow: 0 4px 16px #0003; padding: 48px 40px; }
        h2 { color: #f8a100; text-align: center; margin-bottom: 30px; }
        .info-row { margin-bottom: 18px; display: flex; align-items: center; }
        .info-label { width: 140px; color: #dac446; font-weight: bold; }
        .info-value { flex: 1; color: #fff; }
        .profile-actions { text-align: center; margin-top: 30px; display: flex; justify-content: center; gap: 18px; flex-wrap: wrap; }
        .profile-actions a, .profile-actions button { display: inline-block; background: #f8a100; color: #fff; padding: 12px 36px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; border: none; cursor: pointer; font-size: 18px; margin: 0; }
        .profile-actions a:hover, .profile-actions button:hover { background: #e67e22; }
        .profile-actions button[style*="background: #4CAF50"] { background: #4CAF50; }
        .profile-actions button[style*="background: #f39c12"] { background: #f39c12; }
        .profile-actions button[style*="background: #666"] { background: #666; }
        .profile-actions a[style*="background:#e53935;"], .profile-actions button[style*="background:#e53935;"] { background: #c0392b !important; }
        .edit-form { display: none; }
        .edit-form.active { display: block; }
        .edit-form input { width: 100%; padding: 8px; margin: 5px 0; border-radius: 4px; border: 1px solid #444; background: #2c3136; color: #fff; }
        .edit-form input:focus { outline: none; border-color: #f8a100; }
        .message { margin-bottom: 20px; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="profile-box">
        <h2>Thông tin cá nhân</h2>
        <?php echo $message; ?>
        
        <div id="view-mode">
            <div class="info-row"><span class="info-label">Họ tên:</span><span class="info-value"><?php echo htmlspecialchars($user['ho_ten']); ?></span></div>
            <div class="info-row"><span class="info-label">Email:</span><span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span></div>
            <div class="info-row"><span class="info-label">Số điện thoại:</span><span class="info-value"><?php echo htmlspecialchars($user['so_dien_thoai']); ?></span></div>
            <div class="info-row"><span class="info-label">Địa chỉ:</span><span class="info-value"><?php echo htmlspecialchars($user['dia_chi']); ?></span></div>
            <div class="info-row"><span class="info-label">CCCD:</span><span class="info-value"><?php echo htmlspecialchars($user['cccd']); ?></span></div>
            <div class="info-row"><span class="info-label">Ngày sinh:</span><span class="info-value"><?php echo htmlspecialchars($user['ngay_sinh']); ?></span></div>
        </div>

        <form class="edit-form" method="POST" action="">
            <div class="info-row">
                <span class="info-label">Họ tên:</span>
                <input type="text" name="ho_ten" value="<?php echo htmlspecialchars($user['ho_ten']); ?>" required>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="info-row">
                <span class="info-label">Số điện thoại:</span>
                <input type="tel" name="so_dien_thoai" value="<?php echo htmlspecialchars($user['so_dien_thoai']); ?>" required>
            </div>
            <div class="info-row">
                <span class="info-label">Địa chỉ:</span>
                <input type="text" name="dia_chi" value="<?php echo htmlspecialchars($user['dia_chi']); ?>" required>
            </div>
            <div class="info-row">
                <span class="info-label">CCCD:</span>
                <input type="text" name="cccd" value="<?php echo htmlspecialchars($user['cccd']); ?>" required>
            </div>
            <div class="info-row">
                <span class="info-label">Ngày sinh:</span>
                <input type="date" name="ngay_sinh" value="<?php echo htmlspecialchars($user['ngay_sinh']); ?>" required>
            </div>
            <div class="profile-actions">
                <button type="submit">Lưu thay đổi</button>
                <button type="button" onclick="toggleEdit()" style="background: #666;">Hủy</button>
            </div>
        </form>

        <div class="profile-actions" id="view-actions">
            <button onclick="toggleEdit()" style="background: #4CAF50;">Chỉnh sửa</button>
            <a href="doi_mat_khau.php" style="background: #f39c12; margin-left: 10px;">Đổi mật khẩu</a>
            <a href="lich_su_dat_hang.php" style="background: #2980b9; margin-left: 10px;">Lịch sử đặt hàng</a>
            <a href="trangchu.php">Về trang chủ</a>
            <a href="logout.php" style="margin-left:20px; background:#e53935;">Đăng xuất</a>
        </div>
    </div>
    <script>
        function toggleEdit() {
            const viewMode = document.getElementById('view-mode');
            const editForm = document.querySelector('.edit-form');
            const viewActions = document.getElementById('view-actions');
            
            if (viewMode.style.display !== 'none') {
                viewMode.style.display = 'none';
                editForm.classList.add('active');
                viewActions.style.display = 'none';
            } else {
                viewMode.style.display = 'block';
                editForm.classList.remove('active');
                viewActions.style.display = 'block';
            }   
        }
    </script>
    <?php include 'footer.php'; ?>
</body>
</html> 