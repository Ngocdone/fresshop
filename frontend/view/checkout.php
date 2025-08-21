<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ?page=login');
    exit;
}

$userId = $_SESSION['user_id'];
$db = Database::getInstance();
$conn = $db->getConnection();

// Lấy đơn hàng chưa thanh toán
$sqlOrder = "SELECT * FROM donhang WHERE MaKhachHang = :user_id AND TrangThaiThanhToan = 0 LIMIT 1";
$stmtOrder = $conn->prepare($sqlOrder);
$stmtOrder->execute(['user_id' => $userId]);
$order = $stmtOrder->fetch();

$cartItems = [];
$total = 0;

if ($order) {
    $orderId = $order['id'];
    
    // Lấy chi tiết đơn hàng
    $sqlDetails = "SELECT chitietdonhang.*, sanpham.TenSanPham, sanpham.GiaGoc, sanpham.HinhAnh 
                   FROM chitietdonhang 
                   JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id 
                   WHERE chitietdonhang.MaDonHang = :order_id";
    $stmtDetails = $conn->prepare($sqlDetails);
    $stmtDetails->execute(['order_id' => $orderId]);
    $cartItems = $stmtDetails->fetchAll();

    foreach ($cartItems as $item) {
        $total += $item['GiaGoc'] * $item['SoLuong'];
    }
}

if ($total <= 0) {
    header('Location: ?page=cart');
    exit;
}
?>

<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Thanh toán đơn hàng</h1>
        <div class="row g-5">
            <div class="col-md-12 col-lg-6 col-xl-7">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item) { ?>
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="../public/img/<?= htmlspecialchars($item['HinhAnh']) ?>" 
                                             class="img-fluid me-5 rounded-circle" 
                                             style="width: 80px; height: 80px;" 
                                             alt="<?= htmlspecialchars($item['TenSanPham']) ?>">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4"><?= htmlspecialchars($item['TenSanPham']) ?></p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><?= number_format($item['GiaGoc'], 0, ',', '.') ?> ₫</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><?= $item['SoLuong'] ?></p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4"><?= number_format($item['GiaGoc'] * $item['SoLuong'], 0, ',', '.') ?> ₫</p>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xl-5">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Tổng đơn hàng</h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Tổng tiền:</h5>
                            <p class="mb-0"><?= number_format($total, 0, ',', '.') ?> ₫</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Phí vận chuyển:</h5>
                            <div class="">
                                <p class="mb-0">0 ₫</p>
                            </div>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Tổng cộng</h5>
                        <p class="mb-0 pe-4"><?= number_format($total, 0, ',', '.') ?> ₫</p>
                    </div>  
                        <button type="submit" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4">
                            Thanh toán 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout Page End -->
