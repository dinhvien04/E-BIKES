<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: dang_nhap.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$message = '';
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $stmt = $conn->prepare("SELECT mat_khau FROM nguoi_dung WHERE ma_nguoi_dung = ? LIMIT 1");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $db_password = $row['mat_khau'];
    if (!password_verify($current_password, $db_password)) {
        $message = '<p style="color:red;text-align:center;">Mật khẩu hiện tại không đúng.</p>';
    } elseif ($new_password !== $confirm_password) {
        $message = '<p style="color:red;text-align:center;">Mật khẩu mới không khớp.</p>';
    } elseif (strlen($new_password) < 6) {
        $message = '<p style="color:red;text-align:center;">Mật khẩu mới phải có ít nhất 6 ký tự.</p>';
    } else {
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_pass = $conn->prepare("UPDATE nguoi_dung SET mat_khau=? WHERE ma_nguoi_dung=?");
        $update_pass->bind_param('si', $hashed_new_password, $user_id);
        if ($update_pass->execute()) {
            $message = '<p style="color:green;text-align:center;">Đổi mật khẩu thành công!</p>';
        } else {
            $message = '<p style="color:red;text-align:center;">Có lỗi khi đổi mật khẩu.</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" href="css/vidu.css">
    <style>
        body { background: #23272b; color: #fff; font-family: Arial, sans-serif; }
        .box { max-width: 420px; margin: 60px auto; background: #31363b; border-radius: 12px; box-shadow: 0 4px 16px #0003; padding: 36px 32px; }
        h2 { color: #f8a100; text-align: center; margin-bottom: 30px; }
        .info-row { margin-bottom: 18px; display: flex; align-items: center; }
        .info-label { width: 160px; color: #dac446; font-weight: bold; }
        .info-value { flex: 1; color: #fff; }
        input { width: 100%; padding: 8px; margin: 5px 0; border-radius: 4px; border: 1px solid #444; background: #2c3136; color: #fff; }
        input:focus { outline: none; border-color: #f8a100; }
        .actions { text-align: center; margin-top: 30px; }
        .actions a, .actions button { display: inline-block; background: #f8a100; color: #fff; padding: 10px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; border: none; cursor: pointer; margin: 0 8px; }
        .actions a:hover, .actions button:hover { background: #e67e22; }
        .actions a.back { background: #666; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="box">
        <h2>Đổi mật khẩu</h2>
        <?php echo $message; ?>
        <form method="POST">
            <div class="info-row">
                <span class="info-label">Mật khẩu hiện tại:</span>
                <input type="password" name="current_password" required>
            </div>
            <div class="info-row">
                <span class="info-label">Mật khẩu mới:</span>
                <input type="password" name="new_password" required>
            </div>
            <div class="info-row">
                <span class="info-label">Xác nhận mật khẩu mới:</span>
                <input type="password" name="confirm_password" required>
            </div>
            <div class="actions">
                <button type="submit" name="change_password">Lưu mật khẩu</button>
                <a href="thong_tin_ca_nhan.php" class="back">Quay lại</a>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 