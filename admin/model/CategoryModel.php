<?php
require_once('../frontend/model/Database.php');

class CategoryModel {
    public function getAllCate() {
        $sql = "SELECT * FROM danhmuc ORDER BY id DESC";
        return Database::getInstance()->getAll($sql);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM danhmuc WHERE id = ?";
        return Database::getInstance()->getOne($sql, [$id]);
    }

    public function addCategory($TenDanhMuc, $HinhAnh) {
        $sql = "INSERT INTO danhmuc (TenDanhMuc, HinhAnh) VALUES (?, ?)";
        return Database::getInstance()->execute($sql, [$TenDanhMuc, $HinhAnh]);
    }

    public function updateCategory($id, $TenDanhMuc, $HinhAnh) {
        $sql = "UPDATE danhmuc SET TenDanhMuc = ?, HinhAnh = ? WHERE id = ?";
        return Database::getInstance()->execute($sql, [$TenDanhMuc, $HinhAnh, $id]);
    }

    public function deleteCategory($id) {
    // Xóa tất cả sản phẩm thuộc danh mục này
    Database::getInstance()->execute("DELETE FROM sanpham WHERE MaDanhMuc = ?", [$id]);

    // Xóa danh mục
    Database::getInstance()->execute("DELETE FROM danhmuc WHERE id = ?", [$id]);
}
}

?>
