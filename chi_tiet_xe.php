<?php
include 'connect.php';
if (isset($_GET['ma_xe'])) {
    $ma_xe = $_GET['ma_xe'];

    $sql = "
    SELECT xm.ma_xe, xm.hang_xe, xm.dong_xe, ct.loai_xe, ct.mo_ta, ct.mau_sac, xm.gia_thue, xm.duong_dan_anh, ct.dung_tich_xi_lanh
    FROM xe_may xm
    JOIN chi_tiet_xe ct ON xm.ma_xe = ct.ma_xe
    WHERE xm.ma_xe = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ma_xe); 
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Không tìm thấy thông tin cho mã xe này.";
        exit();
    }
} else {
    echo "Mã xe không hợp lệ.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
     <link rel="stylesheet" href="css/chitiet.css">
    <title><?= htmlspecialchars($row['dong_xe']) ?> - Chi tiết xe</title>
</head>
<body>

    <!-- HEADER -->
    <header>
    <div class="logo">E-BIKES</div>
    <section id="danh-muc">
    <button>☰ Danh mục xe</button>
    <ul>
        <li><a href="danh_sach.php">Tất cả xe</a></li>
        <li><a href="danh_sach.php?loai_xe=Xe số ">Xe số</a></li>
        <li><a href="danh_sach.php?loai_xe=Xe ga">Xe ga</a></li>
        <li><a href="danh_sach.php?loai_xe=Xe côn tay">Xe côn tay</a></li>
        <li><a href="danh_sach.php?loai_xe=Phân khối lớn">Phân khối lớn</a></li>
    </ul>
</section>
    <div class="search-section">
  <form method="GET" action="danh_sach.php">
    <input type="search" name="search" placeholder="Tìm kiếm xe..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"/>
    <button type="submit">Tìm</button>
  </form>
</div>
    <nav>
    <ul>
        <li><a href="trang_chu.php">Trang chủ</a></li>
        <li><a href="gioithieu.php">Giới thiệu</a></li>
        <li class="dropdown">
            <a href="#">Chính sách <i class="fas fa-caret-down"></i></a>
            <ul class="dropdown-menu">
                <li><a href="chinh_sach_thue_xe.php">Chính sách thuê xe máy</a></li>
                <li><a href="chinh_sach_khach_hang_than_thiet.php">Chính sách khách hàng thân thiết</a></li>
            </ul>
        </li>
        <li><a href="lienhe1.php">Liên hệ</a></li>
    </ul>
</nav>
</header>
<!-- CHI TIẾT XE -->
<section class = "container" >

<div class="left">
<?php if ($row): ?>
<img src="<?php echo htmlspecialchars($row['duong_dan_anh']); ?>" alt="<?php echo htmlspecialchars($row['dong_xe']); ?>" />
<h2><?php echo htmlspecialchars($row['dong_xe']); ?></h2>

<div class="info-item">
 <i class="fas fa-car"></i>
 <strong>Hãng xe:</strong> <?php echo htmlspecialchars($row['hang_xe']); ?>
</div>

 <div class="info-item">
<i class="fas fa-paint-brush"></i>
 <strong>Màu sắc:</strong> <?php echo htmlspecialchars($row['mau_sac']); ?>
</div>

<div class="info-item">
 <i class="fas fa-tachometer-alt"></i>
<span><strong>Dung tích xi lanh:</strong> <?php echo htmlspecialchars($row['dung_tich_xi_lanh']); ?>cc</span>
</div>

<div class="info-item">

<i class="fas fa-info-circle"></i>
 <span><strong>Mô tả:</strong> <?php echo htmlspecialchars($row['mo_ta']); ?></span>
</div>
 <p><strong>Giá thuê:</strong> <span id="gia_thue"><?php echo number_format($row['gia_thue'], 0, ',', '.'); ?>đ/ngày</span></p>
<?php else: ?>

<p style="color:red;">Không tìm thấy thông tin xe hoặc không có mã xe hợp lệ.</p>

<?php endif; ?>

 <a href="Datxe.php?ma_xe=<?php echo urlencode($row['ma_xe']); ?>" class="btn-dat-xe">Đặt xe</a>

</section>

<!-- XE TƯƠNG TỰ -->
<section class="container" style="margin-top:40px; text-align:center;">
    <h2 style="color:#f8a100; font-size:2.1rem; margin-bottom:24px; letter-spacing:1px;">Xe tương tự</h2>
    <div style="display:flex; flex-wrap:nowrap; justify-content:center; gap:32px; overflow-x:auto;">
    <?php
    // Lấy các xe cùng loại, trừ xe hiện tại
    $loai_xe = $row['loai_xe'];
    $ma_xe_hien_tai = $row['ma_xe'];
    $sql_tuong_tu = "
        SELECT xm.ma_xe, xm.hang_xe, xm.dong_xe, xm.gia_thue, xm.duong_dan_anh
        FROM xe_may xm
        JOIN chi_tiet_xe ct ON xm.ma_xe = ct.ma_xe
        WHERE ct.loai_xe = ? AND xm.ma_xe != ?
        LIMIT 3
    ";
    $stmt2 = $conn->prepare($sql_tuong_tu);
    $stmt2->bind_param("si", $loai_xe, $ma_xe_hien_tai);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($xe = $result2->fetch_assoc()): ?>
        <div style="background:#23272b; border-radius:12px; width:210px; min-width:210px; padding:18px 12px 20px 12px; text-align:center; box-shadow:0 2px 12px #0002; transition:transform 0.2s; display:flex; flex-direction:column; align-items:center;">
            <img src="<?= htmlspecialchars($xe['duong_dan_anh']) ?>" alt="<?= htmlspecialchars($xe['dong_xe']) ?>" style="width:100%; max-width:170px; height:110px; object-fit:cover; border-radius:7px; margin-bottom:10px;">
            <h3 style="color:#f8a100; margin:8px 0 4px; font-size:1.15rem; font-weight:bold; letter-spacing:0.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%;">
                <?= htmlspecialchars($xe['dong_xe']) ?>
            </h3>
            <div style="color:#fff; font-size:14px; margin-bottom:4px;">Hãng: <?= htmlspecialchars($xe['hang_xe']) ?></div>
            <div style="color:#dac446; font-weight:bold; margin-bottom:10px; font-size:15px;">Giá: <?= number_format($xe['gia_thue'],0,',','.') ?>đ/ngày</div>
            <div style="display:flex; gap:8px; justify-content:center; width:100%;">
                <a href="chi_tiet_xe.php?ma_xe=<?= urlencode($xe['ma_xe']) ?>" style="background:#f8a100; color:#fff; padding:7px 14px; border-radius:5px; text-decoration:none; font-weight:bold; font-size:14px;">Xem chi tiết</a>
                <a href="Datxe.php?ma_xe=<?= urlencode($xe['ma_xe']) ?>" style="background:#2980b9; color:#fff; padding:7px 14px; border-radius:5px; text-decoration:none; font-weight:bold; font-size:14px;">Đặt xe</a>
            </div>
        </div>
    <?php endwhile; $stmt2->close(); $conn->close(); ?>
    </div>
</section>

    <!-- FOOTER -->
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
</body>
</html>