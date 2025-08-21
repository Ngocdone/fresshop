<?php
session_start();
require_once __DIR__ . '/../model/database.php';

$db = Database::getInstance();
$conn = $db->getConnection();

// Lấy thông tin đơn hàng
$userId = $_SESSION['user_id'] ?? null;
if ($userId) {
    $sql = "SELECT * FROM donhang WHERE MaKhachHang = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $orders = $stmt->fetchAll();
} else {
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn Hàng</title>
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    <h1>Danh Sách Đơn Hàng</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Trạng Thái</th>
            <th>Ngày Tạo</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars($order['TrangThaiThanhToan'] ? 'Đã thanh toán' : 'Chưa thanh toán') ?></td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
