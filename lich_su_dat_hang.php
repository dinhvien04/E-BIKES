<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: dang_nhap.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// Lấy lịch sử đơn hàng từ don_thue và chi_tiet_don_thue, gom các xe lại 1 dòng
$order_sql = "SELECT d.ma_don_thue, GROUP_CONCAT(c.ma_xe) as ds_ma_xe, d.ngay_tao, d.ngay_thue, d.ngay_tra, d.tong_tien, d.tinh_trang
              FROM don_thue d
              LEFT JOIN chi_tiet_don_thue c ON d.ma_don_thue = c.ma_don_thue
              WHERE d.ma_nguoi_dung = ?
              GROUP BY d.ma_don_thue
              ORDER BY d.ngay_tao DESC";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param('i', $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử đặt hàng</title>
    <link rel="stylesheet" href="css/vidu.css">
    <style>
        body { background: #23272b; color: #fff; font-family: Arial, sans-serif; }
        .box { max-width: 900px; margin: 60px auto; background: #31363b; border-radius: 12px; box-shadow: 0 4px 16px #0003; padding: 36px 32px; }
        h2 { color: #f8a100; text-align: center; margin-bottom: 30px; }
        table { width: 100%; background: #23272b; color: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0002; }
        th, td { padding: 10px 8px; text-align: center; }
        th { background: #31363b; color: #dac446; }
        tr:nth-child(even) { background: #282c30; }
        tr:hover { background: #383c40; }
        .actions { text-align: center; margin-top: 30px; }
        .actions a { display: inline-block; background: #666; color: #fff; padding: 10px 28px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.3s; border: none; cursor: pointer; }
        .actions a:hover { background: #e67e22; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="box">
        <h2>Lịch sử đặt hàng</h2>
        <?php if ($order_result->num_rows > 0): ?>
        <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Mã xe</th>
                    <th>Ngày đặt</th>
                    <th>Nhận xe</th>
                    <th>Trả xe</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = $order_result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $order['ma_don_thue']; ?></td>
                    <td><?php echo $order['ds_ma_xe']; ?></td>
                    <td><?php echo $order['ngay_tao']; ?></td>
                    <td><?php echo $order['ngay_thue']; ?></td>
                    <td><?php echo $order['ngay_tra']; ?></td>
                    <td><?php echo number_format($order['tong_tien'], 0, ',', '.'); ?>đ</td>
                    <td>
                        <?php
                        if ($order['tinh_trang'] == 'da_dat') echo '<span style="color:#f8a100;">Chờ xử lý</span>';
                        elseif ($order['tinh_trang'] == 'dang_thue') echo '<span style="color:#4caf50;">Đang thuê</span>';
                        elseif ($order['tinh_trang'] == 'hoan_thanh') echo '<span style="color:#4caf50;">Hoàn thành</span>';
                        elseif ($order['tinh_trang'] == 'da_huy') echo '<span style="color:#e53935;">Đã hủy</span>';
                        else echo htmlspecialchars($order['tinh_trang']);
                        ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
        <?php else: ?>
            <div style="margin-top:24px;text-align:center;color:#dac446;">Bạn chưa có đơn đặt xe nào.</div>
        <?php endif; ?>
        <div class="actions">
            <a href="thong_tin_ca_nhan.php">Quay lại</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 