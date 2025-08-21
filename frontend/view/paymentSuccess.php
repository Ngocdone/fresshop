<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// Kiểm tra xem có dữ liệu đơn hàng không
if (!isset($_SESSION['order_details'])) {
    echo '<script>window.location.href="?page=home";</script>';
    exit;
}

$order = $_SESSION['order_details'];
?>
    <style>
        .success-animation {
            animation: scaleIn 0.5s ease-in-out;
        }
        
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .order-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .product-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            transition: transform 0.3s;
        }
        
        .product-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
        
        .tracking-step {
            position: relative;
            padding: 20px 0;
        }
        
        .tracking-step::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e0e0e0;
        }
        
        .tracking-step.active::before {
            background: #667eea;
        }
        
        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .tracking-step.active .step-icon {
            background: #667eea;
            color: white;
        }
    </style>
    <!-- Payment Success Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Animation -->
                    <div class="text-center mb-5">
                        <div class="success-animation">
                            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                        </div>
                        <h1 class="mt-4 text-success">Thanh toán thành công!</h1>
                        <p class="lead">Đơn hàng của bạn đã được xác nhận và đang được xử lý</p>
                    </div>

                    <!-- Order Summary Card -->
                    <div class="order-card">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><i class="fas fa-receipt me-2"></i>Mã đơn hàng</h5>
                                <h3>#<?= $order['order_id'] ?? 'DH' . date('YmdHis') ?></h3>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h5><i class="fas fa-calendar me-2"></i>Ngày đặt</h5>
                                <h3><?= date('d/m/Y H:i') ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Thông tin khách hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Họ tên:</strong> <?= $order['customer_name'] ?? '' ?></p>
                                    <p><strong>Email:</strong> <?= $order['customer_email'] ?? '' ?></p>
                                    <p><strong>Điện thoại:</strong> <?= $order['customer_phone'] ?? '' ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Địa chỉ:</strong> <?= $order['customer_address'] ?? '' ?></p>
                                    <p><strong>Phương thức thanh toán:</strong> 
                                        <span class="badge bg-success">
                                            <?= $order['payment_method'] == 'vnpay' ? 'VNPay' : 'COD' ?>
                                        </span>
                                    </p>
                                    <p><strong>Trạng thái:</strong> 
                                        <span class="badge bg-primary">Đã thanh toán</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Chi tiết đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="product-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <img src="<?= $item['image'] ?? 'Public/img/default.jpg' ?>" 
                                             alt="<?= $item['name'] ?>" 
                                             style="width: 60px; height: 60px; object-fit: cover;" 
                                             class="rounded me-3">
                                        <span><?= $item['name'] ?></span>
                                    </div>
                                    <div class="text-end">
                                        <div><?= number_format($item['price']) ?>đ × <?= $item['quantity'] ?></div>
                                        <strong><?= number_format($item['price'] * $item['quantity']) ?>đ</strong>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <hr>
                            <div class="text-end">
                                <h5>Tổng tiền: <strong class="text-primary"><?= number_format($order['total_amount'] ?? 0) ?>đ</strong></h5>
                            </div>
                        </div>
                    </div>

                    <!-- Order Tracking -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Theo dõi đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="tracking-step active">
                                <div class="d-flex align-items-center">
                                    <div class="step-icon me-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Đặt hàng thành công</h6>
                                        <small class="text-muted">Đơn hàng đã được xác nhận</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tracking-step">
                                <div class="d-flex align-items-center">
                                    <div class="step-icon me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Đang xử lý</h6>
                                        <small class="text-muted">Đơn hàng đang được chuẩn bị</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tracking-step">
                                <div class="d-flex align-items-center">
                                    <div class="step-icon me-3">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Đang giao hàng</h6>
                                        <small class="text-muted">Đơn hàng đang trên đường đến bạn</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tracking-step">
                                <div class="d-flex align-items-center">
                                    <div class="step-icon me-3">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Đã giao hàng</h6>
                                        <small class="text-muted">Đơn hàng đã được giao thành công</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        <a href="?page=home" class="btn btn-custom me-3">
                            <i class="fas fa-shopping-bag me-2"></i>Tiếp tục mua sắm
                        </a>
                        <a href="?page=order_detail&id=<?= $order['order_id'] ?? '' ?>" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>Xem chi tiết đơn hàng
                        </a>
                    </div>

                    <!-- Email Confirmation Notice -->
                    <div class="alert alert-info mt-4" role="alert">
                        <i class="fas fa-envelope me-2"></i>
                        Một email xác nhận đã được gửi đến <?= $order['customer_email'] ?? '' ?>. Vui lòng kiểm tra hộp thư của bạn.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Clear session after display -->
    <script>
        // Xóa session sau khi hiển thị
        setTimeout(() => {
            <?php unset($_SESSION['order_details']); ?>
        }, 5000);
    </script>
