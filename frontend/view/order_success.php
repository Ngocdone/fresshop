<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Order Success Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-check-circle display-1 text-primary"></i>
                <h1 class="display-5">Đặt hàng thành công!</h1>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?= $_SESSION['success'] ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <p class="mb-4">Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi!</p>
                <p class="mb-4">Mã đơn hàng của bạn: <strong>#<?= $_SESSION['vnpay_order_id'] ?? '' ?></strong></p>
                
                <div class="d-flex justify-content-center">
                    <a href="?page=home" class="btn border-secondary rounded-pill px-4 py-3 text-primary me-3">
                        Tiếp tục mua sắm
                    </a>
                    <a href="?page=order_history" class="btn border-secondary rounded-pill px-4 py-3 text-primary">
                        Xem lịch sử đơn hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order Success Page End -->
