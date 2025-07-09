-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 25, 2025 at 04:56 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thuexeebikes`
--

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_thue`
--

DROP TABLE IF EXISTS `chi_tiet_don_thue`;
CREATE TABLE IF NOT EXISTS `chi_tiet_don_thue` (
  `ma_chi_tiet` int NOT NULL AUTO_INCREMENT,
  `ma_don_thue` int NOT NULL,
  `ma_xe` int NOT NULL,
  `gia_thue` decimal(10,2) NOT NULL,
  `so_ngay_thue` int NOT NULL,
  `thanh_tien` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ma_chi_tiet`),
  KEY `ma_don_thue` (`ma_don_thue`),
  KEY `ma_xe` (`ma_xe`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_don_thue`
--

INSERT INTO `chi_tiet_don_thue` (`ma_chi_tiet`, `ma_don_thue`, `ma_xe`, `gia_thue`, `so_ngay_thue`, `thanh_tien`) VALUES
(1, 1, 1, 500000.00, 5, 2500000.00),
(2, 2, 5, 450000.00, 2, 900000.00),
(3, 3, 11, 400000.00, 3, 1200000.00),
(4, 4, 15, 600000.00, 5, 3000000.00),
(5, 5, 20, 750000.00, 2, 1500000.00),
(6, 6, 25, 540000.00, 5, 2700000.00),
(7, 7, 30, 700000.00, 5, 3500000.00),
(8, 8, 35, 800000.00, 5, 4000000.00),
(9, 9, 8, 400000.00, 2, 800000.00),
(10, 10, 14, 400000.00, 4, 1600000.00),
(11, 11, 3, 550000.00, 4, 2200000.00),
(12, 12, 6, 480000.00, 5, 2400000.00),
(13, 13, 10, 450000.00, 4, 1800000.00),
(14, 14, 19, 640000.00, 5, 3200000.00),
(15, 15, 22, 440000.00, 5, 2200000.00),
(16, 16, 27, 560000.00, 5, 2800000.00),
(17, 17, 32, 720000.00, 5, 3600000.00),
(18, 18, 38, 820000.00, 5, 4100000.00),
(19, 19, 9, 350000.00, 4, 1400000.00),
(20, 20, 13, 425000.00, 4, 1700000.00);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_xe`
--

DROP TABLE IF EXISTS `chi_tiet_xe`;
CREATE TABLE IF NOT EXISTS `chi_tiet_xe` (
  `ma_xe` int NOT NULL AUTO_INCREMENT,
  `mau_sac` varchar(50) DEFAULT NULL,
  `dung_tich_xi_lanh` int DEFAULT NULL,
  `loai_xe` varchar(50) DEFAULT NULL,
  `mo_ta` text,
  PRIMARY KEY (`ma_xe`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chi_tiet_xe`
--

INSERT INTO `chi_tiet_xe` (`ma_xe`, `mau_sac`, `dung_tich_xi_lanh`, `loai_xe`, `mo_ta`) VALUES
(1, 'Đen', 110, 'Xe số', 'Xe số phổ thông, dễ sử dụng, tiết kiệm nhiên liệu.'),
(2, 'Trắng', 115, 'Xe số', 'Xe số mạnh mẽ, bền bỉ, phù hợp đi lại hàng ngày.'),
(3, 'Xanh', 115, 'Xe số', 'Xe số phong cách thể thao, phù hợp mọi lứa tuổi.'),
(4, 'Đỏ đen', 110, 'Xe số', 'Xe số thiết kế hiện đại, tiết kiệm xăng.'),
(5, 'Đỏ đen', 115, 'Xe số', 'Xe số có động cơ bền, dễ sửa chữa.'),
(6, 'Trắng', 110, 'Xe số', 'Xe số giá rẻ, thích hợp di chuyển trong thành phố.'),
(7, 'Đỏ đen', 125, 'Xe số', 'Xe số mạnh mẽ, thiết kế thời trang.'),
(8, 'Xanh đen', 135, 'Xe số', 'Xe số thể thao, phù hợp người trẻ tuổi.'),
(9, 'Trắng', 110, 'Xe số', 'Xe số cổ điển, thiết kế bền bỉ.'),
(10, 'Trắng', 125, 'Xe ga', 'Xe ga hiện đại, tiện lợi cho đi lại trong đô thị.'),
(11, 'Đen', 125, 'Xe ga', 'Xe ga sang trọng, tiết kiệm nhiên liệu.'),
(12, 'Đen', 125, 'Xe ga', 'Xe ga phổ thông, dễ điều khiển.'),
(13, 'Xám', 125, 'Xe ga', 'Xe ga có dung tích lớn, phù hợp đi đường dài.'),
(14, 'Trắng', 125, 'Xe ga', 'Xe ga tiết kiệm xăng, độ bền cao.'),
(15, 'Xanh', 150, 'Xe ga', 'Xe ga thiết kế trẻ trung, năng động.'),
(16, 'Đen nhám', 150, 'Xe ga', 'Xe ga mạnh mẽ, vận hành êm ái.'),
(17, 'Bạc', 155, 'Xe ga', 'Xe ga cao cấp, trang bị nhiều tiện ích.'),
(18, 'Đen', 125, 'Xe ga', 'Xe ga dễ lái, phù hợp với mọi đối tượng.'),
(19, 'Đen', 150, 'Xe côn tay', 'Xe côn tay thể thao, phù hợp người yêu tốc độ.'),
(20, 'Đen hồng', 155, 'Xe côn tay', 'Xe côn tay mạnh mẽ, thiết kế cá tính.'),
(21, 'Xanh', 150, 'Xe côn tay', 'Xe côn tay hiệu suất cao, bền bỉ.'),
(22, 'Đen', 125, 'Xe côn tay', 'Xe côn tay dễ điều khiển, thích hợp đi phố.'),
(23, 'Cam', 150, 'Xe côn tay', 'Xe côn tay bền, phù hợp đi đường dài.'),
(24, 'Đỏ đen', 150, 'Xe côn tay', 'Xe côn tay thời trang, nhiều tiện ích.'),
(25, 'Đen bạc', 400, 'Xe côn tay', 'Xe côn tay phân khối lớn, tốc độ cao.'),
(26, 'Đỏ đen', 750, 'Phân khối lớn', 'Xe phân khối lớn mạnh mẽ, phù hợp đi đường dài.'),
(27, 'Đen bạc', 650, 'Phân khối lớn', 'Xe phân khối lớn thể thao, thiết kế bắt mắt.'),
(28, 'Đen trắng', 1290, 'Phân khối lớn', 'Xe phân khối lớn hiệu suất cực cao, thể thao.');

-- --------------------------------------------------------

--
-- Table structure for table `dat_xe`
--

DROP TABLE IF EXISTS `dat_xe`;
CREATE TABLE IF NOT EXISTS `dat_xe` (
  `ma_dat_xe` int NOT NULL AUTO_INCREMENT,
  `ma_nguoi_dung` int NOT NULL,
  `ma_xe` int NOT NULL,
  `ngay_dat` date NOT NULL,
  `thoi_gian_bat_dau` date NOT NULL,
  `thoi_gian_ket_thuc` date NOT NULL,
  `ghi_chu` text,
  `trang_thai` enum('cho_xu_ly','da_duyet','da_huy') DEFAULT 'cho_xu_ly',
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ma_dat_xe`),
  KEY `ma_nguoi_dung` (`ma_nguoi_dung`),
  KEY `ma_xe` (`ma_xe`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dat_xe`
--

INSERT INTO `dat_xe` (`ma_dat_xe`, `ma_nguoi_dung`, `ma_xe`, `ngay_dat`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `ghi_chu`, `trang_thai`, `ngay_tao`) VALUES
(1, 1, 1, '2025-05-01', '2025-05-10', '2025-05-15', 'Thuê đi du lịch miền Trung', 'da_duyet', '2025-05-20 02:49:29'),
(2, 2, 5, '2025-05-02', '2025-05-12', '2025-05-14', 'Đi công tác ngắn ngày', 'cho_xu_ly', '2025-05-20 02:49:29'),
(3, 3, 11, '2025-05-03', '2025-05-15', '2025-05-18', 'Thuê xe ga tiện lợi', 'da_duyet', '2025-05-20 02:49:29'),
(4, 4, 15, '2025-05-04', '2025-05-20', '2025-05-25', 'Đi phượt xa', 'cho_xu_ly', '2025-05-20 02:49:29'),
(5, 5, 20, '2025-05-05', '2025-05-22', '2025-05-24', 'Xe thuê cho bạn bè', 'da_huy', '2025-05-20 02:49:29'),
(6, 6, 25, '2025-05-06', '2025-05-25', '2025-05-30', 'Đi tour miền núi', 'da_duyet', '2025-05-20 02:49:29'),
(7, 7, 30, '2025-05-07', '2025-05-27', '2025-06-02', 'Thuê xe côn tay mạnh mẽ', 'da_duyet', '2025-05-20 02:49:29'),
(8, 8, 35, '2025-05-08', '2025-05-28', '2025-06-03', 'Xe phân khối lớn cho chuyến đi dài', 'cho_xu_ly', '2025-05-20 02:49:29'),
(9, 9, 8, '2025-05-09', '2025-05-29', '2025-06-01', 'Đi làm bằng xe số', 'da_duyet', '2025-05-20 02:49:29'),
(10, 10, 14, '2025-05-10', '2025-06-01', '2025-06-05', 'Thuê xe ga cho gia đình', 'da_duyet', '2025-05-20 02:49:29'),
(11, 11, 3, '2025-05-11', '2025-06-03', '2025-06-07', 'Xe số phổ thông', 'cho_xu_ly', '2025-05-20 02:49:29'),
(12, 12, 6, '2025-05-12', '2025-06-05', '2025-06-10', 'Xe số đi phố', 'da_duyet', '2025-05-20 02:49:29'),
(13, 13, 10, '2025-05-13', '2025-06-07', '2025-06-12', 'Xe số đi làm', 'da_huy', '2025-05-20 02:49:29'),
(14, 14, 19, '2025-05-14', '2025-06-09', '2025-06-15', 'Xe ga mạnh mẽ', 'da_duyet', '2025-05-20 02:49:29'),
(15, 15, 22, '2025-05-15', '2025-06-10', '2025-06-16', 'Xe côn tay thể thao', 'cho_xu_ly', '2025-05-20 02:49:29'),
(16, 16, 27, '2025-05-16', '2025-06-11', '2025-06-17', 'Xe côn tay phân khối lớn', 'da_duyet', '2025-05-20 02:49:29'),
(17, 17, 32, '2025-05-17', '2025-06-12', '2025-06-18', 'Xe phân khối lớn đi tour', 'da_duyet', '2025-05-20 02:49:29'),
(18, 18, 38, '2025-05-18', '2025-06-13', '2025-06-19', 'Xe phân khối lớn thể thao', 'cho_xu_ly', '2025-05-20 02:49:29'),
(19, 19, 9, '2025-05-19', '2025-06-14', '2025-06-20', 'Xe số tiện lợi', 'da_duyet', '2025-05-20 02:49:29'),
(20, 20, 13, '2025-05-20', '2025-06-15', '2025-06-21', 'Xe ga cho đi làm', 'da_duyet', '2025-05-20 02:49:29');

-- --------------------------------------------------------

--
-- Table structure for table `don_thue`
--

DROP TABLE IF EXISTS `don_thue`;
CREATE TABLE IF NOT EXISTS `don_thue` (
  `ma_don_thue` int NOT NULL AUTO_INCREMENT,
  `ma_nguoi_dung` int NOT NULL,
  `ngay_thue` date NOT NULL,
  `ngay_tra` date NOT NULL,
  `tong_tien` decimal(10,2) NOT NULL,
  `tinh_trang` enum('da_dat','dang_thue','hoan_thanh','da_huy') DEFAULT 'da_dat',
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ma_don_thue`),
  KEY `ma_nguoi_dung` (`ma_nguoi_dung`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `don_thue`
--

INSERT INTO `don_thue` (`ma_don_thue`, `ma_nguoi_dung`, `ngay_thue`, `ngay_tra`, `tong_tien`, `tinh_trang`, `ngay_tao`) VALUES
(1, 1, '2025-05-10', '2025-05-15', 2500000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(2, 2, '2025-05-12', '2025-05-14', 900000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(3, 3, '2025-05-15', '2025-05-18', 1200000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(4, 4, '2025-05-20', '2025-05-25', 3000000.00, 'dang_thue', '2025-05-20 02:53:31'),
(5, 5, '2025-05-22', '2025-05-24', 1500000.00, 'da_huy', '2025-05-20 02:53:31'),
(6, 6, '2025-05-25', '2025-05-30', 2700000.00, 'da_dat', '2025-05-20 02:53:31'),
(7, 7, '2025-05-27', '2025-06-02', 3500000.00, 'dang_thue', '2025-05-20 02:53:31'),
(8, 8, '2025-05-28', '2025-06-03', 4000000.00, '', '2025-05-20 02:53:31'),
(9, 9, '2025-05-29', '2025-06-01', 800000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(10, 10, '2025-06-01', '2025-06-05', 1600000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(11, 11, '2025-06-03', '2025-06-07', 1100000.00, 'dang_thue', '2025-05-20 02:53:31'),
(12, 12, '2025-06-05', '2025-06-10', 2400000.00, 'da_dat', '2025-05-20 02:53:31'),
(13, 13, '2025-06-07', '2025-06-12', 1800000.00, 'da_huy', '2025-05-20 02:53:31'),
(14, 14, '2025-06-09', '2025-06-15', 3200000.00, 'dang_thue', '2025-05-20 02:53:31'),
(15, 15, '2025-06-10', '2025-06-16', 2200000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(16, 16, '2025-06-11', '2025-06-17', 2800000.00, 'da_dat', '2025-05-20 02:53:31'),
(17, 17, '2025-06-12', '2025-06-18', 3600000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(18, 18, '2025-06-13', '2025-06-19', 4100000.00, 'dang_thue', '2025-05-20 02:53:31'),
(19, 19, '2025-06-14', '2025-06-20', 1400000.00, 'hoan_thanh', '2025-05-20 02:53:31'),
(20, 20, '2025-06-15', '2025-06-21', 1700000.00, 'da_dat', '2025-05-20 02:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `ma_faq` int NOT NULL AUTO_INCREMENT,
  `cau_hoi` text NOT NULL,
  `cau_tra_loi` text NOT NULL,
  `hien_thi` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ma_faq`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`ma_faq`, `cau_hoi`, `cau_tra_loi`, `hien_thi`) VALUES
(1, 'Làm thế nào để đăng ký thuê xe?', 'Bạn cần tạo tài khoản trên website và điền thông tin thuê xe theo hướng dẫn.', 1),
(2, 'Thủ tục thuê xe gồm những gì?', 'Bạn cần CMND/CCCD và bằng lái xe hợp lệ để thuê xe.', 1),
(3, 'Có cần đặt cọc khi thuê xe không?', 'Có, khách hàng phải đặt cọc trước một khoản tiền tùy theo loại xe.', 1),
(4, 'Thời gian thuê xe tối thiểu là bao lâu?', 'Thời gian thuê tối thiểu là 1 ngày.', 1),
(5, 'Có hỗ trợ giao xe tận nơi không?', 'Chúng tôi có dịch vụ giao xe tận nơi với một khoản phí phụ thu.', 1),
(6, 'Xe máy khi thuê có được bảo trì không?', 'Tất cả xe máy đều được bảo trì định kỳ và kiểm tra kỹ trước khi giao.', 1),
(7, 'Phương thức thanh toán được chấp nhận?', 'Chúng tôi chấp nhận thanh toán tiền mặt, thẻ tín dụng, chuyển khoản và ví điện tử như Momo, Zalo Pay.', 1),
(8, 'Có thể thuê xe theo giờ không?', 'Hiện tại chúng tôi chỉ cho thuê theo ngày.', 1),
(9, 'Làm thế nào để hủy đơn đặt xe?', 'Bạn có thể hủy đơn đặt xe trong vòng 24 giờ trước thời gian thuê.', 1),
(10, 'Có cung cấp mũ bảo hiểm khi thuê xe không?', 'Có, mỗi xe sẽ đi kèm mũ bảo hiểm đạt chuẩn.', 1),
(11, 'Chính sách bồi thường khi làm hỏng xe?', 'Khách hàng sẽ chịu trách nhiệm bồi thường theo giá thị trường hoặc chi phí sửa chữa.', 1),
(12, 'Có hỗ trợ khách hàng khi xe bị hỏng giữa đường không?', 'Chúng tôi có dịch vụ hỗ trợ kỹ thuật 24/7.', 1),
(13, 'Có giảm giá cho khách hàng thân thiết không?', 'Có chương trình tích điểm và giảm giá cho khách hàng thường xuyên.', 1),
(14, 'Thời gian làm việc của dịch vụ?', 'Dịch vụ hoạt động từ 7h sáng đến 9h tối mỗi ngày.', 1),
(15, 'Có cho phép gia hạn thời gian thuê xe không?', 'Có thể gia hạn tùy theo tình trạng xe và thông báo trước.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lien_he`
--

DROP TABLE IF EXISTS `lien_he`;
CREATE TABLE IF NOT EXISTS `lien_he` (
  `ma_lien_he` int NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `tieu_de` varchar(200) DEFAULT NULL,
  `noi_dung` text,
  `ngay_gui` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ma_lien_he`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lien_he`
--

INSERT INTO `lien_he` (`ma_lien_he`, `ho_ten`, `email`, `so_dien_thoai`, `tieu_de`, `noi_dung`, `ngay_gui`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', '0912345678', 'Hỏi về thủ tục thuê xe', 'Xin hỏi thủ tục thuê xe máy như thế nào?', '2025-05-20 02:59:02'),
(2, 'Trần Thị B', 'tranthib@example.com', '0987654321', 'Thắc mắc về giá thuê', 'Giá thuê xe số có thay đổi không?', '2025-05-20 02:59:02'),
(3, 'Lê Văn C', 'levanc@example.com', '0909123456', 'Đặt xe cho nhóm đông', 'Tôi muốn thuê xe cho nhóm 10 người, cần hỗ trợ thêm.', '2025-05-20 02:59:02'),
(4, 'Phạm Thị D', 'phamthid@example.com', '0934567890', 'Thời gian thuê linh hoạt', 'Có thể thuê xe theo giờ không?', '2025-05-20 02:59:02'),
(5, 'Hoàng Văn E', 'hoangvane@example.com', '0965432109', 'Bảo trì xe', 'Xe thuê có được bảo trì trong thời gian thuê không?', '2025-05-20 02:59:02'),
(6, 'Đỗ Thị F', 'dothif@example.com', '0978123456', 'Thanh toán online', 'Có hỗ trợ thanh toán online qua Momo không?', '2025-05-20 02:59:02'),
(7, 'Vũ Văn G', 'vuvang@example.com', '0911223344', 'Thời gian trả xe', 'Có thể trả xe muộn hơn giờ quy định không?', '2025-05-20 02:59:02'),
(8, 'Bùi Thị H', 'buithih@example.com', '0988332211', 'Chính sách hủy đơn', 'Chính sách hủy đơn thuê xe như thế nào?', '2025-05-20 02:59:02'),
(9, 'Trịnh Văn I', 'trinhvani@example.com', '0900112233', 'Yêu cầu xe mới', 'Có thể đặt xe mới không?', '2025-05-20 02:59:02'),
(10, 'Ngô Thị J', 'ngothij@example.com', '0911445566', 'Hỗ trợ đặt xe ở sân bay', 'Có dịch vụ giao xe tại sân bay không?', '2025-05-20 02:59:02'),
(11, 'Lý Văn K', 'lyvank@example.com', '0933557799', 'Hướng dẫn sử dụng xe', 'Có hướng dẫn sử dụng xe khi thuê không?', '2025-05-20 02:59:02'),
(12, 'Phan Thị L', 'phanthil@example.com', '0944668800', 'Phụ kiện đi kèm', 'Xe thuê có mũ bảo hiểm và đồ bảo hộ không?', '2025-05-20 02:59:02'),
(13, 'Trương Văn M', 'truongvanm@example.com', '0955779911', 'Giảm giá cho khách hàng thân thiết', 'Có chương trình giảm giá cho khách hàng thường xuyên không?', '2025-05-20 02:59:02'),
(14, 'Đặng Thị N', 'dangthin@example.com', '0966880022', 'Xe số hay xe tay ga', 'Nên thuê xe số hay xe tay ga cho đường dài?', '2025-05-20 02:59:02'),
(15, 'Phùng Văn O', 'phungvano@example.com', '0977991133', 'Thời gian làm việc', 'Giờ làm việc của dịch vụ thuê xe là bao lâu?', '2025-05-20 02:59:02'),
(16, 'Nguyễn Thị P', 'nguyenthijp@example.com', '0988112244', 'Dịch vụ giao xe tận nơi', 'Có dịch vụ giao xe tận nơi không?', '2025-05-20 02:59:02'),
(17, 'Trần Văn Q', 'tranvanq@example.com', '0909223355', 'Thủ tục đăng ký', 'Cần những giấy tờ gì để đăng ký thuê xe?', '2025-05-20 02:59:02'),
(18, 'Lê Thị R', 'lethir@example.com', '0910334466', 'Chính sách bồi thường', 'Chính sách bồi thường khi làm hỏng xe như thế nào?', '2025-05-20 02:59:02'),
(19, 'Phạm Văn S', 'phamvans@example.com', '0921445577', 'Thời gian giữ xe', 'Có thể giữ xe trước ngày thuê không?', '2025-05-20 02:59:02'),
(20, 'Hoàng Thị T', 'hoangthit@example.com', '0932556688', 'Hỗ trợ kỹ thuật', 'Có hỗ trợ kỹ thuật khi xe bị hỏng giữa đường không?', '2025-05-20 02:59:02'),
(21, 'Đỗ Văn U', 'dovanu@example.com', '0943667799', 'Thay đổi lịch thuê', 'Có thể thay đổi ngày thuê xe không?', '2025-05-20 02:59:02'),
(22, 'Vũ Thị V', 'vuthiv@example.com', '0954778800', 'Xe côn tay', 'Có xe côn tay cho thuê không?', '2025-05-20 02:59:02'),
(23, 'Bùi Văn W', 'buivanw@example.com', '0965889911', 'Phương thức thanh toán', 'Có thể thanh toán bằng thẻ tín dụng không?', '2025-05-20 02:59:02'),
(24, 'Trịnh Thị X', 'trinhthix@example.com', '0976990022', 'Hỗ trợ khách hàng', 'Số điện thoại hỗ trợ khách hàng khi thuê xe?', '2025-05-20 02:59:02'),
(25, 'Ngô Văn Y', 'ngovany@example.com', '0987001133', 'Hợp đồng thuê xe', 'Có thể xem mẫu hợp đồng thuê xe trước không?', '2025-05-20 02:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `nguoi_dung`
--

DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE IF NOT EXISTS `nguoi_dung` (
  `ma_nguoi_dung` int NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text,
  `cccd` varchar(20) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `vai_tro` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`ma_nguoi_dung`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`ma_nguoi_dung`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `dia_chi`, `cccd`, `ngay_sinh`, `ngay_tao`, `vai_tro`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@example.com', 'hashed_password_1', '0901234567', 'Hà Nội', '012345678', '1990-01-15', '2025-05-20 02:20:59', 'user'),
(2, 'Trần Thị B', 'tranthib@example.com', 'hashed_password_2', '0912345678', 'Hồ Chí Minh', '023456789', '1992-05-20', '2025-05-20 02:20:59', 'user'),
(3, 'Lê Văn C', 'levanc@example.com', 'hashed_password_3', '0987654321', 'Đà Nẵng', '034567890', '1988-09-10', '2025-05-20 02:20:59', 'user'),
(4, 'Phạm Thị D', 'phamthid@example.com', 'hashed_password_4', '0978123456', 'Cần Thơ', '045678901', '1995-12-05', '2025-05-20 02:20:59', 'user'),
(5, 'Hoàng Văn E', 'hoangvane@example.com', 'hashed_password_5', '0967123456', 'Hải Phòng', '056789012', '1991-03-22', '2025-05-20 02:20:59', 'user'),
(6, 'Đỗ Thị F', 'dothif@example.com', 'hashed_password_6', '0945123456', 'Quảng Ninh', '067890123', '1989-07-30', '2025-05-20 02:20:59', 'user'),
(7, 'Vũ Văn G', 'vuvang@example.com', 'hashed_password_7', '0934123456', 'Nghệ An', '078901234', '1993-11-17', '2025-05-20 02:20:59', 'user'),
(8, 'Bùi Thị H', 'buithih@example.com', 'hashed_password_8', '0923123456', 'Thừa Thiên Huế', '089012345', '1994-04-25', '2025-05-20 02:20:59', 'user'),
(9, 'Trịnh Văn I', 'trinhvani@example.com', 'hashed_password_9', '0912123456', 'Bình Dương', '090123456', '1990-08-13', '2025-05-20 02:20:59', 'user'),
(10, 'Phan Thị J', 'phanthij@example.com', 'hashed_password_10', '0901123456', 'Long An', '101234567', '1996-02-28', '2025-05-20 02:20:59', 'user'),
(14, 'bảo yến', 'thuthao6424@gmail.com', '$2y$10$qOvVtXZAuBJXyg.AUsrRoueqKsgV51BfBtQod9mWVYIXDHc/Yyw7K', NULL, NULL, NULL, NULL, '2025-05-20 19:31:38', 'user'),
(15, 'bảo yến', 'thuthao64245@gmail.com', '$2y$10$FmnUq0POxULHjlZzZYzQCuG.0DlcCd8SFeobANdtlJfe17R2DguOq', NULL, NULL, NULL, NULL, '2025-05-20 23:34:27', 'user'),
(16, 'bảo yến', 'thaothao222@gmail.com', '$2y$10$M7YM6YfSasw2R63xaHuAVe95wMXh.D1FFm29znFzr5xRVrWvgCvfe', NULL, NULL, NULL, NULL, '2025-05-21 00:19:36', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--

DROP TABLE IF EXISTS `nhan_vien`;
CREATE TABLE IF NOT EXISTS `nhan_vien` (
  `ma_nhan_vien` int NOT NULL AUTO_INCREMENT,
  `ho_ten` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `chuc_vu` varchar(50) DEFAULT NULL,
  `dia_chi` text,
  `luong` decimal(15,2) DEFAULT '0.00',
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trang_thai` enum('dang_lam','da_nghi') DEFAULT 'dang_lam',
  PRIMARY KEY (`ma_nhan_vien`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`ma_nhan_vien`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `chuc_vu`, `dia_chi`, `luong`, `ngay_tao`, `trang_thai`) VALUES
(1, 'Lê Thị Mai', 'lethimai@example.com', 'hashed_password_1', '0901234561', 'Quản lý', 'Hà Nội', 15000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(2, 'Trần Văn Nam', 'tranvannam@example.com', 'hashed_password_2', '0901234562', 'Nhân viên kinh doanh', 'Hồ Chí Minh', 10000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(3, 'Phạm Thị Hoa', 'phamthihoa@example.com', 'hashed_password_3', '0901234563', 'Nhân viên kỹ thuật', 'Đà Nẵng', 9000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(4, 'Nguyễn Văn Bình', 'nguyenvanbinh@example.com', 'hashed_password_4', '0901234564', 'Nhân viên chăm sóc khách hàng', 'Cần Thơ', 8500000.00, '2025-05-20 02:20:59', 'dang_lam'),
(5, 'Hoàng Thị Lan', 'hoangthilan@example.com', 'hashed_password_5', '0901234565', 'Kế toán', 'Hải Phòng', 9500000.00, '2025-05-20 02:20:59', 'dang_lam'),
(6, 'Đỗ Văn Hùng', 'dovanhung@example.com', 'hashed_password_6', '0901234566', 'Lái xe giao hàng', 'Quảng Ninh', 7000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(7, 'Vũ Thị Hạnh', 'vuthihanh@example.com', 'hashed_password_7', '0901234567', 'Nhân viên bảo trì', 'Nghệ An', 8000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(8, 'Bùi Văn Dũng', 'buivandung@example.com', 'hashed_password_8', '0901234568', 'Quản lý kho', 'Thừa Thiên Huế', 11000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(9, 'Trịnh Thị Hương', 'trinhthihuong@example.com', 'hashed_password_9', '0901234569', 'Hỗ trợ kỹ thuật', 'Bình Dương', 9000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(10, 'Phan Văn Quang', 'phanvanquang@example.com', 'hashed_password_10', '0901234570', 'Nhân viên marketing', 'Long An', 10000000.00, '2025-05-20 02:20:59', 'dang_lam'),
(11, 'Admin', 'admin@ebikes.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0123456789', 'Quản trị viên', 'Hà Nội', 20000000.00, '2025-05-20 02:20:59', 'dang_lam');
-- --------------------------------------------------------

--
-- Table structure for table `thanh_toan`
--

DROP TABLE IF EXISTS `thanh_toan`;
CREATE TABLE IF NOT EXISTS `thanh_toan` (
  `ma_thanh_toan` int NOT NULL AUTO_INCREMENT,
  `ma_don_thue` varchar(10) NOT NULL,
  `ngay_thanh_toan` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `so_tien` decimal(10,2) NOT NULL,
  `phuong_thuc` enum('tien_mat','the_tin_dung','chuyen_khoan','momo','zalo_pay') DEFAULT NULL,
  PRIMARY KEY (`ma_thanh_toan`),
  KEY `ma_don_thue` (`ma_don_thue`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thanh_toan`
--

INSERT INTO `thanh_toan` (`ma_thanh_toan`, `ma_don_thue`, `ngay_thanh_toan`, `so_tien`, `phuong_thuc`) VALUES
(1, '1', '2025-05-20 03:12:38', 2500000.00, 'tien_mat'),
(2, '2', '2025-05-20 03:12:38', 900000.00, 'momo'),
(3, '3', '2025-05-20 03:12:38', 1200000.00, 'chuyen_khoan'),
(4, '4', '2025-05-20 03:12:38', 3000000.00, 'the_tin_dung'),
(5, '5', '2025-05-20 03:12:38', 1500000.00, 'zalo_pay'),
(6, '6', '2025-05-20 03:12:38', 2700000.00, 'tien_mat'),
(7, '7', '2025-05-20 03:12:38', 3500000.00, 'momo'),
(8, '8', '2025-05-20 03:12:38', 4000000.00, 'chuyen_khoan'),
(9, '9', '2025-05-20 03:12:38', 800000.00, 'the_tin_dung'),
(10, '10', '2025-05-20 03:12:38', 1600000.00, 'zalo_pay'),
(11, '11', '2025-05-20 03:12:38', 2200000.00, 'tien_mat'),
(12, '12', '2025-05-20 03:12:38', 2400000.00, 'momo'),
(13, '13', '2025-05-20 03:12:38', 1800000.00, 'chuyen_khoan'),
(14, '14', '2025-05-20 03:12:38', 3200000.00, 'the_tin_dung'),
(15, '15', '2025-05-20 03:12:38', 2200000.00, 'zalo_pay'),
(16, '16', '2025-05-20 03:12:38', 2800000.00, 'tien_mat'),
(17, '17', '2025-05-20 03:12:38', 3600000.00, 'momo'),
(18, '18', '2025-05-20 03:12:38', 4100000.00, 'chuyen_khoan'),
(19, '19', '2025-05-20 03:12:38', 1400000.00, 'the_tin_dung'),
(20, '20', '2025-05-20 03:12:38', 1700000.00, 'zalo_pay');

-- --------------------------------------------------------

--
-- Table structure for table `xe_may`
--

DROP TABLE IF EXISTS `xe_may`;
CREATE TABLE IF NOT EXISTS `xe_may` (
  `ma_xe` int NOT NULL AUTO_INCREMENT,
  `hang_xe` varchar(50) NOT NULL,
  `dong_xe` varchar(50) NOT NULL,
  `bien_so` varchar(20) NOT NULL,
  `gia_thue` decimal(10,2) NOT NULL,
  `trang_thai` enum('con_trong','da_thue','bao_tri') DEFAULT 'con_trong',
  `duong_dan_anh` varchar(255) DEFAULT NULL,
  `so_luong` int DEFAULT 1,
  PRIMARY KEY (`ma_xe`),
  UNIQUE KEY `bien_so` (`bien_so`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe_may`
--

INSERT INTO `xe_may` (`ma_xe`, `hang_xe`, `dong_xe`, `bien_so`, `gia_thue`, `trang_thai`, `duong_dan_anh`, `so_luong`) VALUES
(1, 'Honda', 'Wave Alpha', '30A-12345', 120000.00, 'con_trong', 'duong_dan_anh\\x1.jpg', 5),
(2, 'Yamaha', 'Jupiter', '30A-12346', 110000.00, 'con_trong', 'duong_dan_anh\\x2.jpg', 3),
(3, 'Suzuki', 'Sport', '30A-12347', 115000.00, 'con_trong', 'duong_dan_anh\\x3.jpg', 4),
(4, 'Honda', 'Blade', '30A-12348', 125000.00, 'con_trong', 'duong_dan_anh\\x4.jpg', 2),
(5, 'Yamaha', 'Sirius', '30A-12349', 110000.00, 'con_trong', 'duong_dan_anh\\x5.jpg', 6),
(6, 'Yamaha', 'Sirius fi', '30A-12350', 105000.00, 'con_trong', 'duong_dan_anh\\x6.jpg', 2),
(7, 'Honda', 'Future', '30A-12351', 120000.00, 'con_trong', 'duong_dan_anh\\x7.jpg', 3),
(8, 'Yamaha', 'Future fi', '30A-12353', 130000.00, 'con_trong', 'duong_dan_anh\\x9.jpg', 1),
(9, 'Honda', 'Dream', '30A-12354', 125000.00, 'con_trong', 'duong_dan_anh\\x10.jpg', 2),
(10, 'Honda', 'Vision', '30B-22345', 150000.00, 'con_trong', 'duong_dan_anh\\x11.jpg', 4),
(11, 'Yamaha', 'Grande', '30B-22346', 160000.00, 'con_trong', 'duong_dan_anh\\x12.jpg', 2),
(12, 'Honda', 'Lead', '30B-22348', 155000.00, 'con_trong', 'duong_dan_anh\\x14.jpg', 3),
(13, 'Yamaha', 'Janus', '30B-22349', 165000.00, 'con_trong', 'duong_dan_anh\\x15.jpg', 2),
(14, 'SYM', 'Attila', '30B-22350', 140000.00, 'con_trong', 'duong_dan_anh\\x16.jpg', 1),
(15, 'Honda', 'Air Blade', '30B-22351', 175000.00, 'con_trong', 'duong_dan_anh\\x17.jpg', 2),
(16, 'Yamaha', 'NVX', '30B-22353', 185000.00, 'con_trong', 'duong_dan_anh\\x19.jpg', 2),
(17, 'Honda', 'SH More', '30B-22354', 160000.00, 'con_trong', 'duong_dan_anh\\x20.jpg', 1),
(18, 'Honda', 'CB150R', '30C-32345', 200000.00, 'con_trong', 'duong_dan_anh\\x21.jpg', 2),
(19, 'Yamaha', 'R15V4', '30C-32346', 210000.00, 'con_trong', 'duong_dan_anh\\x22.jpg', 1),
(20, 'Suzuki', 'GSX-S150', '30C-32347', 205000.00, 'con_trong', 'duong_dan_anh\\x23.jpg', 2),
(21, 'Yamaha', 'MT-15', '30C-32350', 230000.00, 'con_trong', 'duong_dan_anh\\x24.jpg', 1),
(22, 'Honda', 'CBR150R', '30C-32352', 225000.00, 'con_trong', 'duong_dan_anh\\x28.jpg', 2),
(23, 'Suzuki', 'GSX-R150', '30C-32353', 235000.00, 'con_trong', 'duong_dan_anh\\x29.jpg', 1),
(24, 'Yamaha', 'R15V3', '30C-13246', 210000.00, 'con_trong', 'duong_dan_anh\\x24.jpg', 2),
(25, 'Kawasaki', 'Ninja 400', '30C-32354', 250000.00, 'con_trong', 'duong_dan_anh\\x30.jpg', 1),
(26, 'Kawasaki', 'Z650', '30D-42346', 650000.00, 'con_trong', 'duong_dan_anh\\x31.jpg', 1),
(27, 'Yamaha', 'MT-07', '30D-42347', 670000.00, 'con_trong', 'duong_dan_anh\\x32.jpg', 1),
(28, 'Yamaha', 'XSR700', '30D-42353', 640000.00, 'con_trong', 'duong_dan_anh\\x38.jpg', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
