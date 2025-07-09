<?php 
include 'header.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu Công Ty</title>
    <style>
        body {


            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #2b2a2a;
            color: #E0E0E0;
        }

        header {
            background-color: #1e1d1d;
            color: #f8a100;
            text-align: center;
            padding: 20px 30px;
			box-shadow: 0 4px 10px rgba(255, 102, 0, 0.5);
        }

        header h1 {
            font-size: 2.5rem;
        }

        .container {
            width: 85%;
            margin: 0 auto;
            padding: 2rem;
        }

        h2 {
            color: #f8a100;
            margin-bottom: 1rem;
        }

        p {
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

         .image-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        gap: 20px;
        margin-top: 20px;
    }

    .image-item {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        text-align: center;
    }

    .image-item img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    .image-item h3 {
        font-size: 1.2rem;
        color: #f8a100;
        margin-bottom: 10px;
    }

    .image-item p {
        font-size: 1rem;
        color: #555;
        line-height: 1.5;
    }
    @media (max-width: 768px) {
        .image-gallery {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .image-gallery {
            grid-template-columns: 1fr;
        }
    }
/* Phần Footer */
footer {
    background-color: #313030;
    color: #f8a100;
    padding: 20px;
    font-size: 1rem;
    margin-top: 20px;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}

.footer-left, .footer-center, .footer-right {
    width: 30%;
}

.footer-left h3 {
    margin-bottom: 0.5rem;
}

.footer-left p {
    margin: 0.5rem 0;
}

.footer-center h4, .footer-right h4 {
    color: #f8a100;
    margin-bottom: 1rem;
}

.footer-center ul {
    list-style-type: none;
    padding: 0;
}

.footer-center ul li {
    margin: 0.5rem 0;
}

.footer-center ul li a {
    color: #f8a100;
    text-decoration: none;
}

.footer-center ul li a:hover {
    text-decoration: underline;
}

.social-icons a {
    margin-right: 15px;
    text-decoration: none;
}

.social-icons img {
    width: 30px;
    height: 30px;
}

.footer-bottom {
    text-align: center;
    margin-top: 2rem;
}

.footer-bottom p {
    margin: 0.5rem 0;
}

.footer-bottom a {
    color: #313030;
    text-decoration: none;
}

.footer-bottom a:hover {
    text-decoration: underline;
}
/* Phần liên hệ */
#lien-he {
    text-align: center;
    background-color: #2c3e50; /* Màu nền xám tối */
    padding: 30px;
    border-radius: 5px;
    color: white; /* Màu trắng cho chữ */
    margin-top: 3rem; /* Khoảng cách phía trên */
}

#lien-he h2 {
    font-size: 1.8rem; /* Kích thước chữ tiêu đề */
    color: #f8a100; /* Màu cam sáng cho tiêu đề */
    margin-bottom: 20px; /* Khoảng cách dưới tiêu đề */
}

#lien-he p {
    font-size: 1.1rem; /* Kích thước chữ cho đoạn văn */
    margin: 10px 0; /* Khoảng cách trên/dưới các đoạn văn */
    line-height: 1.6; /* Khoảng cách giữa các dòng */
}

#lien-he a {
    color: white; /* Màu vàng nhạt cho liên kết */
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease, text-decoration 0.3s ease; /* Hiệu ứng chuyển màu và gạch chân */
}

#lien-he a:hover {
    color: #f8a100; /* Màu cam sáng khi hover */
    text-decoration: underline; /* Gạch chân khi hover */
}

#lien-he a:focus {
    outline: none; /* Loại bỏ viền focus mặc định khi nhấn vào liên kết */
    color: #f8a100; /* Giữ màu khi focus vào liên kết */
}

    </style>
</head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Car Rental</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>
    <!-- <header>
        <h1>Giới Thiệu Công Ty E-BIKES</h1>
    </header> -->
   

    <div class="container">
        <section class="section">
            <h2>Giới Thiệu Về Công Ty E-BIKES</h2>
            <p>Chúng tôi, <strong>E-BIKES</strong>, là một trong những công ty hàng đầu trong ngành cho thuê xe với hơn <strong>20 năm</strong> năm kinh nghiệm. Với phương tiện hiện đại, và một mạng lưới bãi xe rộng khắp, chúng tôi cam kết mang lại dịch vụ tốt nhất cho khách hàng, đồng thời luôn đề cao tính an toàn và hiệu quả trong công việc.</p>
        </section>
        <section class="section">
            <h2>Kinh Nghiệm</h2>
            <p>Với nhiều năm hoạt động, <strong>E-BIKES</strong> đã trở thành đối tác tin cậy của nhiều khách hàng trong và ngoài nước. Chúng tôi tự hào với những kinh nghiệm sau:</p>
            <ul>
                <li>Hệ thống bãi xe được quản lý và bảo dưỡng thường xuyên, đảm bảo luôn sẵn sàng phục vụ.</li>
                <li>Công nghệ giám sát và theo dõi hiện đại giúp tối ưu hóa lộ trình và giảm thiểu thời gian chờ đợi.</li>
                <li>Đáp ứng linh hoạt mọi nhu cầu của khách hàng, từ vận chuyển hàng hóa đến dịch vụ giao hàng nhanh.</li>
            </ul>
        </section>
        <section class="section">
            <h2>Tầm Nhìn</h2>
            <p>Tầm nhìn của chúng tôi là trở thành công ty dẫn đầu trong ngành cho thuê xe tại Việt Nam và khu vực, không ngừng cải tiến chất lượng dịch vụ, sáng tạo giải pháp vận chuyển tối ưu, và phát triển một hệ thống bền vững cho tương lai. Chúng tôi cam kết tạo ra giá trị bền vững cho khách hàng và cộng đồng.</p>
        </section>
        <section class="section">
            <h2>Sứ Mệnh</h2>
            <p>Sứ mệnh của <strong>E-BIKES</strong> là cung cấp dịch vụ vận chuyển an toàn, hiệu quả và nhanh chóng, đảm bảo sự hài lòng tuyệt đối cho khách hàng. Chúng tôi cam kết luôn sáng tạo và đổi mới, mang lại giải pháp phù hợp nhất cho từng nhu cầu cụ thể của khách hàng.</p>
        </section>
        <section class="section">
    <h2>Hình Ảnh Thực Tế: Đội Xe và Bãi Xe</h2>
    <p>Chúng tôi tự hào về đội xe hiện đại và bãi xe rộng rãi, được bảo dưỡng thường xuyên để đảm bảo chất lượng dịch vụ tốt nhất. Dưới đây là một số hình ảnh thực tế của đội xe và bãi xe của công ty:</p>
    <div class="image-gallery">
        <div class="image-item">
            <h3>Đội Xe Chuyên Nghiệp</h3>
            <img src="z6467864168081_9cf78ffe500862408cc198f94691a9a4.jpg" alt="Đội xe 1">
            <p>Đội xe của chúng tôi gồm những chiếc xe hiện đại, được bảo trì và kiểm tra thường xuyên để phục vụ khách hàng một cách tốt nhất.</p>
        </div>
        <div class="image-item">
            <h3>Phương Tiện Đa Dạng</h3>
            <img src="z6467864168885_871054673d76e6f88e33e24b94034ca2.jpg" alt="Đội xe 2">
            <p>Chúng tôi cung cấp nhiều loại phương tiện, từ xe tải đến xe tải nhẹ, đáp ứng mọi nhu cầu vận chuyển của khách hàng.</p>
        </div>
        <div class="image-item">
            <h3>Xe Chuyên Chở Hàng Hóa</h3>
            <img src="z6467864174094_1cfe50d44624788ba8c933b4a439e9aa.jpg" alt="Đội xe 3">
            <p>Các phương tiện của chúng tôi được trang bị đầy đủ để vận chuyển hàng hóa một cách an toàn và hiệu quả.</p>
        </div>
    </div>
    <div class="image-gallery">
        <div class="image-item">
            <h3>Bãi Xe Rộng Rãi</h3>
            <img src="z6467864175634_6fd54147ea8154ba9bfcc90f98b279c8.jpg" alt="Bãi xe 1">
            <p>Bãi xe của chúng tôi rộng rãi và được tổ chức khoa học, giúp dễ dàng tìm kiếm và bảo vệ xe của khách hàng.</p>
        </div>
        <div class="image-item">
            <h3>Đảm Bảo An Toàn</h3>
            <img src="z6467864183128_696e914a16afa64ecfab573e90fcd6e2.jpg" alt="Bãi xe 2">
            <p>Bãi xe được giám sát 24/7, đảm bảo an toàn tuyệt đối cho các phương tiện của khách hàng khi gửi tại đây.</p>
        </div>
        <div class="image-item">
            <h3>Bãi Xe Hiện Đại</h3>
            <img src="z6467864197377_cfa00ed04c9efeaa9b726015a2aa5f0a.jpg" alt="Bãi xe 3">
            <p>Với các trang thiết bị hiện đại và quy trình quản lý chuyên nghiệp, bãi xe của chúng tôi luôn trong tình trạng sẵn sàng phục vụ mọi nhu cầu.</p>
        </div>
    </div>
</section>


    </div>
<footer>
    <div class="footer-container">
        <div class="footer-left">
            <h3>E-BIKES</h3>
            <p>Địa chỉ: 170 An Dương Vương</p>
            <p>Điện thoại: <a href="tel:19001773">19001773</a></p>
            <p>Email: <a href="mailto:contact@company.com">contact@company.com</a></p>
        </div>
        <div class="footer-center">
            <h4>Liên Kết Nhanh</h4>
            <ul>
                <li><a href="trangchu.php">Trang Chủ</a></li>
                <li><a href="lienhe1.php">Liên Hệ</a></li>
                <li><a href="FQA.php">Câu Hỏi Thường Gặp</a></li>
            </ul>
        </div>
        <div class="footer-right">
            <h4>Kết Nối Với Chúng Tôi</h4>
            <div class="social-icons">
                <a href=https://www.facebook.com/share/g/1BufbApXZW/ target="_blank">
                    <img src= "C:\Users\yenlu\Pictures\z6467903137707_4de6625ce8519e08e3767348081357b8.jpg"alt="facebook" />
                </a>
                <a href="https://twitter.com/yourcompany" target="_blank">
                    <img src="C:\Users\yenlu\Pictures\z6467903127175_fd1c60fd9d6fd4bb575e85b62865eb8e.jpg" alt="Twitter" />
                </a>
                <a href="https://www.linkedin.com/company/yourcompany" target="_blank">
                    <img src="C:\Users\yenlu\Pictures\z6467903128894_e0c1e7c1f2b4050cf7b8723b1afa3ce4.jpg" alt="LinkedIn" />
                </a>
                <a href="https://www.instagram.com/yourcompany" target="_blank">
                    <img src="C:\Users\yenlu\Pictures\z6467903135930_b96f8ebe0db8a33fcb9a6838fdf3f1df.jpg" alt="Instagram" />
                </a>
            </div>
        </div>
    </div>
</footer>
    <section id="lien-he">
        <div class="footer-bottom">
            <p>&copy; 2025 <strong>E-BIKES</strong>. Tất cả quyền được bảo vệ.</p>
            <p>Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn. Đọc thêm tại <a href="privacy-policy.html">Chính Sách Bảo Mật</a> và <a href="terms-of-service.html">Điều Khoản Dịch Vụ</a>.</p>
        </div>
    </section>
</body>
</html>
