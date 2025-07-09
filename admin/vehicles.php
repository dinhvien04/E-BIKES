<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    header("Location: ../dang_nhap.php");
    exit;
}

// Xử lý thêm xe mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $ten_xe = $_POST['ten_xe'];
        $loai_xe = $_POST['loai_xe'];
        $bien_so = $_POST['bien_so'];
        $mau_sac = $_POST['mau_sac'];
        $nam_san_xuat = $_POST['nam_san_xuat'];
        $gia_thue = $_POST['gia_thue'];
        $trang_thai = $_POST['trang_thai'];
        $mo_ta = $_POST['mo_ta'];

        // Xử lý upload hình ảnh
        $hinh_anh = '';
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
            $target_dir = "../uploads/vehicles/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_extension = strtolower(pathinfo($_FILES["hinh_anh"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
                $hinh_anh = "uploads/vehicles/" . $new_filename;
            }
        }

        $stmt = $conn->prepare("INSERT INTO xe (ten_xe, loai_xe, bien_so, mau_sac, nam_san_xuat, gia_thue, trang_thai, mo_ta, hinh_anh) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssdis", $ten_xe, $loai_xe, $bien_so, $mau_sac, $nam_san_xuat, $gia_thue, $trang_thai, $mo_ta, $hinh_anh);
        
        if ($stmt->execute()) {
            $success_message = "Thêm xe thành công!";
        } else {
            $error_message = "Lỗi khi thêm xe: " . $conn->error;
        }
    }
    // Xử lý cập nhật xe
    elseif ($_POST['action'] == 'edit') {
        $ma_xe = $_POST['ma_xe'];
        $ten_xe = $_POST['ten_xe'];
        $loai_xe = $_POST['loai_xe'];
        $bien_so = $_POST['bien_so'];
        $mau_sac = $_POST['mau_sac'];
        $nam_san_xuat = $_POST['nam_san_xuat'];
        $gia_thue = $_POST['gia_thue'];
        $trang_thai = $_POST['trang_thai'];
        $mo_ta = $_POST['mo_ta'];

        // Xử lý upload hình ảnh mới nếu có
        $hinh_anh = $_POST['hinh_anh_cu'];
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
            $target_dir = "../uploads/vehicles/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_extension = strtolower(pathinfo($_FILES["hinh_anh"]["name"], PATHINFO_EXTENSION));
            $new_filename = uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
                // Xóa hình ảnh cũ nếu có
                if (!empty($hinh_anh) && file_exists("../" . $hinh_anh)) {
                    unlink("../" . $hinh_anh);
                }
                $hinh_anh = "uploads/vehicles/" . $new_filename;
            }
        }

        $stmt = $conn->prepare("UPDATE xe SET ten_xe=?, loai_xe=?, bien_so=?, mau_sac=?, nam_san_xuat=?, gia_thue=?, trang_thai=?, mo_ta=?, hinh_anh=? WHERE ma_xe=?");
        $stmt->bind_param("sssssdisi", $ten_xe, $loai_xe, $bien_so, $mau_sac, $nam_san_xuat, $gia_thue, $trang_thai, $mo_ta, $hinh_anh, $ma_xe);
        
        if ($stmt->execute()) {
            $success_message = "Cập nhật xe thành công!";
        } else {
            $error_message = "Lỗi khi cập nhật xe: " . $conn->error;
        }
    }
    // Xử lý xóa xe
    elseif ($_POST['action'] == 'delete') {
        $ma_xe = $_POST['ma_xe'];
        
        // Lấy thông tin hình ảnh trước khi xóa
        $stmt = $conn->prepare("SELECT hinh_anh FROM xe WHERE ma_xe=?");
        $stmt->bind_param("i", $ma_xe);
        $stmt->execute();
        $result = $stmt->get_result();
        $xe = $result->fetch_assoc();
        
        // Xóa xe
        $stmt = $conn->prepare("DELETE FROM xe WHERE ma_xe=?");
        $stmt->bind_param("i", $ma_xe);
        
        if ($stmt->execute()) {
            // Xóa hình ảnh nếu có
            if (!empty($xe['hinh_anh']) && file_exists("../" . $xe['hinh_anh'])) {
                unlink("../" . $xe['hinh_anh']);
            }
            $success_message = "Xóa xe thành công!";
        } else {
            $error_message = "Lỗi khi xóa xe: " . $conn->error;
        }
    }
}

// Lấy danh sách xe
$vehicles = $conn->query("SELECT * FROM xe_may ORDER BY ma_xe DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý xe - E-BIKES Admin</title>
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

        .vehicle-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8em;
        }

        .status-available {
            background-color: #28a745;
            color: white;
        }

        .status-rented {
            background-color: #dc3545;
            color: white;
        }

        .status-maintenance {
            background-color: #ffc107;
            color: black;
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
                    <a class="nav-link active" href="vehicles.php">
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
                        <span class="navbar-brand">Quản lý xe</span>
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

                <!-- Add Vehicle Button -->
                <div class="mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                        <i class="fas fa-plus"></i> Thêm xe mới
                    </button>
                </div>

                <!-- Vehicles Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Hình ảnh</th>
                                        <th>Hãng xe</th>
                                        <th>Dòng xe</th>
                                        <th>Biển số</th>
                                        <th>Giá thuê</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($vehicle = $vehicles->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $vehicle['ma_xe']; ?></td>
                                        <td>
                                            <?php if (!empty($vehicle['duong_dan_anh'])): ?>
                                                <img src="../<?php echo htmlspecialchars($vehicle['duong_dan_anh']); ?>" class="vehicle-image" alt="Xe">
                                            <?php else: ?>
                                                <img src="https://via.placeholder.com/100" class="vehicle-image" alt="No image">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($vehicle['hang_xe']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['dong_xe']); ?></td>
                                        <td><?php echo htmlspecialchars($vehicle['bien_so']); ?></td>
                                        <td><?php echo number_format($vehicle['gia_thue'], 0, ',', '.'); ?> VNĐ</td>
                                        <td>
                                            <?php
                                            $status_class = '';
                                            $status_text = '';
                                            switch ($vehicle['trang_thai']) {
                                                case 'con_trong':
                                                    $status_class = 'status-available';
                                                    $status_text = 'Có sẵn';
                                                    break;
                                                case 'da_thue':
                                                    $status_class = 'status-rented';
                                                    $status_text = 'Đang thuê';
                                                    break;
                                                case 'bao_tri':
                                                    $status_class = 'status-maintenance';
                                                    $status_text = 'Bảo trì';
                                                    break;
                                            }
                                            ?>
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo $status_text; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editVehicle(<?php echo htmlspecialchars(json_encode($vehicle)); ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteVehicle(<?php echo $vehicle['ma_xe']; ?>)">
                                                <i class="fas fa-trash"></i>
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

    <!-- Add Vehicle Modal -->
    <div class="modal fade" id="addVehicleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm xe mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addVehicleForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label class="form-label">Hãng xe</label>
                            <input type="text" class="form-control" name="hang_xe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dòng xe</label>
                            <input type="text" class="form-control" name="dong_xe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biển số</label>
                            <input type="text" class="form-control" name="bien_so" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thuê (VNĐ)</label>
                            <input type="number" class="form-control" name="gia_thue" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="trang_thai" required>
                                <option value="con_trong">Có sẵn</option>
                                <option value="da_thue">Đang thuê</option>
                                <option value="bao_tri">Bảo trì</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" name="duong_dan_anh" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="addVehicleForm" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Vehicle Modal -->
    <div class="modal fade" id="editVehicleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thông tin xe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editVehicleForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="ma_xe" id="edit_ma_xe">
                        <input type="hidden" name="duong_dan_anh_cu" id="edit_duong_dan_anh_cu">
                        <div class="mb-3">
                            <label class="form-label">Hãng xe</label>
                            <input type="text" class="form-control" name="hang_xe" id="edit_hang_xe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dòng xe</label>
                            <input type="text" class="form-control" name="dong_xe" id="edit_dong_xe" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Biển số</label>
                            <input type="text" class="form-control" name="bien_so" id="edit_bien_so" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thuê (VNĐ)</label>
                            <input type="number" class="form-control" name="gia_thue" id="edit_gia_thue" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select class="form-select" name="trang_thai" id="edit_trang_thai" required>
                                <option value="con_trong">Có sẵn</option>
                                <option value="da_thue">Đang thuê</option>
                                <option value="bao_tri">Bảo trì</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" name="duong_dan_anh" accept="image/*">
                            <small class="text-muted">Để trống nếu không muốn thay đổi hình ảnh</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="editVehicleForm" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Vehicle Modal -->
    <div class="modal fade" id="deleteVehicleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa xe này?</p>
                    <form id="deleteVehicleForm" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="ma_xe" id="delete_ma_xe">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" form="deleteVehicleForm" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editVehicle(vehicle) {
            document.getElementById('edit_ma_xe').value = vehicle.ma_xe;
            document.getElementById('edit_hang_xe').value = vehicle.hang_xe;
            document.getElementById('edit_dong_xe').value = vehicle.dong_xe;
            document.getElementById('edit_bien_so').value = vehicle.bien_so;
            document.getElementById('edit_gia_thue').value = vehicle.gia_thue;
            document.getElementById('edit_trang_thai').value = vehicle.trang_thai;
            document.getElementById('edit_duong_dan_anh_cu').value = vehicle.duong_dan_anh || '';
            
            new bootstrap.Modal(document.getElementById('editVehicleModal')).show();
        }

        function deleteVehicle(vehicleId) {
            document.getElementById('delete_ma_xe').value = vehicleId;
            new bootstrap.Modal(document.getElementById('deleteVehicleModal')).show();
        }
    </script>
</body>
</html> 