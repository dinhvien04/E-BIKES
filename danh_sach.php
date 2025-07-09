<?php
require 'connect.php';

$loai_xe_list = ['Xe số', 'Xe ga', 'Xe côn tay', 'Phân khối lớn'];

$loai_xe_filter = isset($_GET['loai_xe']) ? $_GET['loai_xe'] : null;
$search_term = isset($_GET['search']) ? trim($_GET['search']) : null;

$sql = "
    SELECT xm.ma_xe, xm.hang_xe, xm.dong_xe, ct.loai_xe, xm.gia_thue, xm.duong_dan_anh
    FROM xe_may xm
    JOIN chi_tiet_xe ct ON xm.ma_xe = ct.ma_xe
";
$conditions = [];
$params = [];
$types = '';

if ($loai_xe_filter) {
    $conditions[] = "ct.loai_xe = ?";
    $params[] = $loai_xe_filter;
    $types .= 's';
}

if ($search_term) {
    $conditions[] = "xm.dong_xe LIKE ?";
    $params[] = '%' . $search_term . '%';
    $types .= 's';
}

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Danh Sách Xe - E-BIKES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/danhsach.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div class="logo">E-BIKES</div>
    <section id="danh-muc">
        <button>☰ Danh mục xe</button>
        <ul>
            <li><a href="?">Tất cả xe</a></li>
            <?php foreach ($loai_xe_list as $lx): ?>
                <li><a href="?loai_xe=<?= urlencode($lx) ?>"><?= htmlspecialchars($lx) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <div class="search-section">
  <form method="GET" action="">
    <input type="search" name="search" placeholder="Tìm kiếm xe..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"/>
    <button type="submit">Tìm</button>
  </form>
</div>

    <nav>
    <ul>
        <li><a href="#">Trang chủ</a></li>
        <li><a href="#">Giới thiệu</a></li>
        <li class="dropdown">
            <a href="#">Chính sách <i class="fas fa-caret-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="chinh_sach_thue_xe.php">Chính sách thuê xe máy</a></li>
                <li><a href="chinh_sach_khach_hang_than_thiet.php">Chính sách khách hàng thân thiết</a></li>
            </ul>
        </li>
        <li><a href="#">Liên hệ</a></li>
    </ul>
</nav>
</header>
<!-- DANH SÁCH XE -->
<section class="grid">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card">
            <?php 
            $duong_dan_anh = $row['duong_dan_anh'] ?: 'https://via.placeholder.com/400x300.png?text=No+Image';
            ?>
            <img src="<?= htmlspecialchars($duong_dan_anh) ?>" alt="<?= htmlspecialchars($row['dong_xe']) ?>">
            <h3><?= htmlspecialchars($row['dong_xe']) ?></h3>
            <p><strong>Hãng:</strong> <?= htmlspecialchars($row['hang_xe']) ?></p>
            <p class="price"><?= number_format($row['gia_thue'], 0, ',', '.') ?>đ / ngày</p>
            <a href="chi_tiet_xe.php?ma_xe=<?= $row['ma_xe'] ?>" class="button">Xem chi tiết</a>
        </div>
    <?php endwhile; ?>
</section>

<footer>
    <div class="footer-container">
        <div class="footer-column">
            <h3>Về Chúng Tôi</h3>
            <p>Dịch vụ cho thuê xe chất lượng cao - E-BIKES – Bật khóa, bung hành trình!.</p>
        </div>
        <div class="footer-column">
            <h3>Hỗ Trợ</h3>
            <ul>
                <li><a href="#">Câu hỏi thường gặp</a></li>
                <li><a href="#">Hướng dẫn thuê xe</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Chính Sách</h3>
            <ul>
                <li><a href="chinh_sach_thue_xe.php">Chính sách thuê xe máy </a></li>
                <li><a href="chinh_sach_khach_hang_than_thiet.php">Chính sách khách hàng thân thiết </a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Kết Nối</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p>📞 Hotline: 1900 1234</p>
            <p>📧 Email: support@E-BIKES.com</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Bản quyền thuộc về E-BIKES.</p>
    </div>
</footer>
<?php $conn->close(); ?>
</body>
</html>
