<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: dang_nhap.php");
    exit;
}
require 'connect.php';

$sql = "SELECT * FROM xe_may";
$result = $conn->query($sql);
$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['ma_xe']] = $row;
    }
}
$id = isset($_GET["id"]) ? $_GET["id"] : null;

// Nếu có ma_xe trên URL (GET), thêm vào giỏ hàng
if (isset($_GET['ma_xe'])) {
    $ma_xe = (int)$_GET['ma_xe'];
    if (isset($products[$ma_xe])) {
        if (isset($_SESSION['cart'][$ma_xe])) {
            $_SESSION['cart'][$ma_xe]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$ma_xe] = [
                'name' => $products[$ma_xe]['dong_xe'],
                'price' => $products[$ma_xe]['gia_thue'],
                'quantity' => 1
            ];
        }
        $_SESSION['message'] = 'Đã thêm xe vào giỏ hàng!';
    }
    // Xóa ma_xe khỏi URL để tránh thêm lại khi refresh
    header('Location: Datxe.php');
    exit();
}

$user_id = $_SESSION['user_id'];
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$user_info = [
    'ho_ten' => '',
    'so_dien_thoai' => '',
    'email' => '',
    'cccd' => ''
];
$user_sql = "SELECT ho_ten, so_dien_thoai, email, cccd FROM nguoi_dung WHERE ma_nguoi_dung = ? LIMIT 1";
if ($stmt = $conn->prepare($user_sql)) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($user_info['ho_ten'], $user_info['so_dien_thoai'], $user_info['email'], $user_info['cccd']);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ma_xe'])) {
    $ma_xe = (int)$_POST['ma_xe'];
    if (isset($products[$ma_xe])) {
        if (isset($_SESSION['cart'][$ma_xe])) {
            $_SESSION['cart'][$ma_xe]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$ma_xe] = [
                'name' => $products[$ma_xe]['dong_xe'],
                'price' => $products[$ma_xe]['gia_thue'],
                'quantity' => 1
            ];
        }
        $_SESSION['message'] = 'Đã thêm xe vào giỏ hàng!';
    }
    header('Location: Datxe.php');
    exit();
}

if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        $qty = max(0, (int)$qty);
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
            // Nếu quantity = 0 thì xóa khỏi giỏ
            if ($qty == 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    $_SESSION['message'] = 'Cập nhật thành công!';
}

// Tính số ngày thuê
function getRentalDays() {
    if (isset($_POST['date']) && isset($_POST['return_date'])) {
        $start = strtotime($_POST['date']);
        $end = strtotime($_POST['return_date']);
        $days = ($end - $start) / (60*60*24);
        return ($days >= 1) ? $days : 1;
    } elseif (isset($_SESSION['order']['date']) && isset($_SESSION['order']['return_date'])) {
        $start = strtotime($_SESSION['order']['date']);
        $end = strtotime($_SESSION['order']['return_date']);
        $days = ($end - $start) / (60*60*24);
        return ($days >= 1) ? $days : 1;
    }
    return 1;
}

function calculateTotal() {
    $total = 0;
    $days = getRentalDays();
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if (isset($item['price'], $item['quantity'])) {
                $total += $item['price'] * $item['quantity'] * $days;
            }
        }
    }
    return $total;
}

function formatCurrency($amount)
{
    return number_format($amount, 0, ',', '.') . 'đ';
}

if (isset($_POST['submit_order'])) {
    // Lấy dữ liệu từ form
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $cmd = $_POST['cmd'];
    $date = $_POST['date'];
    $return_date = $_POST['return_date'];
    $time = $_POST['time'];
    $note = $_POST['note'];
    $tong_tien = calculateTotal();

    // Tính số ngày thuê
    $so_ngay_thue = 1;
    if ($date && $return_date) {
        $start = strtotime($date);
        $end = strtotime($return_date);
        $so_ngay_thue = ($end - $start) / (60*60*24);
        if ($so_ngay_thue < 1) $so_ngay_thue = 1;
    }

    // Lưu vào bảng don_thue
    $sql = "INSERT INTO don_thue (ma_nguoi_dung, ngay_thue, ngay_tra, tong_tien, tinh_trang) VALUES (?, ?, ?, ?, 'da_dat')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isss', $user_id, $date, $return_date, $tong_tien);
    $stmt->execute();
    $ma_don_thue = $stmt->insert_id;

    // Lưu chi tiết đơn thuê
    foreach ($_SESSION['cart'] as $ma_xe => $item) {
        $sql_ct = "INSERT INTO chi_tiet_don_thue (ma_don_thue, ma_xe, gia_thue, so_ngay_thue, thanh_tien) VALUES (?, ?, ?, ?, ?)";
        $stmt_ct = $conn->prepare($sql_ct);
        $thanh_tien = $item['price'] * $item['quantity'] * $so_ngay_thue;
        $stmt_ct->bind_param('iiidd', $ma_don_thue, $ma_xe, $item['price'], $so_ngay_thue, $thanh_tien);
        $stmt_ct->execute();
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Chuyển sang trang thành công
    header('Location: datxe_thanhcong.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Xe - E-BIKES</title>
    <link rel="stylesheet" href="css/dx.css">
    <script>
        function confirmOrder() {
            const confirmCheck = confirm("Bạn có muốn kiểm tra lại thông tin trước khi đặt không?\n\nNhấn 'OK' để tiếp tục đặt xe.\nNhấn 'Cancel' để quay lại kiểm tra.");
            return confirmCheck;
        }
    </script>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert-success">
            Đặt xe thành công! Cảm ơn bạn.
        </div>
    <?php endif; ?>


</head>

<body>
    <?php include 'header.php'; ?>

    <div class="main-container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success">
                <?= $_SESSION['message'];
                unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <div class="booking-container">
            <div class="section-header">
                <i class="fa-solid fa-cart-shopping"></i> ĐẶT XE E-BIKES
            </div>

            <div class="section">
                <h2><i class="fas fa-list"></i> Danh Sách Xe</h2>
                <form method="post" action="">
                    <table>
                        <thead>
                            <tr>
                                <th>Hãng xe</th>
                                <th>Dòng xe</th>
                                <th>Số Lượng</th>
                                <th>Giá Thuê</th>
                                <th>Tạm Tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $id => $item):
                                if ($item['quantity'] <= 0) continue;
                                $product = $products[$id];
                                $quantity = $item['quantity'];
                                $price = $item['price'];
                                $total = $price * $quantity;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['hang_xe']) ?></td>
                                    <td><?= htmlspecialchars($product['dong_xe']) ?></td>
                                    <td>
                                        <input type="number"
                                            name="qty[<?= $id ?>]"
                                            class="quantity-input"
                                            min="0"
                                            max="<?= $product['so_luong'] ?? 0 ?>"
                                            value="<?= $quantity ?>">
                                        <span class="available-quantity">(Hiện có: <?= $product['so_luong'] ?? 0 ?>)</span>
                                    </td>
                                    <td><?= formatCurrency($price) ?>/ngày</td>
                                    <td class="item-total">
                                        <?= formatCurrency($price * $quantity * (isset($_SESSION['order']['date'], $_SESSION['order']['return_date']) ? max(1, (strtotime($_SESSION['order']['return_date'])-strtotime($_SESSION['order']['date']))/86400) : 1)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Tổng cộng:</td>
                                <td><?= formatCurrency(calculateTotal()) ?></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="cart-actions">
                        <a href="danh_sach.php" class="cart-btn continue-btn">
                            <i class="fas fa-arrow-left"></i> Tiếp tục xem sản phẩm
                        </a>
                        <button type="submit" name="update_cart" class="cart-btn update-cart-btn">
                            <i class="fas fa-sync-alt"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>

            <form class="booking-form" method="post">
                <div class="details-container">
                    <div class="left-section">
                        <h2><i class="fas fa-info-circle"></i> Thông Tin Đặt Xe</h2>
                        <label for="full-name"><i class="fas fa-user"></i> Họ và Tên:</label>
                        <input type="text" id="full-name" name="full_name" placeholder="Nhập họ và tên"
                            value="<?= isset($_SESSION['order']['full_name']) ? $_SESSION['order']['full_name'] : htmlspecialchars($user_info['ho_ten']) ?>" required>

                        <label for="phone"><i class="fas fa-phone"></i> Số điện thoại:</label>
                        <input type="number" id="phone" name="phone" placeholder="Nhập số điện thoại"
                            value="<?= isset($_SESSION['order']['phone']) ? $_SESSION['order']['phone'] : htmlspecialchars($user_info['so_dien_thoai']) ?>" required>

                        <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                        <input type="email" id="email" name="email" placeholder="Nhập email"
                            value="<?= isset($_SESSION['order']['email']) ? $_SESSION['order']['email'] : htmlspecialchars($user_info['email']) ?>" required>

                        <label for="cmd"><i class="fas fa-id-card"></i> CMND/CCCD:</label>
                        <input type="number" id="cmd" name="cmd" placeholder="Nhập CMND/CCCD"
                            value="<?= isset($_SESSION['order']['cmd']) ? $_SESSION['order']['cmd'] : htmlspecialchars($user_info['cccd']) ?>" required>

                        <label for="date"><i class="fas fa-calendar-alt"></i> Ngày nhận xe:</label>
                        <input type="date" id="date" name="date"
                            value="<?= isset($_SESSION['order']['date']) ? $_SESSION['order']['date'] : '' ?>" required onchange="updateInvoice()">

                        <label for="return-date"><i class="fas fa-calendar-alt"></i> Ngày trả xe:</label>
                        <input type="date" id="return-date" name="return_date"
                            value="<?= isset($_SESSION['order']['return_date']) ? $_SESSION['order']['return_date'] : '' ?>" required onchange="updateInvoice()">

                        <label for="time"><i class="fas fa-clock"></i> Thời gian nhận xe:</label>
                        <input type="time" id="time" name="time"
                            value="<?= isset($_SESSION['order']['time']) ? $_SESSION['order']['time'] : '' ?>" required>

                        <label for="note"><i class="fas fa-sticky-note"></i> Ghi chú:</label>
                        <textarea id="note" name="note" placeholder="Nhập ghi chú nếu có"><?= isset($_SESSION['order']['note']) ? htmlspecialchars($_SESSION['order']['note']) : '' ?></textarea>

                        <div class="payment-methods">
                            <h3><i class="fas fa-credit-card"></i> Hình thức thanh toán</h3>

                            <div class="payment-method">
                                <input type="radio" id="pay-on-delivery" name="payment_method" value="cod"
                                    <?= (isset($_SESSION['order']['payment_method']) && $_SESSION['order']['payment_method'] === 'cod') ? 'checked' : '' ?> />
                                <label for="pay-on-delivery">Thanh toán khi nhận xe</label>
                            </div>
                            <div class="payment-method">
                                <input type="radio" id="bank-transfer" name="payment_method" value="bank"
                                    <?= (isset($_SESSION['order']['payment_method']) && $_SESSION['order']['payment_method'] === 'bank') ? 'checked' : '' ?> />
                                <label for="bank-transfer">Thanh toán qua ngân hàng</label>
                            </div>

                        </div>

                        <label for="Discount-code"><i class="fas fa-tag"></i> Mã giảm giá (nếu có):</label>
                        <input type="text" id="discount-code" name="discount_code"
                            placeholder="Nhập mã giảm giá nếu có" value="<?= isset($_SESSION['order']['discount_code']) ? htmlspecialchars($_SESSION['order']['discount_code']) : '' ?>">

                        <button type="button" id="update-btn" onclick="updateInvoice()">
                            <i class="fas fa-sync"></i> Cập nhật thông tin
                        </button>
                        <button type="submit" name="submit_order" id="submit-btn">
                            <i class="fas fa-check-circle"></i> Đặt Xe Ngay
                        </button>
                    </div>

                    <div class="right-section">
                        <h2><i class="fas fa-receipt"></i> Hóa Đơn</h2>
                        <table>
                            <tr>
                                <td>Họ và Tên:</td>
                                <td id="invoice-name"><?= isset($_SESSION['order']['full_name']) ? htmlspecialchars($_SESSION['order']['full_name']) : 'Chưa nhập' ?></td>
                            </tr>
                            <tr>
                                <td>Số điện thoại:</td>
                                <td id="invoice-phone"><?= isset($_SESSION['order']['phone']) ? htmlspecialchars($_SESSION['order']['phone']) : 'Chưa nhập' ?></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td id="invoice-email"><?= isset($_SESSION['order']['email']) ? htmlspecialchars($_SESSION['order']['email']) : 'Chưa nhập' ?></td>
                            </tr>
                            <tr>
                                <td>CMND/CCCD:</td>
                                <td id="invoice-cmd"><?= isset($_SESSION['order']['cmd']) ? htmlspecialchars($_SESSION['order']['cmd']) : 'Chưa nhập' ?></td>
                            </tr>
                            <tr>
                                <td>Ngày nhận xe:</td>
                                <td id="invoice-date"><?= isset($_SESSION['order']['date']) ? $_SESSION['order']['date'] : 'Chưa chọn' ?></td>
                            </tr>
                            <tr>
                                <td>Ngày trả xe:</td>
                                <td id="invoice-return-date"><?= isset($_SESSION['order']['return_date']) ? $_SESSION['order']['return_date'] : 'Chưa chọn' ?></td>
                            </tr>
                            <tr>
                                <td>Thời gian nhận xe:</td>
                                <td id="invoice-time"><?= isset($_SESSION['order']['time']) ? $_SESSION['order']['time'] : 'Chưa chọn' ?></td>
                            </tr>
                            <tr>
                                <td>Ghi chú:</td>
                                <td id="invoice-note"><?= isset($_SESSION['order']['note']) ? htmlspecialchars($_SESSION['order']['note']) : 'Không có' ?></td>
                            </tr>
                            <tr>
                                <td>Hình thức thanh toán:</td>
                                <td id="invoice-payment">
                                    <?php
                                    if (isset($_SESSION['order']['payment_method'])) {
                                        echo $_SESSION['order']['payment_method'] === 'cod' ? 'Thanh toán khi nhận xe' : 'Thanh toán qua ngân hàng';
                                    } else {
                                        echo 'Chưa chọn';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Mã giảm giá</td>
                                <td id="invoice-discount-code"><?= isset($_SESSION['order']['discount_code']) ? htmlspecialchars($_SESSION['order']['discount_code']) : 'Không có' ?></td>
                            </tr>
                            <tr>
                                <td>Tổng số lượng xe:</td>
                                <td id="invoice-quantity">
                                    <?php
                                    $totalQuantity = 0;
                                    foreach ($_SESSION['cart'] as $item) {
                                        $totalQuantity += $item['quantity'];
                                    }
                                    echo $totalQuantity;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Số ngày thuê:</td>
                                <td id="invoice-days">
                                    <?php
                                    $days = 1;
                                    if (isset($_SESSION['order']['date']) && isset($_SESSION['order']['return_date'])) {
                                        $start = strtotime($_SESSION['order']['date']);
                                        $end = strtotime($_SESSION['order']['return_date']);
                                        $days = ($end - $start) / (60*60*24);
                                        if ($days < 1) $days = 1;
                                    }
                                    echo $days;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Tạm tính:</td>
                                <td id="invoice-total"><?= formatCurrency(calculateTotal()) ?></td>
                            </tr>
                            <tr>
                                <td>Tổng cộng:</td>
                                <td id="invoice-grand-total"><strong><?= formatCurrency(calculateTotal()) ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Dịch vụ cho thuê xe máy du lịch. All rights reserved.</p>
        <p>Địa chỉ: 170 An Dương Vương, TP.Quy Nhơn | Điện thoại: 037 660 1589</p>
    </footer>

    <script>
        function updateInvoice() {
            document.getElementById("invoice-name").innerText = document.getElementById("full-name").value || "Chưa nhập";
            document.getElementById("invoice-phone").innerText = document.getElementById("phone").value || "Chưa nhập";
            document.getElementById("invoice-email").innerText = document.getElementById("email").value || "Chưa nhập";
            document.getElementById("invoice-date").innerText = document.getElementById("date").value || "Chưa chọn";
            document.getElementById("invoice-return-date").innerText = document.getElementById("return-date").value || "Chưa chọn";
            document.getElementById("invoice-time").innerText = document.getElementById("time").value || "Chưa chọn";
            document.getElementById("invoice-cmd").innerText = document.getElementById("cmd").value || "Chưa nhập";
            document.getElementById("invoice-note").innerText = document.getElementById("note").value || "Không có";

            const paymentMethods = document.getElementsByName('payment_method');
            let selectedMethod = 'Chưa chọn';
            for (const method of paymentMethods) {
                if (method.checked) {
                    selectedMethod = method.nextElementSibling.textContent;
                    break;
                }
            }
            document.getElementById('invoice-payment').textContent = selectedMethod;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            document.getElementById("invoice-payment").innerText =
                paymentMethod && paymentMethod.value === "cod" ? "Tiền mặt khi nhận xe" : paymentMethod && paymentMethod.value === "bank" ? "Chuyển khoản ngân hàng" : "Chưa chọn";

            // Tính số ngày thuê
            let days = 1;
            const start = document.getElementById("date").value;
            const end = document.getElementById("return-date").value;
            if (start && end) {
                const startDate = new Date(start);
                const endDate = new Date(end);  
                const diff = (endDate - startDate) / (1000*60*60*24);
                days = diff >= 1 ? diff : 1;
            }
            document.getElementById("invoice-days").innerText = days;
            // Tính lại tạm tính từng xe và tổng tiền
            let total = 0;
            document.querySelectorAll('input[name^="qty["]').forEach(function(input) {
                const row = input.closest('tr');
                const priceText = row.querySelector('td:nth-child(4)').innerText;
                const price = parseInt(priceText.replace(/\D/g, ''));
                const qty = parseInt(input.value) || 0;
                const itemTotal = price * qty * days;
                row.querySelector('.item-total').innerText = itemTotal.toLocaleString('vi-VN') + 'đ';
                total += itemTotal;
            });
            document.getElementById("invoice-total").innerText = total.toLocaleString('vi-VN') + 'đ';
            document.getElementById("invoice-grand-total").innerText = total.toLocaleString('vi-VN') + 'đ';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById("date").min = today;

            <?php if (isset($_SESSION['message'])): ?>
                window.scrollTo(0, document.querySelector('.message').offsetTop - 20);
            <?php endif; ?>
        });
    </script>
</body>
<?php

if (isset($_GET['success'])) {
    unset($_SESSION['order']);
}
?>

</html>