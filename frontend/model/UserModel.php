<?php
require_once 'database.php';

class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Tạo user mới
    public function createUser($userData) {
    $sql = "INSERT INTO khachhang (TenKhachHang, Email, SDT, DiaChi, MatKhau, TrangThai, NgayDangKy) 
        VALUES (:tenkh, :email, :phone, :address, :password, :trangthai, :ngaydangky)";
    $params = [
        'tenkh' => $userData['tenkh'],
        'email' => $userData['email'],
        'phone' => $userData['phone'],
        'address' => $userData['address'],
        'password' => $userData['password'],
        'trangthai' => 1,
        'ngaydangky' => $userData['created_at']
    ];
    return $this->db->execute($sql, $params);
    }
    
    // Lấy user theo email
    public function getUserByEmail($email) {
    $sql = "SELECT * FROM khachhang WHERE email = :email";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Kiểm tra email đã tồn tại
    public function checkEmailExists($email) {
    $sql = "SELECT COUNT(*) FROM khachhang WHERE email = :email";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
    
    
    // Lấy tất cả users
    public function getAllUsers() {
    $sql = "SELECT * FROM khachhang ORDER BY created_at DESC";
        return $this->db->getAll($sql);
    }
    
    // Cập nhật thông tin user
    public function updateUser($userId, $userData) {
    $sql = "UPDATE khachhang SET fullname = :fullname, email = :email, phone = :phone, address = :address 
        WHERE id = :id";
        $userData['id'] = $userId;
        return $this->db->execute($sql, $userData);
    }
    
    // Xóa user
    public function deleteUser($userId) {
    $sql = "DELETE FROM khachhang WHERE id = :id";
        return $this->db->execute($sql, ['id' => $userId]);
    }
}
?>
