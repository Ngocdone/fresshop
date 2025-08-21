<div class="container py-5 text-center checkout-container">
    <h2>🎉 Đặt hàng thành công!</h2>
    <p>Cảm ơn bạn đã mua sắm tại website của chúng tôi.</p>
    <p>Mã đơn hàng của bạn là: 
        <strong>#<?= htmlspecialchars($orderId ?? 'N/A') ?></strong>
    </p>
    <a href="index.php" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
</div>
