<?php
require_once('controller/CategoryController.php');
require_once('controller/ProductController.php');

$categoryController = new CategoryController();
$productController  = new ProductController();

// Ép $page về chữ thường để tránh phân biệt hoa/thường
$page = strtolower($_GET['page'] ?? 'category');

// ==== Xử lý POST ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($page) {
        // ===== DANH MỤC =====
        case 'addcate':
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            $categoryController->addCategory($data);
            header("Location: index.php?page=category");
            exit;

        case 'updatecate':
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            $categoryController->updateCate($data);
            header("Location: index.php?page=category");
            exit;

        // ===== SẢN PHẨM =====
        case 'addproduct':
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            $productController->addProduct($data, $_FILES);
            header("Location: index.php?page=product");
            exit;

        case 'updateproduct':
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            $productController->updateProduct($data, $_FILES);
            header("Location: index.php?page=product");
            exit;
    }
}

// ==== Xử lý GET ====
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($page) {
        // Xóa danh mục
        case 'deletecate':
            if (!empty($_GET['id'])) {
                $categoryController->deleteCategory($_GET['id']);
            }
            header("Location: index.php?page=category");
            exit;

        // Xóa sản phẩm
        case 'deleteproduct':
            if (!empty($_GET['id'])) {
                $productController->deleteProduct($_GET['id']);
            }
            header("Location: index.php?page=product");
            exit;
    }
}

// ==== Giao diện ====
require_once('view/header.php');

switch ($page) {
    // ===== DANH MỤC =====
    case 'category':
        $categoryController->renderCategory();
        break;

    case 'showaddcate':
        $categoryController->renderAddCate();
        break;

    case 'editcate':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $categoryController->editCate($id);
        }
        break;

    // ===== SẢN PHẨM =====
    case 'product':
        $productController->renderProductList();
        break;

    case 'showaddproduct':
        $productController->renderAddProduct();
        break;

    case 'editproduct': // hiển thị form sửa sản phẩm
        $id = $_GET['id'] ?? null;
        if ($id) {
            $productController->renderEditProduct($id);
        }
        break;

    case "khachhang":
        require_once 'controller/KhachHangController.php';
        $khachhangController = new KhachHangController();
        $khachhangs = $khachhangController->index();
        include 'view/khachhang.php';
        break;
    default:
        echo "<h2>Trang không tồn tại</h2>";
        break;
}

require_once('view/footer.php');
?>