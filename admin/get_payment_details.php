<?php
session_start();
include 'connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    die("Unauthorized access");
}

if (!isset($_GET['ma_thanh_toan'])) {
    die("Missing payment ID");
}

$ma_thanh_toan = $_GET['ma_thanh_toan'];

// Lấy thông tin chi tiết thanh toán
$stmt = $conn->prepare("
    SELECT tt.*, dt.ma_don_thue, dt.ngay_thue, dt.ngay_tra,
           nd.ho_ten as ten_nguoi_dung, nd.so_dien_thoai, nd.email, nd.dia_chi,
           GROUP_CONCAT(
               CONCAT(
                   xm.hang_xe, ' ', xm.dong_xe, ' (', xm.bien_so, ')',
                   ' - ', FORMAT(ctdt.thanh_tien, 0), ' VNĐ'
               ) SEPARATOR '<br>'
           ) as chi_tiet_xe,
           SUM(ctdt.thanh_tien) as tong_tien
    FROM thanh_toan tt
    JOIN don_thue dt ON tt.ma_don_thue = dt.ma_don_thue
    JOIN nguoi_dung nd ON dt.ma_nguoi_dung = nd.ma_nguoi_dung
    JOIN chi_tiet_don_thue ctdt ON dt.ma_don_thue = ctdt.ma_don_thue
    JOIN xe_may xm ON ctdt.ma_xe = xm.ma_xe
    WHERE tt.ma_thanh_toan = ?
    GROUP BY tt.ma_thanh_toan
");

$stmt->bind_param("i", $ma_thanh_toan);
$stmt->execute();
$payment = $stmt->get_result()->fetch_assoc();

if (!$payment) {
    die("Payment not found");
}

// Format dates
$ngay_tao = date('d/m/Y H:i', strtotime($payment['ngay_tao']));
$ngay_thue = date('d/m/Y', strtotime($payment['ngay_thue']));
$ngay_tra = date('d/m/Y', strtotime($payment['ngay_tra']));

// Format payment method
$phuong_thuc = '';
switch ($payment['phuong_thuc']) {
    case 'tien_mat':
        $phuong_thuc = '<i class="fas fa-money-bill"></i> Tiền mặt';
        break;
    case 'chuyen_khoan':
        $phuong_thuc = '<i class="fas fa-university"></i> Chuyển khoản';
        break;
    case 'momo':
        $phuong_thuc = '<i class="fas fa-wallet"></i> MoMo';
        break;
    case 'zalopay':
        $phuong_thuc = '<i class="fas fa-wallet"></i> ZaloPay';
        break;
}

// Format status
$trang_thai = '';
switch ($payment['trang_thai']) {
    case 'cho_xac_nhan':
        $trang_thai = '<span class="badge bg-warning">Chờ xác nhận</span>';
        break;
    case 'da_thanh_toan':
        $trang_thai = '<span class="badge bg-success">Đã thanh toán</span>';
        break;
    case 'da_huy':
        $trang_thai = '<span class="badge bg-danger">Đã hủy</span>';
        break;
}
?>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-6">
            <h6 class="mb-3">Thông tin thanh toán</h6>
            <table class="table table-sm">
                <tr>
                    <th>Mã thanh toán:</th>
                    <td><?php echo $payment['ma_thanh_toan']; ?></td>
                </tr>
                <tr>
                    <th>Mã đơn thuê:</th>
                    <td><?php echo $payment['ma_don_thue']; ?></td>
                </tr>
                <tr>
                    <th>Ngày thanh toán:</th>
                    <td><?php echo $ngay_tao; ?></td>
                </tr>
                <tr>
                    <th>Phương thức:</th>
                    <td><?php echo $phuong_thuc; ?></td>
                </tr>
                <tr>
                    <th>Trạng thái:</th>
                    <td><?php echo $trang_thai; ?></td>
                </tr>
                <tr>
                    <th>Tổng tiền:</th>
                    <td class="fw-bold"><?php echo number_format($payment['tong_tien'], 0, ',', '.'); ?> VNĐ</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h6 class="mb-3">Thông tin khách hàng</h6>
            <table class="table table-sm">
                <tr>
                    <th>Họ tên:</th>
                    <td><?php echo htmlspecialchars($payment['ten_nguoi_dung']); ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    <td><?php echo htmlspecialchars($payment['so_dien_thoai']); ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo htmlspecialchars($payment['email']); ?></td>
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    <td><?php echo htmlspecialchars($payment['dia_chi']); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h6 class="mb-3">Chi tiết đơn thuê</h6>
            <table class="table table-sm">
                <tr>
                    <th>Ngày thuê:</th>
                    <td><?php echo $ngay_thue; ?></td>
                </tr>
                <tr>
                    <th>Ngày trả:</th>
                    <td><?php echo $ngay_tra; ?></td>
                </tr>
                <tr>
                    <th>Danh sách xe:</th>
                    <td><?php echo $payment['chi_tiet_xe']; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if ($payment['ghi_chu']): ?>
    <div class="row mt-3">
        <div class="col-12">
            <h6 class="mb-2">Ghi chú:</h6>
            <p class="text-muted"><?php echo nl2br(htmlspecialchars($payment['ghi_chu'])); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div> 