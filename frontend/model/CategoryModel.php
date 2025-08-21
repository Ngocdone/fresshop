<?php
require_once('Database.php');
class CategoryModel{
    //lấy tất cả danh mục
    public function getAllCate(){
        $sql="SELECT *FROM danhmuc";
        return Database::getInstance()->getAll($sql);
    }
public function getAllProductWithCategory(){
    $sql = "SELECT sanpham.*, danhmuc.TenDanhMuc 
            FROM sanpham 
            JOIN danhmuc ON sanpham.MaDanhMuc = danhmuc.id";
    return Database::getInstance()->getAll($sql);
}
public function addcategory($data) {
    $sql = "INSERT INTO danhMuc (TenDanhMuc, HinhAnh) VALUES (?, ?)";
    $params = [$data['TenDanhMuc'], $data['HinhAnh']];
    return Database::getInstance()->execute($sql, $params);
}
//xóa
public function deletacategory($id){
    $spl="DELETE FROM  danhmuc WHERE id=?";
    return Database::getInstance()->execute($sql,[$id]);
}
}
?>