<?php
require_once __DIR__ . '/../../frontend/model/database.php';

class KhachHangModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllKhachHang() {
        $sql = "SELECT * FROM khachhang ORDER BY id DESC";
        return $this->db->getAll($sql);
    }

    public function getKhachHangById($id) {
        $sql = "SELECT * FROM khachhang WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createKhachHang($data) {
        $sql = "INSERT INTO khachhang (TenKhachHang, Email, MatKhau, DiaChi, SDT, NgayDangKy, TrangThai) 
                VALUES (:tenkh, :email, :matkhau, :diachi, :sdt, :ngaydangky, :trangthai)";
        return $this->db->execute($sql, [
            'tenkh' => $data['TenKhachHang'],
            'email' => $data['Email'],
            'matkhau' => $data['MatKhau'],
            'diachi' => $data['DiaChi'],
            'sdt' => $data['SDT'],
            'ngaydangky' => $data['NgayDangKy'],
            'trangthai' => $data['TrangThai']
        ]);
    }

    public function updateKhachHang($id, $data) {
        $sql = "UPDATE khachhang SET TenKhachHang = :tenkh, Email = :email, MatKhau = :matkhau, DiaChi = :diachi, SDT = :sdt, TrangThai = :trangthai WHERE id = :id";
        return $this->db->execute($sql, [
            'tenkh' => $data['TenKhachHang'],
            'email' => $data['Email'],
            'matkhau' => $data['MatKhau'],
            'diachi' => $data['DiaChi'],
            'sdt' => $data['SDT'],
            'trangthai' => $data['TrangThai'],
            'id' => $id
        ]);
    }

    public function deleteKhachHang($id) {
        $sql = "DELETE FROM khachhang WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}
?>
