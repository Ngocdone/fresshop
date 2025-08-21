<!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Cart</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Cart</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


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

// Lấy đơn hàng chưa thanh toán của user
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
?>

<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead><tr>
                    <th scope="col">Products</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cartItems)) {
                        foreach ($cartItems as $item) { ?>
                    <tr>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="../public/img/<?= htmlspecialchars($item['HinhAnh']) ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="<?= htmlspecialchars($item['TenSanPham']) ?>">
                            </div>
                        </th>
                        <td>
                            <p class="mb-0 mt-4"><?= htmlspecialchars($item['TenSanPham']) ?></p>
                        </td>
                        <td>
                            <p class="mb-0 mt-4"><?= number_format($item['GiaGoc'], 0, ',', '.') ?> ₫</p>
                        </td>
                        <td>
                            <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-product-id="<?= $item['MaSanPham'] ?>">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center border-0 quantity-input" 
                                       value="<?= $item['SoLuong'] ?>" 
                                       data-product-id="<?= $item['MaSanPham'] ?>" 
                                       min="1">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-product-id="<?= $item['MaSanPham'] ?>">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="mb-0 mt-4"><?= number_format($item['GiaGoc'] * $item['SoLuong'], 0, ',', '.') ?> ₫</p>
                        </td>
                        <td>
                            <form method="POST" action="?page=removeFromCart" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?= $item['MaSanPham'] ?>"><button type="submit" class="btn btn-md rounded-circle bg-light border mt-4" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                    <i class="fa fa-times text-danger"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php } } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">Giỏ hàng trống</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Nhập mã giảm giá">
            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Gửi mã giảm giá</button>
        </div>
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
        <div class="bg-light rounded">
            <div class="p-4">
                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                
                <!-- Subtotal -->
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="mb-0 me-4">Subtotal:</h5>
                    <p class="mb-0"><?= number_format($total, 0, ',', '.') ?> ₫</p>
                </div>

                <!-- Shipping -->
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="mb-0 me-4">Shipping</h5>
                    <p class="mb-0">Flat rate: 0 ₫</p>
                </div>
                <p class="mb-3 text-end">Shipping to Vietnam.</p>

                <!-- Ghi chú đơn hàng -->
                <div class="mb-3">
                    <h5>Ghi chú đơn hàng:</h5>
                    <p><?= htmlspecialchars($order['Ghichu'] ?? 'Không có ghi chú') ?></p>
                </div>
            </div>

            <!-- Tổng tiền -->
            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                <h5 class="mb-0 ps-4 me-4">Total</h5>
                <p class="mb-0 pe-4"><?= number_format($total, 0, ',', '.') ?> ₫</p>
            </div>

            <!-- Form thanh toán -->
            <form method="post" action="index.php?page=checkoutform" class="p-4">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                
                <div class="mb-3">
                    <label for="ghichu" class="form-label">Cập nhật ghi chú (nếu cần):</label>
                    <textarea name="ghichu" id="ghichu" class="form-control" rows="3"><?= htmlspecialchars($order['Ghichu'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Thanh toán</button>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->

<script src="../assets/js/cart.js"></script>