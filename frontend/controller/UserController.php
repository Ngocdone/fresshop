<?php
session_start();
require_once '../model/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
            // Lấy dữ liệu từ form
            $tenkh = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            // Kiểm tra dữ liệu
            if (empty($tenkh) || empty($email) || empty($phone) || empty($address) || empty($password)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header("Location: ../view/register.php");
                exit();
            }
            
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
                header("Location: ../view/register.php");
                exit();
            }
            
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Mật khẩu phải có ít nhất 6 ký tự!";
                header("Location: ../view/register.php");
                exit();
            }
            
            // Kiểm tra email đã tồn tại
            if ($this->userModel->checkEmailExists($email)) {
                $_SESSION['error'] = "Email này đã được sử dụng!";
                header("Location: ../view/register.php");
                exit();
            }
            
            
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Tạo user mới
            $userData = [
                'tenkh' => $tenkh,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'password' => $hashed_password,
                'role' => 0, // 0 = user thường, 1 = admin
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->userModel->createUser($userData)) {
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: /fresshop/frontend/?page=login');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
                header("Location: ../view/register.php");
                exit();
            }
        }
    }
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
                header("Location: ../view/login.php");
                exit();
            }
            $user = $this->userModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['MatKhau'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['Email'];
                $_SESSION['fullname'] = $user['TenKhachHang'];
                $_SESSION['role'] = $user['TrangThai'];
                if ($user['TrangThai'] == 0) {
                    header("Location: /fresshop/admin/index.php");
                } else {
                    header("Location: /fresshop/frontend/index.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "Email hoặc mật khẩu không đúng!";
                header("Location: ../view/login.php");
                exit();
            }
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: /fresshop/frontend/index.php?page=home");
        exit();
    }
}

// Xử lý các request
$userController = new UserController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'logout':
            $userController->logout();
            break;
    }
}

// Xử lý form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $userController->register();
    } elseif (isset($_POST['login'])) {
        $userController->login();
    }
}
?>
