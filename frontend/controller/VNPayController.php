               <?php
session_start();
require_once __DIR__ . '/../config/vnpay_config.php';
require_once __DIR__ . '/../model/database.php';

class VNPayController {
    
    public function createPayment() {
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

        error_log("Order Info: " . print_r($order, true)); // Log thông tin đơn hàng
        if (!$order) {
            $_SESSION['error'] = 'Không tìm thấy đơn hàng cần thanh toán';
            header('Location: ?page=car');
            exit;
        }

        // Tính tổng tiền
        $sqlTotal = "SELECT SUM(sanpham.GiaGoc * chitietdonhang.SoLuong) as total
                    FROM chitietdonhang 
                    JOIN sanpham ON chitietdonhang.MaSanPham = sanpham.id 
                    WHERE chitietdonhang.MaDonHang = :order_id";
        $stmtTotal = $conn->prepare($sqlTotal);
        $stmtTotal->execute(['order_id' => $order['id']]);
        $result = $stmtTotal->fetch();
        $total = $result['total'] ?? 0;

        if ($total <= 0) {
            $_SESSION['error'] = 'Giỏ hàng trống';
            header('Location: ?page=car');
            exit;
        }

        // Cấu hình VNPAY
        $config = include __DIR__ . '/../config/vnpay_config.php';
        
        $vnp_TmnCode = $config['vnp_TmnCode'];
        $vnp_HashSecret = $config['vnp_HashSecret'];
        $vnp_Url = $config['vnp_Url'];
        $vnp_ReturnUrl = $config['vnp_ReturnUrl'];
        
        $vnp_TxnRef = $order['id'] . '_' . time(); // Mã giao dịch duy nhất
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order['id'];
        $vnp_OrderType = $config['vnp_OrderType'];
        $vnp_Amount = $total * 100; // VNPAY yêu cầu nhân 100
        $vnp_Locale = $config['vnp_Locale'];
        $vnp_BankCode = $_POST['bank_code'] ?? '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        
        // Lưu thông tin vào session
        $_SESSION['vnpay_order_id'] = $order['id'];
        $_SESSION['vnpay_txn_ref'] = $vnp_TxnRef;
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        error_log("VNPAY URL: " . $vnp_Url); // Log URL để kiểm tra
        error_log("Order Info: " . print_r($order, true)); // Log thông tin đơn hàng
        error_log("VNPAY URL: " . $vnp_Url); // Log URL để kiểm tra
        error_log("Order Info: " . print_r($order, true)); // Log thông tin đơn hàng
        header('Location: ' . $vnp_Url);
        exit;
    }

    public function handleReturn() {
        $config = include __DIR__ . '/../config/vnpay_config.php';
        $vnp_HashSecret = $config['vnp_HashSecret'];
        
        $inputData = array();
        $returnData = array();
        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        error_log("Return Data: " . print_r($_GET, true)); // Ghi log thông tin trả về
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $orderId = $_SESSION['vnpay_order_id'] ?? null;
                
                if ($orderId) {
                    // Cập nhật trạng thái đơn hàng
                    $sqlUpdate = "UPDATE donhang SET TrangThaiThanhToan = 1, 
                                 NgayThanhToan = NOW(), 
                                 PhuongThucThanhToan = 'VNPAY',
                                 MaGiaoDich = :transaction_id
                                 WHERE id = :order_id";
                    $stmtUpdate = $conn->prepare($sqlUpdate);
                    $stmtUpdate->execute([
                        'transaction_id' => $_GET['vnp_TransactionNo'],
                        'order_id' => $orderId
                    ]);
                    
                    // Lưu lịch sử giao dịch
                    $sqlInsert = "INSERT INTO payment_history (order_id, transaction_id, amount, status, payment_method, created_at) 
                                 VALUES (:order_id, :transaction_id, :amount, 'success', 'VNPAY', NOW())";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->execute([
                        'order_id' => $orderId,
                        'transaction_id' => $_GET['vnp_TransactionNo'],
                        'amount' => $_GET['vnp_Amount'] / 100
                    ]);
                    
                    $_SESSION['success'] = 'Thanh toán thành công! Cảm ơn bạn đã mua hàng.';
                }
            } else {
                $_SESSION['error'] = 'Thanh toán thất bại. Vui lòng thử lại.';
            }
        } else {
            $_SESSION['error'] = 'Chữ ký không hợp lệ';
        }
        
        header('Location: ?page=order_success');
        exit;
    }
}
?>
