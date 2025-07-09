
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liên Hệ - Thuê Xe Máy E-BIKE</title>
  <link rel="stylesheet" href="css/lienhe1.css">
</head>
<body>

  <header>📍 Liên Hệ - Thuê Xe Máy E-BIKE</header>

  <div class="container">
    <div class="two-columns">
      <!-- FORM -->
      <div class="left-column">
        <h2>📝 Đặt Xe</h2>
        <form>
          <input type="text" placeholder="Họ tên của bạn (bắt buộc)" required>
          <input type="tel" placeholder="Số điện thoại (bắt buộc)" required>
          <input type="email" placeholder="Email của bạn (bắt buộc)" required>
          <input type="text" placeholder="Tiêu đề">
          <textarea rows="5" placeholder="Lời nhắn..."></textarea>
          <button type="submit">Gửi yêu cầu tư vấn</button>
        </form>
      </div>

      <!-- MAP -->
      <div class="right-column">
        <h2>📍 Vị Trí</h2>
        <iframe id="mapFrame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d503805.73042369464!2d108.82939601113957!3d14.166532955421092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317ffddf8d1048a1%3A0xa60eb18bc1df6d3b!2zQsOsbmggxJDDrG5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1649700366237!5m2!1svi!2s" allowfullscreen="" loading="lazy"></iframe>
        <button onclick="getLocation()">📌 Tìm Vị Trí Của Tôi</button>
        <p id="location-status"></p>
      </div>
    </div>

    <!-- FAQ -->
    <div class="faq">
      <h2>❓ Câu Hỏi Thường Gặp</h2>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Thủ tục thuê xe cần giấy tờ gì?</h3>
        <p>CMND/CCCD bản gốc + Giấy phép lái xe hợp lệ.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Có giao xe tận nơi không?</h3>
        <p>Có, E-BIKE hỗ trợ giao xe tận nơi trong nội thành.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Chính sách đặt cọc như thế nào?</h3>
        <p>Đặt cọc từ 500k - 2 triệu tùy dòng xe. Có thể thế chấp giấy tờ.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Có hỗ trợ giao/nhận xe ở bến xe, sân bay không?</h3>
        <p>Có! Bạn chỉ cần đặt trước và chọn điểm nhận.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Thuê nhiều ngày có được giảm giá không?</h3>
        <p>Dĩ nhiên! Càng thuê lâu càng rẻ nha 😎</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Có cho thuê theo giờ không, hay chỉ tính theo ngày?</h3>
        <p>Bọn mình chỉ tính theo ngày thôi, không hỗ trợ thuê theo giờ.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Xe có mũ bảo hiểm, áo mưa đi kèm không?</h3>
        <p>Có luôn! FREE combo mũ + áo mưa + nước suối.</p>
      </div>

      <div class="faq-item">
        <h3 onclick="toggleAnswer(this)">✅ Phải đặt trước bao lâu để chắc chắn có xe?</h3>
        <p>Tốt nhất là đặt trước ít nhất 12 tiếng. Lễ/tết nên book sớm hơn nha!</p>
      </div>
    </div>

    <!-- Contact -->
    <div class="contact-info">
      <h2>📞 Liên Hệ & Kết Nối</h2>
      <p><strong>📍 Địa chỉ:</strong> 170 Hùng Vương, TP Quy Nhơn, Bình Định</p>
      <p><strong>📞 Hotline:</strong> 0256 123 456</p>
      <p><strong>📧 Email:</strong> thuexe@ebike.com</p>
      <p><strong>🕒 Giờ làm việc:</strong> 24/7</p>
      <div class="social-links">
        <a href="https://zalo.me/037 660 1589" target="_blank">
          <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Icon_of_Zalo.svg" alt="Zalo">
        </a>
        <a href="https://www.facebook.com/share/g/16b4J61hsz/" target="_blank">
          <img src="https://upload.wikimedia.org/wikipedia/commons/8/83/Facebook_Messenger_4_Logo.svg" alt="Messenger">
        </a>
      </div>
    </div>
  </div>

  <footer>&copy; 2025 Dịch vụ thuê xe E-BIKE</footer>

  <script>
    function getLocation() {
      if (navigator.geolocation) {
        document.getElementById("location-status").innerHTML = "⏳ Đang lấy vị trí...";
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        document.getElementById("location-status").innerHTML = "⚠️ Trình duyệt không hỗ trợ định vị.";
      }
    }

    function showPosition(position) {
      let lat = position.coords.latitude;
      let lon = position.coords.longitude;
      document.getElementById("mapFrame").src = `https://www.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
      document.getElementById("location-status").innerHTML = "✅ Đã định vị!";
    }

    function showError() {
      document.getElementById("location-status").innerHTML = "⚠️ Không thể lấy vị trí.";
    }

    function toggleAnswer(el) {
      const answer = el.nextElementSibling;
      answer.style.display = answer.style.display === "block" ? "none" : "block";
    }
  </script>

</body>
</html>
