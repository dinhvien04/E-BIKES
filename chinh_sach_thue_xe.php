<?php
include 'connect.php';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$sql = "SELECT * FROM xe_may WHERE 1";

if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($conn, $search);
    $sql .= " AND dong_xe LIKE '%$search_safe%'";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Chính Sách Thuê Xe Máy</title>
  <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="css/chinhsach.css">
</head>
<body>
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
                <li><a href="#">Trang chủ</a></li>
                <li><a href="#">Xe</a></li>
                <li><a href="#">Tin tức</a></li>
                <li><a href="#">Chính sách</a></li>
                <li><a href="#">Liên hệ</a></li>
            </ul>
        </nav>
    </header>

  <main>
    <h1>Chính Sách Thuê Xe Máy</h1>

    <div class="accordion-item">
  <div class="accordion-title">Thời gian thuê xe</div>
  <div class="accordion-content">
    <p>Việc tính phí thuê xe được áp dụng linh hoạt theo <strong>ngày</strong> và <strong>giờ phát sinh</strong>, cụ thể như sau:</p>
    <ul>
      <li><strong>01 ngày thuê</strong> tương đương <strong>24 giờ</strong>, tính từ thời điểm nhận xe hôm nay đến đúng thời điểm đó vào ngày hôm sau.</li>
      <li><strong>Giờ phát sinh</strong> chỉ áp dụng khi bạn thuê xe <strong>vượt quá 1 ngày</strong>.</li>
    </ul>

    <p><strong>Mức phí giờ phát sinh:</strong></p>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px;">
      <thead>
        <tr style="background-color: #444;">
          <th style="padding: 10px; border: 1px solid #666; color: #f8a100;">Loại xe</th>
          <th style="padding: 10px; border: 1px solid #666; color: #f8a100;">Phí giờ phát sinh</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding: 10px; border: 1px solid #666;">Xe số</td>
          <td style="padding: 10px; border: 1px solid #666;">15.000đ / giờ</td>
        </tr>
        <tr>
          <td style="padding: 10px; border: 1px solid #666;">Xe tay ga</td>
          <td style="padding: 10px; border: 1px solid #666;">20.000đ / giờ</td>
        </tr>
      </tbody>
    </table>

    <p><em>Lưu ý:</em> Nếu tổng số giờ phát sinh <strong>trên 8 giờ</strong>, hệ thống sẽ tính tròn thành <strong>01 ngày thuê</strong>.</p>

  </div>
</div>


<div class="accordion-item">
  <div class="accordion-title">Thủ tục thuê xe</div>
  <div class="accordion-content">
    <p>Khách thuê xe cần thực hiện các bước thủ tục sau:</p>

    <ol>
      <li>
        <strong>Đáp ứng điều kiện:</strong> Khách thuê xe phải đủ tuổi lái xe theo quy định pháp luật và có <strong>Giấy phép lái xe hợp lệ</strong> được cấp bởi cơ quan nhà nước có thẩm quyền.
      </li>

      <li>
        <strong>Chuẩn bị giấy tờ:</strong><br>
        Tùy đối tượng khách, yêu cầu giấy tờ như sau:
        <ul>
          <li><strong>Khách du lịch (đi bằng máy bay):</strong> Cần để lại <strong>CMND, CCCD hoặc Hộ chiếu</strong> kèm <strong>thông tin chuyến bay đến và rời.</strong></li>
          <li><strong>Khách địa phương hoặc không đi bằng máy bay:</strong>
            <ul>
              <li>Để lại <strong>CMND, CCCD hoặc Hộ chiếu</strong> kèm <strong>Sổ hộ khẩu</strong>.</li>
              <li>Nếu không có Sổ hộ khẩu:
                <ul>
                  <li>Đặt cọc <strong>3.000.000đ</strong> đối với <strong>xe số</strong></li>
                  <li>Đặt cọc <strong>5.000.000đ</strong> đối với <strong>xe tay ga</strong></li>
                  <li>Số tiền sẽ được <strong>hoàn trả 100%</strong> sau khi hoàn tất thủ tục trả xe.</li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </li>

      <li><strong>Ký hợp đồng:</strong> Khách hàng đồng ý các điều khoản và ký <strong>Hợp đồng thuê xe</strong> giữa hai bên.</li>

      <li><strong>Nhận xe:</strong> Sau khi hoàn tất thủ tục, khách sẽ được giao xe để sử dụng.</li>
    </ol>
  </div>
</div>

    <div class="accordion-item">
  <div class="accordion-title">Trách nhiệm bên thuê</div>
  <div class="accordion-content">
    <ul>
      <li>Người thuê xe có trách nhiệm <strong>tự đổ nhiên liệu</strong> để sử dụng xe.</li>
      <li>Kiểm tra kỹ tình trạng xe trước khi nhận; không bóc, rách tem bảo hành và không được tự ý sửa chữa, thay thế chi tiết xe khi chưa được sự đồng ý của bên cho thuê.</li>
      <li>Trong thời gian sử dụng, người thuê phải:
        <ul>
          <li>Tuân thủ luật giao thông Việt Nam.</li>
          <li>Giữ gìn, bảo vệ xe đúng quy định.</li>
        </ul>
      </li>
      <li>Nếu có hỏng hóc xảy ra, người thuê cần <strong>báo ngay cho bên cho thuê</strong> để cùng thống nhất phương án xử lý.</li>
      <li>Các hư hại do lỗi của người thuê như: bẹp, nứt, vỡ, móp méo,... phải thay mới bằng phụ tùng chính hãng (không chấp nhận gò, hàn).</li>
      <li>Với các lỗi nhẹ như xước, bẹp nhỏ, không cần thay mới, người thuê sẽ <strong>bồi thường theo giá thị trường</strong>.</li>
      <li>Thủng săm/lốp trong quá trình sử dụng, người thuê tự xử lý và thanh toán chi phí.</li>
      <li><strong>Ngày không sử dụng xe vẫn tính phí thuê</strong> nếu nguyên nhân do lỗi của người thuê.</li>
    </ul>
  </div>
</div>


    <div class="accordion-item">
  <div class="accordion-title">Trách nhiệm bên cho thuê</div>
  <div class="accordion-content">
    <ul>
      <li>Bên cho thuê phải đảm bảo xe có <strong>đầy đủ điều kiện an toàn</strong> để lưu thông, đúng như <strong>cam kết thỏa thuận</strong> với khách hàng.</li>
      <li>Mỗi xe cho thuê sẽ đi kèm <strong>02 mũ bảo hiểm đạt chuẩn</strong>.</li>
      <li>Cung cấp <strong>bản photo giấy đăng ký xe</strong> và <strong>bảo hiểm trách nhiệm dân sự</strong> cho người thuê.</li>
      <li><strong>Hỗ trợ, hướng dẫn, giúp đỡ</strong> khách hàng trong các tình huống cần sự có mặt của chủ xe.</li>
      <li>Trường hợp <strong>dịch vụ không đúng như cam kết</strong>, khách hàng có quyền <strong>từ chối sử dụng dịch vụ</strong> hoặc <strong>yêu cầu đổi xe</strong>. Bên cho thuê <strong>phải hoàn trả toàn bộ tiền đặt cọc</strong>.</li>
      <li>Nếu khách hàng <strong>trả xe sớm hơn thời gian thuê</strong>, hợp đồng sẽ kết thúc tại thời điểm trả xe và <strong>tiền thừa được hoàn lại</strong>.</li>
      <li>Khách đã đặt xe có thể <strong>hủy lịch bất kỳ lúc nào</strong> mà <strong>không phải chịu chi phí</strong> nào thêm.</li>
    </ul>
  </div>
</div>

  </main>
<script>

document.querySelectorAll('.accordion-title').forEach(item => {

item.addEventListener('click', () => {

const parent = item.parentElement;

parent.classList.toggle('active');

});

});

</script>
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
