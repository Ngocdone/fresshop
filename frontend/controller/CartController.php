<?php
session_start();
require_once __DIR__ . '/../model/database.php';

class CartController {
    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                // Return JSON response for AJAX requests
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục']);
                    exit;
                }
                header('Location: ?page=login');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'] ?? null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if (!$productId || $quantity < 1) {
                header('Location: ?page=product');
                exit;
            }

            $db = Database::getInstance();
            $conn = $db->getConnection();

            // Debug: ghi log để kiểm tra dữ liệu nhận được
            error_log("User ID: $userId, Product ID: $productId, Quantity: $quantity");

            // Kiểm tra đơn hàng chưa thanh toán của user
            $sqlOrder = "SELECT * FROM donhang WHERE MaKhachHang = :user_id AND TrangThaiThanhToan = 0 LIMIT 1";
            $stmtOrder = $conn->prepare($sqlOrder);
            $stmtOrder->execute(['user_id' => $userId]);
            $order = $stmtOrder->fetch();

            if (!$order) {
                // Tạo đơn hàng mới
                $sqlInsertOrder = "INSERT INTO donhang (MaKhachHang, TrangThaiThanhToan) VALUES (:user_id, 0)";
                $stmtInsertOrder = $conn->prepare($sqlInsertOrder);
                $stmtInsertOrder->execute(['user_id' => $userId]);
                $orderId = $conn->lastInsertId();
                error_log("Created new order with ID: $orderId");
            } else {
                $orderId = $order['id'];
                error_log("Existing order ID: $orderId");
            }

            // Kiểm tra sản phẩm đã có trong chi tiết đơn hàng chưa
            $sqlCheckDetail = "SELECT * FROM chitietdonhang WHERE MaDonHang = :order_id AND MaSanPham = :product_id";
            $stmtCheckDetail = $conn->prepare($sqlCheckDetail);
            $stmtCheckDetail->execute(['order_id' => $orderId, 'product_id' => $productId]);
            $detail = $stmtCheckDetail->fetch();

            if ($detail) {
                // Cập nhật số lượng
                $newQuantity = $detail['SoLuong'] + $quantity;
                $sqlUpdateDetail = "UPDATE chitietdonhang SET SoLuong = :quantity WHERE id = :id";
                $stmtUpdateDetail = $conn->prepare($sqlUpdateDetail);
                $stmtUpdateDetail->execute(['quantity' => $newQuantity, 'id' => $detail['id']]);error_log("Updated quantity to $newQuantity for detail ID: " . $detail['id']);
            } else {
                // Thêm mới chi tiết đơn hàng
                $sqlInsertDetail = "INSERT INTO chitietdonhang (MaDonHang, MaSanPham, SoLuong) VALUES (:order_id, :product_id, :quantity)";
                $stmtInsertDetail = $conn->prepare($sqlInsertDetail);
                $stmtInsertDetail->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]);
                error_log("Inserted new detail for order ID: $orderId, product ID: $productId");
            }
            
            echo "<script>
    alert('Thêm sản phẩm vào giỏ hàng thành công!');
    window.location.href='?page=cart';
</script>";
            flush();
            exit;
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: ?page=login');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'] ?? null;

            if (!$productId) {
            echo "<script>
    alert('Xóa sản phẩm trong giỏ hàng thành công!');
    window.location.href='?page=cart';
</script>";
                exit;
            }

            $db = Database::getInstance();
            $conn = $db->getConnection();

            // Lấy đơn hàng chưa thanh toán của user
            $sqlOrder = "SELECT * FROM donhang WHERE MaKhachHang = :user_id AND TrangThaiThanhToan = 0 LIMIT 1";
            $stmtOrder = $conn->prepare($sqlOrder);
            $stmtOrder->execute(['user_id' => $userId]);
            $order = $stmtOrder->fetch();

            if ($order) {
                $orderId = $order['id'];
                
                // Xóa sản phẩm khỏi chi tiết đơn hàng
                $sqlDelete = "DELETE FROM chitietdonhang WHERE MaDonHang = :order_id AND MaSanPham = :product_id";
                $stmtDelete = $conn->prepare($sqlDelete);
                $stmtDelete->execute(['order_id' => $orderId, 'product_id' => $productId]);
                
                // Kiểm tra xem còn sản phẩm nào trong đơn hàng không
                $sqlCheckEmpty = "SELECT COUNT(*) as count FROM chitietdonhang WHERE MaDonHang = :order_id";
                $stmtCheckEmpty = $conn->prepare($sqlCheckEmpty);
                $stmtCheckEmpty->execute(['order_id' => $orderId]);
                $result = $stmtCheckEmpty->fetch();
                
                // Nếu không còn sản phẩm nào, có thể xóa đơn hàng (tùy chọn)
                if ($result['count'] == 0) {
                    $sqlDeleteOrder = "DELETE FROM donhang WHERE id = :order_id";
                    $stmtDeleteOrder = $conn->prepare($sqlDeleteOrder);
                    $stmtDeleteOrder->execute(['order_id' => $orderId]);
                }
            }

            echo "<script>
    alert('Xóa sản phẩm trong giỏ hàng thành công!');
    window.location.href='?page=cart';
</script>";
            exit;
        }
    }

    public function updateCartQuantity() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
                exit;
            }

            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'] ?? null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if (!$productId || $quantity < 1) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit;
            }

            $db = Database::getInstance();
            $conn = $db->getConnection();

            // Lấy đơn hàng chưa thanh toán của user
            $sqlOrder = "SELECT * FROM donhang WHERE MaKhachHang = :user_id AND TrangThaiThanhToan = 0 LIMIT 1";
            $stmtOrder = $conn->prepare($sqlOrder);
            $stmtOrder->execute(['user_id' => $userId]);
            $order = $stmtOrder->fetch();

            if ($order) {
                $orderId = $order['id'];

                // Cập nhật số lượng trong chi tiết đơn hàng
                $sqlUpdate = "UPDATE chitietdonhang SET SoLuong = :quantity 
                             WHERE MaDonHang = :order_id AND MaSanPham = :product_id";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    'quantity' => $quantity,
                    'order_id' => $orderId,
                    'product_id' => $productId
                ]);

                // Tính lại tổng tiền và giá cho từng sản phẩm
                $sqlItemTotal = "SELECT sanpham.GiaGoc as price, chitietdonhang.SoLuong as quantity
                               FROM chitietdonhang 
                               JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id 
                               WHERE chitietdonhang.MaDonHang = :order_id AND chitietdonhang.MaSanPham = :product_id";
                $stmtItem = $conn->prepare($sqlItemTotal);
                $stmtItem->execute(['order_id' => $orderId, 'product_id' => $productId]);
                $itemData = $stmtItem->fetch();
                
                $itemPrice = $itemData['price'] ?? 0;
                $itemTotal = $itemPrice * $quantity;

                $sqlTotal = "SELECT SUM(sanpham.GiaGoc * chitietdonhang.SoLuong) as total
                            FROM chitietdonhang 
                            JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id 
                            WHERE chitietdonhang.MaDonHang = :order_id";
                $stmtTotal = $conn->prepare($sqlTotal);
                $stmtTotal->execute(['order_id' => $orderId]);
                $result = $stmtTotal->fetch();
                $total = $result['total'] ?? 0;

                echo json_encode([
                    'success' => true, 
                    'cartTotal' => $total,
                    'itemTotal' => $itemTotal,
                    'itemPrice' => $itemPrice]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
            }
            exit;
        }
    }
}
?>