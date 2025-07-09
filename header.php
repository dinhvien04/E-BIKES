<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<header>
    <!-- <div class="logo">🏍 E - BIKES</div>
    <nav>
        <ul>
            <li><a href="trang_chu.php">Trang chủ</a></li>
            <ul>
                <li><a href="danh_sach.php">Tất cả xe</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe số ">Xe số</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe ga">Xe ga</a></li>
                <li><a href="danh_sach.php?loai_xe=Xe côn tay">Xe côn tay</a></li>
                <li><a href="danh_sach.php?loai_xe=Phân khối lớn">Phân khối lớn</a></li>
            </ul>
            <li><a href="gioithieu.php">Giới thiệu</a></li>
            <li><a href="FQA.php">FQA</a></li>
            <li><a href="lienhe1.php">Liên hệ đặt</a></li>
            <li> -->
            <div class="logo">🏍 E - BIKES</div>
        <nav>
            <ul>
                <li><a href="trangchu.php">Trang chủ</a></li>
                <li>
                    <button>Danh mục xe▾</button>
                    <ul>
                        <li><a href="danh_sach.php">Tất cả</a></li>
                        <li><a href="danh_sach.php?loai_xe=Xe số ">Xe số</a></li>
                        <li><a href="danh_sach.php?loai_xe=Xe ga">Xe ga</a></li>
                        <li><a href="danh_sach.php?loai_xe=Xe côn tay">Xe côn tay</a></li>
                        <li><a href="danh_sach.php?loai_xe=Phân khối lớn">Phân khối lớn</a></li>
                    </ul>
                </li>
                <li><a href="gioithieu.php">Giới thiệu</a></li>
                <li><a href="chinh_sach_thue_xe.php">Chính sách thuê xe</a></li>
                <li><a href="lienhe1.php">Liên hệ đặt</a></li>
                <li>
                <button>
                    👤
                    <?php echo isset($_SESSION['user_id']) && isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Tài khoản'; ?>
                    ▾
                </button>
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="thong_tin_ca_nhan.php">
                                <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Thông tin cá nhân'; ?>
                            </a>
                        </li>
                        <li><a href="logout.php">Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a href="dang_nhap.php">Đăng nhập</a></li>
                        <li><a href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>
</header> 