<?php
session_start(); // Bắt đầu session
if (!isset($_SESSION['user_id'])) {
    header("Location: dang_nhap.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit;
} //Khởi động phiên phpphp
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thuê Xe Máy Quy Nhơn</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #2b2a2a;
  color: #fff;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #1e1d1d;
  padding: 20px 30px;
  color: #f8a100;
  box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
}

.logo {
  font-size: 25px;
  font-weight: bold;
  display: flex;
  align-items: center;
}

nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  align-items: center;
}

nav ul li {
  margin: 0 10px;
  position: relative;
}

nav ul li a, nav ul li button {
  color: #f8a100;
  background: none;
  border: none;
  text-decoration: none;
  font-size: 18px;
  cursor: pointer;
  transition: 0.3s;
}

nav ul li a:hover, nav ul li button:hover {
  color: #dac446;
}

nav ul li ul {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background: #565553;
  padding: 10px;
  border-radius: 10px;
  min-width: 180px;
  z-index: 100;
}

nav ul li:hover ul {
  display: block;
}

nav ul li ul li {
  padding: 10px;
  background-color: #766e6e;
  margin: 5px 0;
  border-radius: 5px;
  text-align: center;
}

nav ul li ul li a {
  color: black;
  text-decoration: none;
  display: block;
}

nav ul li ul li:hover {
  background-color: #ccc;
}

.content {
    padding: 40px;
    text-align: center;
    color: #ebbf92;
}

.grid .item img, .xe-item img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  border-radius: 5px;
  transition: transform 0.3s ease;
}

.grid .item img:hover, .xe-item img:hover {
  transform: scale(1.1);
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    padding: 20px;
    justify-content: center;
}

.grid .item {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
    text-align: center;
    max-width: 300px;
    margin: auto;
}

.grid .item img {
    width: 100%;
    height: 180px;
    object-fit: contain;
    border-radius: 5px;
}

.grid .item p {
    color: #333;
    font-weight: bold;
}như này thì gắn ở đâu


#lien-he {
  text-align: center;
  background-color: #313030;
  padding: 30px;
  border-radius: 5px;
  color: #dac446;
}

footer {
  text-align: center;
  padding: 20px;
  background-color: #005f73;
  color: white;
  box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
}

.btn, .buttons a {
  display: inline-block;
  margin-top: 1rem;
  background: #f39c12;
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 5px;
  text-decoration: none;
  transition: 0.3s;
}

.btn:hover, .buttons a:hover {
  background-color: #e67e22;
}

.xe {
  padding: 2rem 0;
}

.xe-grid {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  justify-content: space-around;
}

.steps {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
}

.steps div {
  background: rgb(250, 237, 179);
  padding: 1rem 2rem;
  border-radius: 8px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.danh-gia {
  padding: 2rem 0;
  background: #fefae0;
  text-align: center;
}

.feedback p {
  font-style: italic;
  margin: 1rem 0;
}

.lien-he {
  padding: 2rem 0;
  text-align: center;
  background: #d9ed92;
}

#toggle-login {
  display: none;
}

.overlay {
  position: fixed;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  display: none;
  justify-content: center;
  align-items: center;
  z-index: 100;
}

.login-form {
  background: rgb(239, 201, 130);
  padding: 2rem;
  border-radius: 10px;
  width: 90%;
  max-width: 400px;
  text-align: center;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

.login-form input {
  width: 100%;
  padding: 0.75rem;
  margin: 0.5rem 0;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.login-form button {
  background: #005f73;
  color: white;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 5px;
  cursor: pointer;
}

.login-form button:hover {
  background: #0a9396;
}

#toggle-login:checked + .overlay {
  display: flex;
}

.close-label {
  position: absolute;
  top: 20px;
  right: 30px;
  font-size: 30px;
  color: white;
  cursor: pointer;
}

.banner {
  text-align: center;
  padding: 50px 20px;
  background: url('banner.jpg') no-repeat center center/cover;
  color: rgb(234, 190, 190);
  text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
}

.banner h1, .banner h2 {
  font-size: 36px;
  margin-bottom: 10px;
}

.banner p {
  font-size: 18px;
  margin-bottom: 20px;
}

.background-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url('PHP/duong_dan_anh/quy-nhon-ivivu-1.jpg') no-repeat center center/cover;
  opacity: 0.3;
  z-index: -1;
}

.container {
  position: relative;
  z-index: 1;
}

.danhgia-lienhe {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  align-items: flex-start;
  gap: 30px;
  padding: 2rem;
  background-color: #3a3a3a;
}

.danhgia-lienhe .danh-gia,
.danhgia-lienhe .lien-he {
  flex: 1 1 400px;
  background: #4a4a4a;
  padding: 20px;
  border-radius: 10px;
  color: #fff;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
}

.feedback p {
  font-style: italic;
  margin: 10px 0;
}

  </style>
</head>
<body>
    <div class="background-overlay"></div>
  <div class="container">
    </div>

  <!-- Header -->
  <!-- <header>
    <div class="logo">🏍 E - BIKES</div>
        <nav>
            <ul>
                <li><a href="trangchu.html">Trang chủ</a></li>
                <li>
                    <button>Danh mục xe▾</button>
                    <ul>
                        <li><a href="#">Tất cả</a></li>
                        <li><a href="#">Xe Số</a></li>
                        <li><a href="#">Xe Ga</a></li>
                        <li><a href="#">Xe Côn & PKL</a></li>
                    </ul>
                </li>
                <li><a href="gioithieu.html">Hướng dẫn</a></li>
                <li><a href="FQA.html">Chính sách</a></li>
                <li><a href="lienhedatxe.html">Liên hệ đặt</a></li>
                <li>
                    <button>👤 Tài khoản ▾</button>
                    <ul>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="dangxuat.php">Đăng xuất</a></li>
                        <?php else: ?>
                            <li><a href="dangnhap.php">Đăng nhập</a></li>
                            <li><a href="dangky.php">Đăng ký</a></li>
                        <?php endif; ?>
                    </ul> 
                </li>
            </ul>
        </nav>
  </header> -->
              <?php include 'header.php'; ?>
  <!-- Banner -->
  <section class="banner">
    <div class="banner-content">
      <h2>Chào mừng bạn đến với E - BIKES</h2>
      <p>Giá rẻ - Giao tận nơi - Thủ tục đơn giản</p>
      <p>Cung cấp cho khách hàng tận chưởng dịch vụ thuê xe chất lượng, an toàn cho khách du lịch.</p>
      <!-- <label for="toggle-login" class="btn">Thuê ngay</label> -->
    </div>
  </section>

  <section id="gioi-thieu" class="content">
		<h1>Về Chúng Tôi</h1>
        <p>
            E - BIKES chuyên cung cấp cho khách hàng thuê xe dịch vụ một chuyến đi đầy đủ tiện nghi, an toàn, thoải mái, đưa ra các chính sách để khách hàng yên tâm sử dụng dịch vụ.
        </p>
        <p>
            Chúng tôi cam kết mang đến những chiếc xe điện chất lượng cao, bảo trì thường xuyên và luôn trong tình trạng tốt nhất. Đội ngũ nhân viên tận tâm, nhiệt tình sẽ hỗ trợ khách hàng trong suốt quá trình sử dụng, từ lúc đặt xe đến khi kết thúc hành trình.
        </p>
        <p>
            Ngoài ra, E - BIKES còn cung cấp các gói thuê đa dạng theo giờ, theo ngày hoặc theo tuần, phù hợp với nhu cầu của từng khách hàng, đặc biệt là khách du lịch muốn khám phá địa phương một cách chủ động và thân thiện với môi trường.
        </p>
        <p>
            Hãy đồng hành cùng E - BIKES để trải nghiệm sự tiện lợi, hiện đại và thân thiện với môi trường trong mỗi chuyến đi của bạn!
        </p>
	</section>

  <!-- <input type="checkbox" id="toggle-login"> -->

  <div class="overlay">
    <!-- Nút đóng -->
    <label for="toggle-login" class="close-label">&times;</label>

    <form class="login-form">
      <h2>Đăng nhập</h2>
      <input type="text" placeholder="Tên đăng nhập" required>
      <input type="password" placeholder="Mật khẩu" required>
      <button type="submit">Đăng nhập</button>
    </form>
  </div>


  <!-- Danh sách xe -->
  <section id="xe" class="content">
		<h2>Xe nổi bật</h2>
		<div class="grid">
			<div class="item">
				<!-- <img src="/x5.jpg" alt="Xe so"> -->
         <img src="duong_dan_anh/x5.jpg" alt="Xe so">
				<p>Xe sirius 150cc</p>
			</div>
			<div class="item">
				<!-- <img src="../x17.jpg" alt="Xe tay ga"> -->
         <img src="duong_dan_anh/x17.jpg" alt="Xe tay ga">
				<p>Xe Air blade</p>
			</div>
			<div class="item">
				<!-- <img src="../x30.jpg" alt="Xe pkl kawasaki"> -->
         <img src="duong_dan_anh/x30.jpg" alt="Xe pkl kawasaki">
				<p>Xe Kawasaki</p>
			</div>
			<div class="item">
				<!-- <img src="../x22.jpg" alt="Xe pkl"> -->
         <img src="duong_dan_anh/x22.jpg" alt="Xe pkl">
				<p>Xe moto R15-V3</p>
			</div>
		</div>
	</section>

  <!-- <section class="danhgia-lienhe">
  <div class="danh-gia">
    <h2>Đánh giá khách hàng</h2>
    <div class="feedback">
      <p>"Xe sạch sẽ, giao đúng giờ!" – Minh, Hà Nội</p>
      <p>"Thủ tục đơn giản, giá hợp lý." – Trang, TP.HCM</p>
      <P>"Đội ngũ nhân viên vui vẻ, xe sạch sẽ." - Hưng, Gia Lai</P>
      <p>"Nếu có trở lại tôi vẫn sẽ lựa chọn xe ở đây, nó rất tuyệt vời" - Jushan Bakid, Ấn Độ</p>
    </div>
  </div>
  <div class="lien-he">
    <h2>Liên hệ</h2>
    <p>🏠 170 An Dương Vương, thành phốphố Quy Nhơn</p>
    <p>📞 083 6333 358</p>
    <p>📧 hello@ebikes.com</p>
    <p><i class="fab fa-facebook" style="color: #1877f2;"></i> 
      <a href="https://www.facebook.com/share/g/16b4J61hsz/" target="_blank" style="color: #dac446;">facebook.com/thuexemay.vn</a>
    </p>
  </div>
</section> -->


  <!-- Footer -->
  <!-- <footer>
    <p>&copy; 2025 Dịch vụ cho thuê xe máy du lịch. All rights reserved.</p>
  </footer> -->
<?php include 'footer.php'; ?>
</body>
</html>
