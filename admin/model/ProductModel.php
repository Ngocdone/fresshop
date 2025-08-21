<?php
require_once __DIR__ . '/../../frontend/model/database.php';

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Lấy tất cả sản phẩm kèm tên danh mục
    public function getAllProductWithCategory() {
        $sql = "SELECT sanpham.*, danhmuc.TenDanhMuc
                FROM sanpham
                JOIN danhmuc ON sanpham.MaDanhMuc = danhmuc.id";
        return $this->db->getAll($sql);
    }

    // Thêm sản phẩm mới
    public function addProduct($TenSanPham, $GiaGoc, $HinhAnh, $MaDanhMuc, $SoLuong, $NgayNhap, $TrangThai) {
    $sql = "INSERT INTO sanpham (TenSanPham, GiaGoc, HinhAnh, MaDanhMuc, SoLuong, NgayNhap, TrangThai)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    return $this->db->execute($sql, [$TenSanPham, $GiaGoc, $HinhAnh, $MaDanhMuc, $SoLuong, $NgayNhap, $TrangThai]);
}


    // Xóa sản phẩm
    public function deleteProduct($id) {
        $sql = "DELETE FROM sanpham WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id) {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $TenSanPham, $GiaGoc, $HinhAnh, $MaDanhMuc, $SoLuong, $NgayNhap, $TrangThai) {
        $sql = "UPDATE sanpham 
                SET TenSanPham = ?, GiaGoc = ?, HinhAnh = ?, MaDanhMuc = ?, SoLuong = ?, NgayNhap = ?, TrangThai = ?
                WHERE id = ?";
        $params = [$TenSanPham, $GiaGoc, $HinhAnh, $MaDanhMuc, $SoLuong, $NgayNhap, $TrangThai, $id];
        return $this->db->execute($sql, $params);
    }
}
