<?php
require_once __DIR__ . '/../../frontend/model/database.php';

class OrderController {

    public function index() {
        $db   = Database::getInstance();       // dùng Singleton
        $conn = $db->getConnection();          // lấy PDO connection

        $sql = "SELECT dh.id, kh.TenKhachHang, kh.Email, kh.SDT, dh.TrangThaiThanhToan, dh.Ghichu
                FROM donhang dh
                JOIN khachhang kh ON dh.MaKhachHang = kh.id
                ORDER BY dh.id DESC";

        $stmt   = $conn->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "view/order.php";
    }

    public function detail($id) {
        $db   = Database::getInstance();
        $conn = $db->getConnection();

        // Thông tin đơn hàng
        $sql = "SELECT dh.id, kh.TenKhachHang, kh.Email, kh.SDT, kh.DiaChi, 
                       dh.TrangThaiThanhToan, dh.Ghichu
                FROM donhang dh
                JOIN khachhang kh ON dh.MaKhachHang = kh.id
                WHERE dh.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Chi tiết sản phẩm
        $sql2 = "SELECT ct.SoLuong, sp.GiaGoc AS Gia, sp.TenSanPham, sp.HinhAnh
         FROM chitietdonhang ct
         JOIN sanpham sp ON ct.MaSanPham = sp.id
         WHERE ct.MaDonHang = :id";



        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([':id' => $id]);
        $order_items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        include "view/order_detail.php";
    }
    public function completeOrder($orderId) {
    $db   = Database::getInstance();
    $conn = $db->getConnection();

    // Xóa chi tiết đơn hàng trước
    $sql1 = "DELETE FROM chitietdonhang WHERE MaDonHang = :order_id";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([':order_id' => $orderId]);

    // Xóa đơn hàng
    $sql2 = "DELETE FROM donhang WHERE id = :order_id";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([':order_id' => $orderId]);
}
}
