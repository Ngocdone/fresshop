<?php
class PaymentSuccessController {
    
    public function showSuccessPage() {
        // Kiểm tra xem có dữ liệu đơn hàng không
        if (!isset($_SESSION['order_details'])) {
            echo "Không có thông tin đơn hàng."; // Thông báo tạm thời
            header('Location: ?page=home');
            exit;
        }
        
        // Lấy thông tin đơn hàng từ session
        $order = $_SESSION['order_details'];
        
        // Gửi email xác nhận
        $this->sendOrderConfirmationEmail($order);
        
        // Hiển thị trang thành công
        require_once __DIR__ . '/../view/paymentSuccess.php';
        echo "hello";
    }
    
    private function sendOrderConfirmationEmail($order) {
        $to = $order['customer_email'];
        $subject = 'Xác nhận đơn hàng #' . $order['order_id'];
        
        $message = '
        <html>
        <head>
            <title>Xác nhận đơn hàng</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .header { background-color: #667eea; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                .order-details { background-color: #f8f9fa; padding: 15px; margin: 10px 0; }
                .footer { background-color: #f8f9fa; padding: 10px; text-align: center; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>Cảm ơn bạn đã đặt hàng!</h1>
            </div>
            
            <div class="content">
                <h2>Thông tin đơn hàng #' . $order['order_id'] . '</h2>
                
                <div class="order-details">
                    <h3>Thông tin khách hàng:</h3>
                    <p><strong>Họ tên:</strong> ' . $order['customer_name'] . '</p>
                    <p><strong>Email:</strong> ' . $order['customer_email'] . '</p>
                    <p><strong>Điện thoại:</strong> ' . $order['customer_phone'] . '</p>
                    <p><strong>Địa chỉ:</strong> ' . $order['customer_address'] . '</p>
                </div>
                
                <div class="order-details">
                    <h3>Chi tiết đơn hàng:</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #667eea; color: white;">
                                <th style="padding: 10px; text-align: left;">Sản phẩm</th>
                                <th style="padding: 10px; text-align: right;">Số lượng</th>
                                <th style="padding: 10px; text-align: right;">Đơn giá</th>
                                <th style="padding: 10px; text-align: right;">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        foreach ($order['items'] as $item) {
            $message .= '
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . $item['name'] . '</td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">' . $item['quantity'] . '</td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">' . number_format($item['price']) . 'đ</td>
                                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">' . number_format($item['price'] * $item['quantity']) . 'đ</td>
                            </tr>';
        }
        
        $message .= '
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="padding: 10px; text-align: right;"><strong>Tổng tiền:</strong></td>
                                <td style="padding: 10px; text-align: right;"><strong>' . number_format($order['total_amount']) . 'đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận và giao hàng.</p>
            </div>
            
            <div class="footer">
                <p>Trân trọng,<br>Đội ngũ cửa hàng rau củ</p>
            </div>
        </body>
        </html>';
        
        // Headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: Cửa hàng rau củ <no-reply@yourstore.com>' . "\r\n";
        
        // Gửi email
        mail($to, $subject, $message, $headers);
    }
    
    private function getOrderById($order_id) {
        // Kết nối database và lấy thông tin đơn hàng
        global $conn;
        
        $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($order) {
            // Lấy chi tiết sản phẩm
            $stmt = $conn->prepare("SELECT od.*, p.name, p.image 
                                   FROM order_details od 
                                   JOIN products p ON od.product_id = p.id 
                                   WHERE od.order_id = ?");
            $stmt->execute([$order_id]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'order_id' => $order['id'],
                'customer_name' => $order['customer_name'],
                'customer_email' => $order['customer_email'],
                'customer_phone' => $order['customer_phone'],
                'customer_address' => $order['customer_address'],
                'total_amount' => $order['total_amount'],
                'payment_method' => $order['payment_method'],
                'items' => $items
            ];
        }
        
        return null;
    }
}
?>
