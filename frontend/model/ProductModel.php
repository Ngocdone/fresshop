<?php
require_once('Database.php');
class ProductModel {
    // Lấy tất cả sản phẩm
    public function getAllProduct() {
        $sql = "SELECT * FROM sanpham";
        return Database::getInstance()->getAll($sql);
    }

    // Lấy sản phẩm hot
    public function getHotProduct() {
        $sql = "SELECT * FROM sanpham WHERE NoiBat=1 LIMIT 4";
        return Database::getInstance()->getAll($sql);
    }

    // Lấy sản phẩm theo danh mục
    public function getByCate($id) {
        $sql = "SELECT * FROM sanpham WHERE MaDanhMuc=$id LIMIT 4";
        return Database::getInstance()->getAll($sql);
    }

    // Lấy sản phẩm mới nhập
    public function getNewProduct() {
        $sql = "SELECT * FROM sanpham ORDER BY id DESC LIMIT 5";
        return Database::getInstance()->getAll($sql);
    }

    // Lấy sản phẩm chi tiết
    public function getProductById($id) {
        $sql = "SELECT * FROM sanpham WHERE id=$id";
        return Database::getInstance()->getOne($sql);
    }

    // Lấy sản phẩm liên quan
    public function getRelateProduct($id) {
        $sql = "SELECT * FROM sanpham WHERE MaDanhMuc=(SELECT MaDanhMuc FROM sanpham WHERE id=$id) AND id!=$id";
        return Database::getInstance()->getAll($sql);
    }

    // Lấy sản phẩm với search và sort
    public function getProductsWithSearchAndSort($categoryId = null, $search = '', $sortBy = '') {
        $sql = "SELECT * FROM sanpham WHERE 1=1";
        $params = [];
        
        // Lọc theo danh mục nếu có
        if ($categoryId) {
            $sql .= " AND MaDanhMuc = ?";
            $params[] = $categoryId;
        }
        
        // Tìm kiếm theo tên nếu có
        if (!empty($search)) {
            $sql .= " AND TenSanPham LIKE ?";
            $params[] = '%' . $search . '%';
        }
        
        // Sắp xếp
        switch ($sortBy) {
            case 'name_asc':
                $sql .= " ORDER BY TenSanPham ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY TenSanPham DESC";
                break;
            case 'price_asc':
                $sql .= " ORDER BY GiaGoc ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY GiaGoc DESC";
                break;
            default:
                $sql .= " ORDER BY id DESC";
                break;
        }
        
        $conn = Database::getInstance()->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>
