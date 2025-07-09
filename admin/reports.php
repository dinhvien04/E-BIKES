<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    header("Location: ../dang_nhap.php");
    exit;
}

// Lấy thống kê tổng quan
$stats = $conn->query("
    SELECT 
        (SELECT COUNT(*) FROM nguoi_dung) as total_users,
        (SELECT COUNT(*) FROM xe_may) as total_vehicles,
        (SELECT COUNT(*) FROM don_thue) as total_rentals,
        (SELECT COUNT(*) FROM don_thue WHERE tinh_trang = 'hoan_thanh') as completed_rentals,
        (SELECT COUNT(*) FROM don_thue WHERE tinh_trang = 'dang_thue') as active_rentals,
        (SELECT SUM(thanh_tien) FROM chi_tiet_don_thue ctdt 
         JOIN don_thue dt ON ctdt.ma_don_thue = dt.ma_don_thue 
         WHERE dt.tinh_trang = 'hoan_thanh') as total_revenue
")->fetch_assoc();

// Lấy doanh thu theo tháng trong năm hiện tại
$monthly_revenue = $conn->query("
    SELECT 
        MONTH(dt.ngay_tao) as thang,
        SUM(ctdt.thanh_tien) as doanh_thu
    FROM don_thue dt
    JOIN chi_tiet_don_thue ctdt ON dt.ma_don_thue = ctdt.ma_don_thue
    WHERE YEAR(dt.ngay_tao) = YEAR(CURRENT_DATE)
    AND dt.tinh_trang = 'hoan_thanh'
    GROUP BY MONTH(dt.ngay_tao)
    ORDER BY thang
");

// Lấy top 5 xe được thuê nhiều nhất
$top_vehicles = $conn->query("
    SELECT 
        xm.hang_xe,
        xm.dong_xe,
        COUNT(*) as so_lan_thue,
        SUM(ctdt.thanh_tien) as tong_doanh_thu
    FROM xe_may xm
    JOIN chi_tiet_don_thue ctdt ON xm.ma_xe = ctdt.ma_xe
    JOIN don_thue dt ON ctdt.ma_don_thue = dt.ma_don_thue
    WHERE dt.tinh_trang = 'hoan_thanh'
    GROUP BY xm.ma_xe
    ORDER BY so_lan_thue DESC
    LIMIT 5
");

// Lấy top 5 khách hàng thuê nhiều nhất
$top_customers = $conn->query("
    SELECT 
        nd.ho_ten,
        nd.so_dien_thoai,
        COUNT(*) as so_lan_thue,
        SUM(ctdt.thanh_tien) as tong_chi_tieu
    FROM nguoi_dung nd
    JOIN don_thue dt ON nd.ma_nguoi_dung = dt.ma_nguoi_dung
    JOIN chi_tiet_don_thue ctdt ON dt.ma_don_thue = ctdt.ma_don_thue
    WHERE dt.tinh_trang = 'hoan_thanh'
    GROUP BY nd.ma_nguoi_dung
    ORDER BY tong_chi_tieu DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo - E-BIKES Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--secondary-color);
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .chart-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .table th {
            background-color: var(--secondary-color);
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
                    <a class="nav-link" href="rentals.php">
                        <i class="fas fa-file-invoice"></i> Quản lý đơn thuê
                    </a>
                    <a class="nav-link" href="payments.php">
                        <i class="fas fa-money-bill"></i> Quản lý thanh toán
                    </a>
                    <a class="nav-link active" href="reports.php">
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
                        <span class="navbar-brand">Báo cáo thống kê</span>
                        <div class="user-info">
                            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_name']); ?>&background=random" alt="Admin">
                        </div>
                    </div>
                </nav>

                <!-- Thống kê tổng quan -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-value"><?php echo number_format($stats['total_users']); ?></div>
                                    <div class="stat-label">Tổng người dùng</div>
                                </div>
                                <i class="fas fa-users stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-value"><?php echo number_format($stats['total_vehicles']); ?></div>
                                    <div class="stat-label">Tổng xe</div>
                                </div>
                                <i class="fas fa-motorcycle stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-value"><?php echo number_format($stats['total_rentals']); ?></div>
                                    <div class="stat-label">Tổng đơn thuê</div>
                                </div>
                                <i class="fas fa-file-invoice stat-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="stat-value"><?php echo number_format($stats['total_revenue'], 0, ',', '.'); ?> VNĐ</div>
                                    <div class="stat-label">Tổng doanh thu</div>
                                </div>
                                <i class="fas fa-money-bill-wave stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ doanh thu theo tháng -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="chart-container">
                            <h5 class="mb-4">Doanh thu theo tháng (<?php echo date('Y'); ?>)</h5>
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <h5 class="mb-4">Trạng thái đơn thuê</h5>
                            <canvas id="rentalStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top xe và khách hàng -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h5 class="mb-4">Top 5 xe được thuê nhiều nhất</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Xe</th>
                                            <th>Số lần thuê</th>
                                            <th>Doanh thu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($vehicle = $top_vehicles->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($vehicle['hang_xe'] . ' ' . $vehicle['dong_xe']); ?></td>
                                            <td><?php echo $vehicle['so_lan_thue']; ?></td>
                                            <td><?php echo number_format($vehicle['tong_doanh_thu'], 0, ',', '.'); ?> VNĐ</td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h5 class="mb-4">Top 5 khách hàng thuê nhiều nhất</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Khách hàng</th>
                                            <th>Số lần thuê</th>
                                            <th>Tổng chi tiêu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($customer = $top_customers->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($customer['ho_ten']); ?><br>
                                                <small class="text-muted"><?php echo htmlspecialchars($customer['so_dien_thoai']); ?></small>
                                            </td>
                                            <td><?php echo $customer['so_lan_thue']; ?></td>
                                            <td><?php echo number_format($customer['tong_chi_tieu'], 0, ',', '.'); ?> VNĐ</td>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Biểu đồ doanh thu theo tháng
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: <?php 
                    $months = [];
                    $revenues = [];
                    while ($row = $monthly_revenue->fetch_assoc()) {
                        $months[] = 'Tháng ' . $row['thang'];
                        $revenues[] = $row['doanh_thu'];
                    }
                    echo json_encode($months);
                ?>,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: <?php echo json_encode($revenues); ?>,
                    borderColor: '#f8a100',
                    backgroundColor: 'rgba(248, 161, 0, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' VNĐ';
                            }
                        }
                    }
                }
            }
        });

        // Biểu đồ trạng thái đơn thuê
        const statusCtx = document.getElementById('rentalStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hoàn thành', 'Đang thuê', 'Đã hủy'],
                datasets: [{
                    data: [
                        <?php echo $stats['completed_rentals']; ?>,
                        <?php echo $stats['active_rentals']; ?>,
                        <?php echo $stats['total_rentals'] - $stats['completed_rentals'] - $stats['active_rentals']; ?>
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#17a2b8',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html> 