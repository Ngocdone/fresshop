<?php
require_once "../frontend/model/database.php";

class StatisticsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Lấy chi tiết đơn hàng
    public function getDailyRevenue() {
        try {
            $sql = "SELECT 
                        CURRENT_DATE() as ngay,
                        COUNT(DISTINCT dh.id) as so_don_hang,
                        SUM(CASE 
                            WHEN sp.GiaKhuyenMai > 0 AND sp.GiaKhuyenMai IS NOT NULL THEN ct.SoLuong * sp.GiaKhuyenMai
                            ELSE ct.SoLuong * sp.GiaGoc 
                        END) as doanh_thu
                    FROM donhang dh
                    JOIN chitietdonhang ct ON dh.id = ct.MaDonHang
                    JOIN sanpham sp ON ct.MaSanPham = sp.id
                    WHERE dh.TrangThaiThanhToan = 1
                    AND DATE(CURRENT_TIMESTAMP) = DATE(CURRENT_TIMESTAMP)";
            error_log("Daily Revenue SQL: " . $sql);
            $result = $this->db->getAll($sql);
            error_log("Daily Revenue Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Daily Revenue Error: " . $e->getMessage());
            throw $e;
        }
    }

    // Thống kê theo sản phẩm
    public function getTopSellingProducts() {
        try {
            $sql = "SELECT 
                        sp.id,
                        sp.TenSanPham as name,
                        sp.HinhAnh as image,
                        COALESCE(SUM(ct.SoLuong), 0) as total_sold,
                        COALESCE(SUM(ct.SoLuong * ct.Gia), 0) as total_revenue
                    FROM sanpham sp
                    LEFT JOIN chitietdonhang ct ON sp.id = ct.MaSanPham
                    LEFT JOIN donhang dh ON ct.MaDonHang = dh.id 
                    WHERE dh.TrangThaiThanhToan = 1
                    GROUP BY sp.id, sp.TenSanPham, sp.HinhAnh
                    ORDER BY total_sold DESC
                    LIMIT 10";
            error_log("Top Products SQL: " . $sql);
            $result = $this->db->getAll($sql);
            error_log("Top Products Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Top Products Error: " . $e->getMessage());
            throw $e;
        }
    }

    // Thống kê theo khách hàng
    public function getTopCustomers() {
        try {
            $sql = "SELECT 
                        kh.id,
                        kh.TenKhachHang,
                        kh.Email,
                        COUNT(DISTINCT dh.id) as so_don_hang,
                        COALESCE(SUM(CASE 
                            WHEN sp.GiaKhuyenMai > 0 AND sp.GiaKhuyenMai IS NOT NULL THEN ct.SoLuong * sp.GiaKhuyenMai
                            ELSE ct.SoLuong * sp.GiaGoc 
                        END), 0) as tong_tien_mua
                    FROM khachhang kh
                    LEFT JOIN donhang dh ON kh.id = dh.MaKhachHang AND dh.TrangThaiThanhToan = 1
                    LEFT JOIN chitietdonhang ct ON dh.id = ct.MaDonHang
                    LEFT JOIN sanpham sp ON ct.MaSanPham = sp.id
                    WHERE kh.TrangThai = 1
                    GROUP BY kh.id, kh.TenKhachHang, kh.Email
                    HAVING so_don_hang > 0
                    ORDER BY tong_tien_mua DESC
                    LIMIT 10";
            error_log("Top Customers SQL: " . $sql);
            $result = $this->db->getAll($sql);
            error_log("Top Customers Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Top Customers Error: " . $e->getMessage());
            throw $e;
        }
    }

    // Thống kê tổng hợp
    public function getTotalStats() {
        try {
            $sql = "SELECT
                        (SELECT COUNT(DISTINCT id) FROM donhang WHERE TrangThaiThanhToan = 1) as tong_don_hang,
                        (SELECT COUNT(DISTINCT MaKhachHang) FROM donhang WHERE TrangThaiThanhToan = 1) as tong_khach_mua,
                        COALESCE((
                            SELECT SUM(
                                ct.SoLuong * ct.Gia
                            )
                            FROM chitietdonhang ct 
                            JOIN donhang dh ON ct.MaDonHang = dh.id
                            JOIN sanpham sp ON ct.MaSanPham = sp.id
                            WHERE dh.TrangThaiThanhToan = 1
                        ), 0) as tong_doanh_thu";
            error_log("Total Stats SQL: " . $sql);
            $result = $this->db->getOne($sql);
            error_log("Total Stats Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Total Stats Error: " . $e->getMessage());
            throw $e;
        }
    }

    // Doanh thu theo tuần
    public function getWeeklyRevenue() {
        try {
            $sql = "SELECT 
                    'Tuần này' as ngay,
                    COUNT(DISTINCT dh.id) as so_don_hang,
                    COALESCE(SUM(CASE 
                        WHEN sp.GiaKhuyenMai > 0 AND sp.GiaKhuyenMai IS NOT NULL THEN ct.SoLuong * sp.GiaKhuyenMai
                        ELSE ct.SoLuong * ct.Gia
                    END), 0) as doanh_thu
                FROM donhang dh
                JOIN chitietdonhang ct ON dh.id = ct.MaDonHang
                JOIN sanpham sp ON ct.MaSanPham = sp.id
                WHERE dh.TrangThaiThanhToan = 1
                AND YEARWEEK(CURRENT_TIMESTAMP) = YEARWEEK(CURRENT_TIMESTAMP)";
            
            error_log("Weekly Revenue SQL: " . $sql);
            $result = $this->db->getAll($sql);
            error_log("Weekly Revenue Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Weekly Revenue Error: " . $e->getMessage());
            throw $e;
        }
    }

    // Doanh thu theo tháng
    public function getMonthlyRevenue() {
        try {
            $sql = "SELECT 
                    'Tháng này' as ngay,
                    COUNT(DISTINCT dh.id) as so_don_hang,
                    COALESCE(SUM(CASE 
                        WHEN sp.GiaKhuyenMai > 0 AND sp.GiaKhuyenMai IS NOT NULL THEN ct.SoLuong * sp.GiaKhuyenMai
                        ELSE ct.SoLuong * ct.Gia
                    END), 0) as doanh_thu
                FROM donhang dh
                JOIN chitietdonhang ct ON dh.id = ct.MaDonHang
                JOIN sanpham sp ON ct.MaSanPham = sp.id
                WHERE dh.TrangThaiThanhToan = 1
                AND YEAR(CURRENT_TIMESTAMP) = YEAR(CURRENT_TIMESTAMP)
                AND MONTH(CURRENT_TIMESTAMP) = MONTH(CURRENT_TIMESTAMP)";
            
            error_log("Monthly Revenue SQL: " . $sql);
            $result = $this->db->getAll($sql);
            error_log("Monthly Revenue Result: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("Monthly Revenue Error: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
