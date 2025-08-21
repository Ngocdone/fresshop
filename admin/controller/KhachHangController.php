<?php
require_once __DIR__ . '/../model/KhachHangModel.php';

class KhachHangController {
    private $model;

    public function __construct() {
        $this->model = new KhachHangModel();
    }

    public function index() {
        $khachhangs = $this->model->getAllKhachHang();
        return $khachhangs;
    }

    public function edit($id) {
        $khachhang = $this->model->getKhachHangById($id);
        if (!$khachhang) {
            header('Location: index.php?page=khachhang');
            exit();
        }
        include __DIR__ . '/../view/edit_khachhang.php';
    }

    public function update($id, $data) {
        $this->model->updateKhachHang($id, $data);
        header('Location: index.php?page=khachhang');
        exit();
    }

    public function delete($id) {
        $this->model->deleteKhachHang($id);
        header('Location: index.php?page=khachhang');
        exit();
    }
}

// Xử lý request
$controller = new KhachHangController();

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'edit':
        if ($id) $controller->edit($id);
        break;
    case 'update':
        if ($id && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenKhachHang' => $_POST['TenKhachHang'],
                'Email' => $_POST['Email'],
                'MatKhau' => $_POST['MatKhau'],
                'DiaChi' => $_POST['DiaChi'],
                'SDT' => $_POST['SDT'],
                'TrangThai' => $_POST['TrangThai']
            ];
            $controller->update($id, $data);
        }
        break;
    case 'delete':
        if ($id) $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
?>
