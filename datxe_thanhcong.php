<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: dang_nhap.php');
    exit;
}
require 'connect.php';
$user_id = $_SESSION['user_id'];
// Lấy lịch sử đơn đặt xe của user
$sql = "SELECT * FROM don_thue WHERE ma_nguoi_dung = ? ORDER BY ngay_tao DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt xe thành công</title>
    <link rel="stylesheet" href="css/dx.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="main-container">
        <div class="message success" style="margin: 30px 0; font-size: 1.3em; text-align: center;">
            🎉 <strong>Đặt xe thành công!</strong> Cảm ơn bạn đã sử dụng dịch vụ.
        </div>
        <h2 style="text-align:center;">Lịch sử đơn đặt xe của bạn</h2>
        <table style="width:100%;margin:0 auto;max-width:900px;">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày thuê</th>
                    <th>Ngày trả</th>
                    <th>Tổng tiền</th>
                    <th>Tình trạng</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['ma_don_thue']) ?></td>
                    <td><?= htmlspecialchars($row['ngay_thue']) ?></td>
                    <td><?= htmlspecialchars($row['ngay_tra']) ?></td>
                    <td><?= number_format($row['tong_tien'], 0, ',', '.') ?>đ</td>
                    <td><?= htmlspecialchars($row['tinh_trang']) ?></td>
                    <td><?= htmlspecialchars($row['ngay_tao']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div style="text-align:center;margin:30px;">
            <a href="trangchu.php" class="btn">Về trang chủ</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 