<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    header("Location: ../dang_nhap.php");
    exit;
}

// Xử lý cập nhật trạng thái đơn thuê
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'update_status') {
        $ma_don_thue = $_POST['ma_don_thue'];
        $tinh_trang = $_POST['tinh_trang'];
        
        $stmt = $conn->prepare("UPDATE don_thue SET tinh_trang = ? WHERE ma_don_thue = ?");
        $stmt->bind_param("si", $tinh_trang, $ma_don_thue);
        
        if ($stmt->execute()) {
            // Cập nhật trạng thái xe nếu cần
            if ($tinh_trang == 'dang_thue') {
                $stmt = $conn->prepare("UPDATE xe_may SET trang_thai = 'da_thue' WHERE ma_xe IN (SELECT ma_xe FROM chi_tiet_don_thue WHERE ma_don_thue = ?)");
                $stmt->bind_param("i", $ma_don_thue);
                $stmt->execute();
            } elseif ($tinh_trang == 'hoan_thanh') {
                $stmt = $conn->prepare("UPDATE xe_may SET trang_thai = 'con_trong' WHERE ma_xe IN (SELECT ma_xe FROM chi_tiet_don_thue WHERE ma_don_thue = ?)");
                $stmt->bind_param("i", $ma_don_thue);
                $stmt->execute();
            }
            $success_message = "Cập nhật trạng thái đơn thuê thành công!";
        } else {
            $error_message = "Lỗi khi cập nhật trạng thái: " . $conn->error;
        }
    }
}

// Lấy danh sách đơn thuê với thông tin chi tiết
$rentals = $conn->query("
    SELECT dt.*, nd.ho_ten as ten_nguoi_dung, nd.so_dien_thoai,
           GROUP_CONCAT(CONCAT(xm.hang_xe, ' ', xm.dong_xe) SEPARATOR ', ') as danh_sach_xe,
           GROUP_CONCAT(ctdt.so_ngay_thue SEPARATOR ', ') as so_ngay_thue,
           SUM(ctdt.thanh_tien) as tong_tien
    FROM don_thue dt
    JOIN nguoi_dung nd ON dt.ma_nguoi_dung = nd.ma_nguoi_dung
    LEFT JOIN chi_tiet_don_thue ctdt ON dt.ma_don_thue = ctdt.ma_don_thue
    LEFT JOIN xe_may xm ON ctdt.ma_xe = xm.ma_xe
    GROUP BY dt.ma_don_thue
    ORDER BY dt.ngay_tao DESC
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn thuê - E-BIKES Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #f8a100;
            --secondary-color: #2c3e50;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        .sidebar {
            background-color: var(--secondary-color);
            min-height: 100vh;
            padding: 20px;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary-color);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
        }

        .main-content {
            padding: 20px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #e69100;
            border-color: #e69100;
        }

        .table th {
            background-color: var(--secondary-color);
            color: white;
        }

        .modal-header {
            background-color: var(--secondary-color);
            color: white;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }

        .status-pending {
            background-color: #ffc107;
            color: black;
        }

        .status-renting {
            background-color: #17a2b8;
            color: white;
        }

        .status-completed {
            background-color: #28a745;
            color: white;
        }

        .status-cancelled {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h3 class="mb-4">E-BIKES Admin</h3>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i> Quản lý người dùng
                    </a>
                    <a class="nav-link" href="vehicles.php">
                        <i class="fas fa-motorcycle"></i> Quản lý xe
                    </a>
                    <a class="nav-link active" href="rentals.php">
                        <i class="fas fa-file-invoice"></i> Quản lý đơn thuê
                    </a>
                    <a class="nav-link" href="payments.php">
                        <i class="fas fa-money-bill"></i> Quản lý thanh toán
                    </a>
                    <a class="nav-link" href="reports.php">
                        <i class="fas fa-chart-bar"></i> Báo cáo
                    </a>
                    <a class="nav-link" href="../dang_xuat.php">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand">Quản lý đơn thuê</span>
                        <div class="user-info">
                            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=random" alt="Admin">
                        </div>
                    </div>
                </nav>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $success_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Rentals Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>Danh sách xe</th>
                                        <th>Số ngày thuê</th>
                                        <th>Ngày thuê</th>
                                        <th>Ngày trả</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($rental = $rentals->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $rental['ma_don_thue']; ?></td>
                                        <td><?php echo htmlspecialchars($rental['ten_nguoi_dung']); ?></td>
                                        <td><?php echo htmlspecialchars($rental['so_dien_thoai']); ?></td>
                                        <td><?php echo htmlspecialchars($rental['danh_sach_xe']); ?></td>
                                        <td><?php echo htmlspecialchars($rental['so_ngay_thue']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($rental['ngay_thue'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($rental['ngay_tra'])); ?></td>
                                        <td><?php echo number_format($rental['tong_tien'], 0, ',', '.'); ?> VNĐ</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            $status_text = '';
                                            switch ($rental['tinh_trang']) {
                                                case 'da_dat':
                                                    $status_class = 'status-pending';
                                                    $status_text = 'Đã đặt';
                                                    break;
                                                case 'dang_thue':
                                                    $status_class = 'status-renting';
                                                    $status_text = 'Đang thuê';
                                                    break;
                                                case 'hoan_thanh':
                                                    $status_class = 'status-completed';
                                                    $status_text = 'Hoàn thành';
                                                    break;
                                                case 'da_huy':
                                                    $status_class = 'status-cancelled';
                                                    $status_text = 'Đã hủy';
                                                    break;
                                            }
                                            ?>
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="updateStatus(<?php echo $rental['ma_don_thue']; ?>, '<?php echo $rental['tinh_trang']; ?>')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary" onclick="viewDetails(<?php echo $rental['ma_don_thue']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật trạng thái đơn thuê</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStatusForm" method="POST">
                        <input type="hidden" name="action" value="update_status">
                        <input type="hidden" name="ma_don_thue" id="update_ma_don_thue">
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="tinh_trang" id="update_tinh_trang" required>
                                <option value="da_dat">Đã đặt</option>
                                <option value="dang_thue">Đang thuê</option>
                                <option value="hoan_thanh">Hoàn thành</option>
                                <option value="da_huy">Đã hủy</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="updateStatusForm" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết đơn thuê</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="rentalDetails">
                    <!-- Chi tiết đơn thuê sẽ được load bằng AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateStatus(maDonThue, currentStatus) {
            document.getElementById('update_ma_don_thue').value = maDonThue;
            document.getElementById('update_tinh_trang').value = currentStatus;
            new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
        }

        function viewDetails(maDonThue) {
            // Load chi tiết đơn thuê bằng AJAX
            fetch(`get_rental_details.php?ma_don_thue=${maDonThue}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('rentalDetails').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('viewDetailsModal')).show();
                });
        }
    </script>
</body>
</html> 