<?php
include 'connect.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT * FROM xe_may WHERE 1";

// Nếu có từ khóa tìm kiếm, thêm điều kiện vào truy vấn
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $sql .= " AND dong_xe LIKE '%$search_safe%'";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/chinhsachkhachhang.css">
    <title>Chính Sách Khách Hàng Thân Thiết</title>
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="logo">E-BIKES</div>
        <section id="danh-muc">
            <button>☰ Danh mục xe</button>
            <ul>
                <li><a href="danh_sach.php?loai_xe=Xe số">Xe số</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe tay ga">Xe tay ga</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe tay côn">Xe tay côn</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe phân khối lớn">Xe phân khối lớn</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe 50cc">Xe 50cc</a></li>
            </ul>
        </section>
        <div class="search-section">
  <form method="GET" action="danh_sach.php">
    <input 
      type="search" 
      name="search" 
      placeholder="Tìm kiếm xe..." 
      value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
    />
    <button type="submit">Tìm</button>
  </form>
</div>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="danh_sach.php">Xe</a></li>
                <li><a href="#">Tin tức</a></li>
                <li><a href="chinh_sach.php">Chính sách</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Chính Sách Khách Hàng Thân Thiết</h1>
        <p>Với chính sách khách hàng thân thiết của E-BIKES, chúng tôi hi vọng sẽ được đồng hành cùng khách hàng lâu hơn nữa trong quãng thời gian hoạt động của E-BIKES.</p>

        <h2>1. Đánh giá và ưu đãi</h2>
        <p>Với các khách hàng có trải nghiệm tốt về dịch vụ thuê xe máy, để lại các review đánh giá 5* trên các kênh Social thuộc E-BIKES quản lý như Facebook, Google Maps. Lần thuê xe kế tiếp, chúng tôi sẽ miễn phí 1 lần giao hoặc nhận xe cho khách thuê 1 xe. Nếu thuê nhiều xe, E-BIKES sẽ miễn phí nâng cấp từ mũ 1/2 đầu lên 3/4 đầu cho toàn bộ đoàn xe thuê.</p>

        <h2>2. Giảm giá cho khách hàng thân thiết</h2>
        <p>Với các khách hàng thân thiết có số lần thuê xe lớn hơn 3 lần, lần thuê xe tiếp theo sẽ được giảm 5% tổng giá trị hợp đồng. Với khách hàng thân thiết thuê > 5 lần, lần thuê tiếp theo được giảm giá 10%.</p>

        <h2>3. Quà tặng sinh nhật</h2>
        <p>Khách hàng cũ có ngày sinh nhật trong tháng thuê xe sẽ được đổ đầy bình xăng.</p>

        <h2>4. Dịch vụ miễn phí</h2>
        <p>Các khách hàng cũ có hợp đồng thuê xe mới > 1 triệu đồng, được miễn phí dịch vụ giao hoặc nhận xe. Ngoài ra, nếu nhận xe tại cửa hàng sẽ được đổ đầy bình xăng.</p>
    </main>


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
                <li><a href="#">Chính sách thuê xe máy </a></li>
                <li><a href="#">Chính sách khách hàng thân thiết </a></li>
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