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
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($row['dong_xe']) ?> - Chi tiết xe</title>
    <link rel="stylesheet" href="vidu1.css">
</head>
<body>

<h1>Chi tiết xe: <?= htmlspecialchars($row['dong_xe']) ?></h1>

<div class="chi-tiet-xe">
    <img src="<?= htmlspecialchars($row['duong_dan_anh']) ?>" alt="<?= htmlspecialchars($row['dong_xe']) ?>" width="300">
    <ul>
        <li><strong>Hãng xe:</strong> <?= htmlspecialchars($row['hang_xe']) ?></li>
        <li><strong>Màu sắc:</strong> <?= htmlspecialchars($row['mau_sac']) ?></li>
        <li><strong>Dung tích xi lanh:</strong> <?= htmlspecialchars($row['dung_tich_xi_lanh']) ?>cc</li>
        <li><strong>Mô tả:</strong> <?= htmlspecialchars($row['mo_ta']) ?></li>
        <li><strong>Giá thuê:</strong> <?= number_format($row['gia_thue'], 0, ',', '.') ?>đ/ngày</li>
    </ul>
</div>

<h2>Thông tin đặt xe</h2>
<form action="#" method="post">
    <p>
        <label><input type="checkbox" name="giao_tai_nha"> Giao xe tại nhà</label><br>
        <label>Địa chỉ nhận xe (nếu có): <input type="text" name="dia_chi"></label>
    </p>
    <p>
        <label>Ngày nhận: <input type="datetime-local" name="ngay_nhan"></label><br>
        <label>Ngày trả: <input type="datetime-local" name="ngay_tra"></label>
    </p>
    <p>
        <strong>Hình thức thanh toán:</strong><br>
        <label><input type="radio" name="thanh_toan" value="tra_truoc" checked> Trả trước</label><br>
        <label><input type="radio" name="thanh_toan" value="tra_sau"> Trả sau</label>
    </p>
    <p><button type="submit">Đặt xe</button></p>
</form>

</body>
</html>
<?php
$conn->close();
?>
