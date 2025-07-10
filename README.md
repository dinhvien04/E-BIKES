# 🏍️ E-BIKES - Hệ thống Thuê Xe Máy Trực Tuyến

## 📋 Giới thiệu

**E-BIKES** là một hệ thống quản lý thuê xe máy trực tuyến được phát triển bằng PHP và MySQL. Website cung cấp dịch vụ cho thuê các loại xe máy từ xe số, xe ga, xe côn tay đến xe phân khối lớn phù hợp với nhu cầu đa dạng của khách hàng.

**Slogan:** "Bật khóa, bung hành trình!"

## ✨ Tính năng chính

### 👥 Dành cho Khách hàng
- **Đăng ký/Đăng nhập:** Hệ thống xác thực với mã hóa mật khẩu
- **Danh mục xe:** Phân loại theo xe số, xe ga, xe côn tay, phân khối lớn
- **Tìm kiếm & Lọc:** Tìm kiếm xe theo tên, lọc theo loại xe
- **Chi tiết xe:** Xem thông tin chi tiết, hình ảnh, giá thuê
- **Giỏ hàng:** Thêm nhiều xe, tính toán tự động theo số ngày thuê
- **Đặt xe:** Chọn ngày thuê/trả, thông tin liên hệ
- **Lịch sử:** Theo dõi các đơn thuê đã đặt
- **Thông tin cá nhân:** Cập nhật hồ sơ cá nhân
- **Chính sách:** Xem chính sách thuê xe và khách hàng thân thiết

### 🔧 Dành cho Admin
- **Dashboard:** Tổng quan thống kê hệ thống
- **Quản lý xe:** Thêm/sửa/xóa thông tin xe, cập nhật trạng thái
- **Quản lý đơn thuê:** Xem, duyệt, cập nhật trạng thái đơn hàng
- **Quản lý người dùng:** Thông tin khách hàng, nhân viên
- **Báo cáo:** Thống kê doanh thu, xe được thuê nhiều
- **Thanh toán:** Quản lý các giao dịch thanh toán

## 🗄️ Cấu trúc Database

Database `thuexeebikes` bao gồm 9 bảng chính:

### 1. **xe_may** - Thông tin xe máy
- `ma_xe` (PK), `hang_xe`, `dong_xe`, `bien_so`
- `gia_thue`, `trang_thai`, `duong_dan_anh`, `so_luong`

### 2. **chi_tiet_xe** - Chi tiết kỹ thuật
- `ma_xe` (FK), `mau_sac`, `dung_tich_xi_lanh`
- `loai_xe`, `mo_ta`

### 3. **nguoi_dung** - Thông tin khách hàng
- `ma_nguoi_dung` (PK), `ho_ten`, `email`, `mat_khau`
- `so_dien_thoai`, `dia_chi`, `cccd`, `vai_tro`

### 4. **nhan_vien** - Thông tin nhân viên
- `ma_nhan_vien` (PK), `ho_ten`, `email`, `mat_khau`
- `chuc_vu`, `luong`, `trang_thai`

### 5. **don_thue** - Đơn thuê xe
- `ma_don_thue` (PK), `ma_nguoi_dung` (FK)
- `ngay_thue`, `ngay_tra`, `tong_tien`, `tinh_trang`

### 6. **chi_tiet_don_thue** - Chi tiết đơn thuê
- `ma_chi_tiet` (PK), `ma_don_thue` (FK), `ma_xe` (FK)
- `gia_thue`, `so_ngay_thue`, `thanh_tien`

### 7. **thanh_toan** - Thông tin thanh toán
- `ma_thanh_toan` (PK), `ma_don_thue` (FK)
- `so_tien`, `phuong_thuc`, `ngay_thanh_toan`

### 8. **lien_he** - Liên hệ từ khách hàng
- `ma_lien_he` (PK), `ho_ten`, `email`, `tieu_de`, `noi_dung`

### 9. **faq** - Câu hỏi thường gặp
- `ma_faq` (PK), `cau_hoi`, `cau_tra_loi`, `thu_tu`

## 🛠️ Công nghệ sử dụng

- **Backend:** PHP 8.3+
- **Database:** MySQL 9.1+
- **Frontend:** HTML5, CSS3, JavaScript
- **Session Management:** PHP Sessions
- **Security:** Password hashing, Prepared statements
- **Icons:** Font Awesome 6.5.0

## 📁 Cấu trúc thư mục

```
xeebikes/
├── admin/                    # Trang quản trị
│   ├── index.php            # Dashboard admin
│   ├── vehicles.php         # Quản lý xe
│   ├── users.php           # Quản lý người dùng
│   ├── rentals.php         # Quản lý đơn thuê
│   ├── payments.php        # Quản lý thanh toán
│   └── reports.php         # Báo cáo thống kê
├── css/                     # Stylesheets
│   ├── style.css           # CSS chung
│   ├── dx.css             # CSS trang đặt xe
│   ├── danhsach.css       # CSS danh sách xe
│   ├── chitiet.css        # CSS chi tiết xe
│   └── ...
├── duong_dan_anh/          # Hình ảnh xe máy
├── duongdananh/            # Hình ảnh khác
├── connect.php             # Kết nối database
├── header.php              # Header chung
├── footer.php              # Footer chung
├── trangchu.php            # Trang chủ
├── dang_nhap.php          # Đăng nhập
├── Datxe.php              # Đặt xe & giỏ hàng
├── danh_sach.php          # Danh sách xe
├── chi_tiet_xe.php        # Chi tiết xe
├── lich_su_dat_hang.php   # Lịch sử đặt hàng
├── thong_tin_ca_nhan.php  # Thông tin cá nhân
├── gioithieu.php          # Giới thiệu
├── lienhe1.php            # Liên hệ
├── FQA.php                # Câu hỏi thường gặp
├── chinh_sach_thue_xe.php # Chính sách thuê xe
└── thuexeebikes (1).sql   # Database schema
```

## 🚀 Hướng dẫn cài đặt

### 1. Yêu cầu hệ thống
- **XAMPP/WAMP/MAMP** (Apache, MySQL, PHP 8.3+)
- **Trình duyệt web** hiện đại (Chrome, Firefox, Safari)

### 2. Cài đặt

1. **Clone project:**
   ```bash
   git clone [repository-url]
   cd xeebikes
   ```

2. **Cấu hình database:**
   - Tạo database `thuexeebikes` trong phpMyAdmin
   - Import file `thuexeebikes (1).sql`

3. **Cấu hình kết nối:**
   ```php
   // connect.php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "thuexeebikes";
   ```

4. **Khởi chạy:**
   - Đặt thư mục trong `htdocs` (XAMPP) hoặc `www` (WAMP)
   - Truy cập: `http://localhost/xeebikes`

### 3. Tài khoản mặc định

**Admin:**
- Email: `admin@ebikes.com`
- Password: `password` (cần đặt lại trong database)

**User mẫu:**
- Email: `nguyenvana@example.com`
- Password: `hashed_password_1` (cần đặt lại)

## 🎯 Luồng hoạt động

### Khách hàng:
1. **Đăng ký/Đăng nhập** → Trang chủ
2. **Duyệt xe** → Danh sách/Chi tiết xe
3. **Thêm vào giỏ** → Chọn ngày thuê
4. **Đặt xe** → Xác nhận thông tin
5. **Theo dõi** → Lịch sử đơn hàng

### Admin:
1. **Đăng nhập admin** → Dashboard
2. **Quản lý xe** → Thêm/sửa thông tin xe
3. **Duyệt đơn** → Cập nhật trạng thái
4. **Báo cáo** → Thống kê doanh thu

## 💼 Các loại xe

1. **Xe số:** Wave Alpha, Jupiter, Blade... (110-135cc)
2. **Xe ga:** Vision, Grande, Lead, Air Blade... (125-185cc)
3. **Xe côn tay:** CB150R, R15V4, MT-15... (150-235cc)
4. **Phân khối lớn:** Ninja 400, Z650, MT-07... (400-750cc)

## 🔒 Bảo mật

- **Password hashing:** sử dụng `password_hash()` và `password_verify()`
- **SQL Injection:** Prepared statements cho tất cả queries
- **Session security:** Kiểm tra quyền truy cập mỗi trang
- **Input validation:** Sanitize dữ liệu đầu vào

## 📱 Responsive Design

- **Mobile-first:** Tương thích mọi thiết bị
- **CSS Grid/Flexbox:** Layout linh hoạt
- **Font Awesome:** Icons đẹp và nhất quán

## 🚧 Tính năng mở rộng

- [ ] **API RESTful** cho mobile app
- [ ] **Email notifications** cho đơn hàng
- [ ] **Online payment** integration
- [ ] **GPS tracking** xe thuê
- [ ] **Rating system** đánh giá xe
- [ ] **Multi-language** support

## 📞 Liên hệ

- **Website:** E-BIKES
- **Hotline:** 1900 1234
- **Email:** support@E-BIKES.com
- **Địa chỉ:** Quy Nhơn, Bình Định

## 📄 License

Copyright © 2025 E-BIKES. All rights reserved.

---

**Phát triển bởi:** Nhóm phát triển E-BIKES  
**Phiên bản:** 1.0.0  
**Ngày cập nhật:** 2025 