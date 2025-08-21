<?php
require_once __DIR__ . '/../model/database.php';

class OrderController {
    private $conn;
    private $userId;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->conn = Database::getInstance()->getConnection();
        $this->userId = $_SESSION['user_id'] ?? null;
    }

    // Hiển thị giỏ hàng
    public function index() {
        if (!$this->userId) {
            header('Location: index.php?page=login');
            exit;
        }

        $sqlOrder = "SELECT * FROM donhang WHERE MaKhachHang = :user_id AND TrangThaiThanhToan = 0 LIMIT 1";
        $stmtOrder = $this->conn->prepare($sqlOrder);
        $stmtOrder->execute(['user_id' => $this->userId]);
        $order = $stmtOrder->fetch();

        $cartItems = [];
        $total = 0;

        if ($order) {
            $orderId = $order['id'];
            $sqlDetails = "SELECT chitietdonhang.*, sanpham.TenSanPham, sanpham.GiaGoc, sanpham.HinhAnh
                           FROM chitietdonhang
                           JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id
                           WHERE chitietdonhang.MaDonHang = :order_id";
            $stmtDetails = $this->conn->prepare($sqlDetails);
            $stmtDetails->execute(['order_id' => $orderId]);
            $cartItems = $stmtDetails->fetchAll();

            foreach ($cartItems as $item) {
                $total += $item['GiaGoc'] * $item['SoLuong'];
            }
        }

        include __DIR__ . '/../view/cart.php';
    }

    // Xử lý thanh toán
public function checkout() {
    if (!$this->userId) {
        if (headers_sent($file, $line)) {
            die("Headers already sent in $file on line $line");
        }
        header("Location: index.php?page=login");
        exit;
    }

    // giả sử đơn hàng cuối cùng trong giỏ là đơn cần thanh toán
    $orderId = $_POST['order_id'] ?? 0;

    if ($orderId > 0) {
        // cập nhật trạng thái thanh toán
        $sql = "UPDATE donhang SET TrangThaiThanhToan = 1 WHERE id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);

        // chuyển sang trang cảm ơn
        if (headers_sent($file, $line)) {
            die("Headers already sent in $file on line $line");
        }
        header("Location: index.php?page=orderSuccess&order_id=".$orderId);
        exit;
    } else {
        // nếu không có order_id thì chuyển thẳng sang success
        if (headers_sent($file, $line)) {
            die("Headers already sent in $file on line $line");
        }
        header("Location: index.php?page=orderSuccess");
        exit;
    }
}





    // Trang cảm ơn (không cần login)
    public function orderSuccess() {
        $orderId = $_GET['order_id'] ?? 0;
        include __DIR__ . '/../view/order_success.php';
    }
}
