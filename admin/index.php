<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    header("Location: ../dang_nhap.php");
    exit;
}

// Lấy thông tin admin
$admin_id = $_SESSION['user_id'];
$admin_name = $_SESSION['user_name'];

// Lấy thông tin chi tiết nhân viên
$stmt = $conn->prepare("SELECT * FROM nhan_vien WHERE ma_nhan_vien = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin_info = $stmt->get_result()->fetch_assoc();

// Lấy số liệu thống kê
$stats = [
    'total_users' => 0,
    'total_vehicles' => 0,
    'total_rentals' => 0,
    'total_revenue' => 0
];

// Đếm tổng số người dùng
$result = $conn->query("SELECT COUNT(*) as count FROM nguoi_dung");
if ($row = $result->fetch_assoc()) {
    $stats['total_users'] = $row['count'];
}

// Đếm tổng số xe
$result = $conn->query("SELECT COUNT(*) as count FROM xe_may");
if ($row = $result->fetch_assoc()) {
    $stats['total_vehicles'] = $row['count'];
}

// Đếm tổng số đơn thuê
$result = $conn->query("SELECT COUNT(*) as count FROM don_thue");
if ($row = $result->fetch_assoc()) {
    $stats['total_rentals'] = $row['count'];
}

// Tính tổng doanh thu
$result = $conn->query("SELECT SUM(tong_tien) as total FROM don_thue WHERE tinh_trang = 'hoan_thanh'");
if ($row = $result->fetch_assoc()) {
    $stats['total_revenue'] = $row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-BIKES</title>
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

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--secondary-color);
        }

        .stat-card .stat-label {
            color: #666;
            font-size: 0.9rem;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <h3 class="mb-4">E-BIKES Admin</h3>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="index.php">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link" href="users.php">
                        <i class="fas fa-users"></i> Quản lý người dùng
                    </a>
                    <a class="nav-link" href="vehicles.php">
                        <i class="fas fa-motorcycle"></i> Quản lý xe
                    </a>
                    <a class="nav-link" href="rentals.php">
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
                        <span class="navbar-brand">Dashboard</span>
                        <div class="user-info">
                            <span>Xin chào, <?php echo htmlspecialchars($admin_name); ?> (<?php echo htmlspecialchars($admin_info['chuc_vu']); ?>)</span>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin_name); ?>&background=random" alt="Admin">
                        </div>
                    </div>
                </nav>

                <!-- Statistics Cards -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-users"></i>
                            <div class="stat-value"><?php echo number_format($stats['total_users']); ?></div>
                            <div class="stat-label">Tổng số người dùng</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-motorcycle"></i>
                            <div class="stat-value"><?php echo number_format($stats['total_vehicles']); ?></div>
                            <div class="stat-label">Tổng số xe</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-file-invoice"></i>
                            <div class="stat-value"><?php echo number_format($stats['total_rentals']); ?></div>
                            <div class="stat-label">Tổng số đơn thuê</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <i class="fas fa-money-bill-wave"></i>
                            <div class="stat-value"><?php echo number_format($stats['total_revenue']); ?> VNĐ</div>
                            <div class="stat-label">Tổng doanh thu</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Đơn thuê gần đây</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Người thuê</th>
                                                <th>Ngày thuê</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $conn->query("
                                                SELECT dt.*, nd.ho_ten 
                                                FROM don_thue dt 
                                                JOIN nguoi_dung nd ON dt.ma_nguoi_dung = nd.ma_nguoi_dung 
                                                ORDER BY dt.ngay_tao DESC 
                                                LIMIT 5
                                            ");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>#" . $row['ma_don_thue'] . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ho_ten']) . "</td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row['ngay_thue'])) . "</td>";
                                                echo "<td><span class='badge bg-" . 
                                                    ($row['tinh_trang'] == 'hoan_thanh' ? 'success' : 
                                                    ($row['tinh_trang'] == 'dang_thue' ? 'warning' : 
                                                    ($row['tinh_trang'] == 'da_huy' ? 'danger' : 'primary'))) . 
                                                    "'>" . $row['tinh_trang'] . "</span></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Người dùng mới</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên</th>
                                                <th>Email</th>
                                                <th>Ngày đăng ký</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = $conn->query("
                                                SELECT * FROM nguoi_dung 
                                                ORDER BY ngay_tao DESC 
                                                LIMIT 5
                                            ");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['ho_ten']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                echo "<td>" . date('d/m/Y', strtotime($row['ngay_tao'])) . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 