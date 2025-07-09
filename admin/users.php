<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin' || $_SESSION['user_type'] !== 'nhan_vien') {
    header("Location: ../dang_nhap.php");
    exit;
}

// Xử lý thêm người dùng mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $dia_chi = $_POST['dia_chi'];
        $cccd = $_POST['cccd'];
        $ngay_sinh = $_POST['ngay_sinh'];

        $stmt = $conn->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, dia_chi, cccd, ngay_sinh) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $ho_ten, $email, $mat_khau, $so_dien_thoai, $dia_chi, $cccd, $ngay_sinh);
        
        if ($stmt->execute()) {
            $success_message = "Thêm người dùng thành công!";
        } else {
            $error_message = "Lỗi khi thêm người dùng: " . $conn->error;
        }
    }
    // Xử lý cập nhật người dùng
    elseif ($_POST['action'] == 'edit') {
        $ma_nguoi_dung = $_POST['ma_nguoi_dung'];
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $dia_chi = $_POST['dia_chi'];
        $cccd = $_POST['cccd'];
        $ngay_sinh = $_POST['ngay_sinh'];

        $stmt = $conn->prepare("UPDATE nguoi_dung SET ho_ten=?, email=?, so_dien_thoai=?, dia_chi=?, cccd=?, ngay_sinh=? WHERE ma_nguoi_dung=?");
        $stmt->bind_param("ssssssi", $ho_ten, $email, $so_dien_thoai, $dia_chi, $cccd, $ngay_sinh, $ma_nguoi_dung);
        
        if ($stmt->execute()) {
            $success_message = "Cập nhật người dùng thành công!";
        } else {
            $error_message = "Lỗi khi cập nhật người dùng: " . $conn->error;
        }
    }
    // Xử lý xóa người dùng
    elseif ($_POST['action'] == 'delete') {
        $ma_nguoi_dung = $_POST['ma_nguoi_dung'];
        
        $stmt = $conn->prepare("DELETE FROM nguoi_dung WHERE ma_nguoi_dung=?");
        $stmt->bind_param("i", $ma_nguoi_dung);
        
        if ($stmt->execute()) {
            $success_message = "Xóa người dùng thành công!";
        } else {
            $error_message = "Lỗi khi xóa người dùng: " . $conn->error;
        }
    }
}

// Lấy danh sách người dùng
$users = $conn->query("SELECT * FROM nguoi_dung ORDER BY ngay_tao DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng - E-BIKES Admin</title>
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
                    <a class="nav-link active" href="users.php">
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
                        <span class="navbar-brand">Quản lý người dùng</span>
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

                <!-- Add User Button -->
                <div class="mb-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i> Thêm người dùng mới
                    </button>
                </div>

                <!-- Users Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
                                        <th>CCCD</th>
                                        <th>Ngày sinh</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = $users->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $user['ma_nguoi_dung']; ?></td>
                                        <td><?php echo htmlspecialchars($user['ho_ten']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['so_dien_thoai'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['dia_chi'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($user['cccd'] ?? 'N/A'); ?></td>
                                        <td><?php echo $user['ngay_sinh'] ? date('d/m/Y', strtotime($user['ngay_sinh'])) : 'N/A'; ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($user['ngay_tao'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="editUser(<?php echo htmlspecialchars(json_encode($user)); ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?php echo $user['ma_nguoi_dung']; ?>)">
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

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm người dùng mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" method="POST">
                        <input type="hidden" name="action" value="add">
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="ho_ten" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" name="mat_khau" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="so_dien_thoai">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea class="form-control" name="dia_chi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CCCD</label>
                            <input type="text" class="form-control" name="cccd">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" name="ngay_sinh">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="addUserForm" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="ma_nguoi_dung" id="edit_ma_nguoi_dung">
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="ho_ten" id="edit_ho_ten" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" name="so_dien_thoai" id="edit_so_dien_thoai">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea class="form-control" name="dia_chi" id="edit_dia_chi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CCCD</label>
                            <input type="text" class="form-control" name="cccd" id="edit_cccd">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" name="ngay_sinh" id="edit_ngay_sinh">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="editUserForm" class="btn btn-primary">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa người dùng này?</p>
                    <form id="deleteUserForm" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="ma_nguoi_dung" id="delete_ma_nguoi_dung">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" form="deleteUserForm" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(user) {
            document.getElementById('edit_ma_nguoi_dung').value = user.ma_nguoi_dung;
            document.getElementById('edit_ho_ten').value = user.ho_ten;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_so_dien_thoai').value = user.so_dien_thoai || '';
            document.getElementById('edit_dia_chi').value = user.dia_chi || '';
            document.getElementById('edit_cccd').value = user.cccd || '';
            document.getElementById('edit_ngay_sinh').value = user.ngay_sinh || '';
            
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }

        function deleteUser(userId) {
            document.getElementById('delete_ma_nguoi_dung').value = userId;
            new bootstrap.Modal(document.getElementById('deleteUserModal')).show();
        }
    </script>
</body>
</html> 