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
// ==== XỬ LÝ TRƯỚC KHI XUẤT HTML ====

// Lấy page
$page = strtolower($_GET['page'] ?? 'category');

// Complete order (xóa đơn hàng)
if ($page === 'completeorder') {
    $orderId = $_GET['order_id'] ?? 0;
    if ($orderId) {
        require_once 'controller/OrderController.php';
        $orderController = new OrderController();
        $orderController->completeOrder($orderId); // thực hiện xóa đơn hàng + chi tiết
    }
    header("Location: index.php?page=orders");
    exit;
}

// ==== XỬ LÝ POST ====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($page) {
        // ===== DANH MỤC =====
        case 'addcate':
        case 'updatecate':
            require_once 'controller/CategoryController.php';
            $categoryController = new CategoryController();
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            if ($page === 'addcate') $categoryController->addCategory($data);
            else $categoryController->updateCate($data);
            header("Location: index.php?page=category");
            exit;

        // ===== SẢN PHẨM =====
        case 'addproduct':
        case 'updateproduct':
            require_once 'controller/ProductController.php';
            $productController = new ProductController();
            $data = $_POST;
            $data['HinhAnh'] = $_FILES['HinhAnh']['name'] ?? '';
            if (!empty($_FILES['HinhAnh']['name'])) {
                move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $data['HinhAnh']);
            }
            if ($page === 'addproduct') $productController->addProduct($data, $_FILES);
            else $productController->updateProduct($data, $_FILES);
            header("Location: index.php?page=product");
            exit;
    }
}

// ==== XỬ LÝ GET ====
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($page) {
        case 'deletecate':
            if (!empty($_GET['id'])) {
                require_once 'controller/CategoryController.php';
                $categoryController = new CategoryController();
                $categoryController->deleteCategory($_GET['id']);
            }
            header("Location: index.php?page=category");
            exit;

        case 'deleteproduct':
            if (!empty($_GET['id'])) {
                require_once 'controller/ProductController.php';
                $productController = new ProductController();
                $productController->deleteProduct($_GET['id']);
            }
            header("Location: index.php?page=product");
            exit;
    }
}

// ==== INCLUDE HEADER ====
require_once('view/header.php');

// ==== XỬ LÝ SWITCH GIAO DIỆN ====
switch ($page) {
    // ===== DANH MỤC =====
    case 'category':
        require_once 'controller/CategoryController.php';
        $categoryController = new CategoryController();
        $categoryController->renderCategory();
        break;

    case 'showaddcate':
        require_once 'controller/CategoryController.php';
        $categoryController = new CategoryController();
        $categoryController->renderAddCate();
        break;

    case 'editcate':
        require_once 'controller/CategoryController.php';
        $categoryController = new CategoryController();
        $id = $_GET['id'] ?? null;
        if ($id) $categoryController->editCate($id);
        break;

    // ===== SẢN PHẨM =====
    case 'product':
        require_once 'controller/ProductController.php';
        $productController = new ProductController();
        $productController->renderProductList();
        break;

    case 'showaddproduct':
        require_once 'controller/ProductController.php';
        $productController = new ProductController();
        $productController->renderAddProduct();
        break;

    case 'editproduct':
        require_once 'controller/ProductController.php';
        $productController = new ProductController();
        $id = $_GET['id'] ?? null;
        if ($id) $productController->renderEditProduct($id);
        break;

    // ===== ĐƠN HÀNG =====
    case 'orders':
        require_once 'controller/OrderController.php';
        $orderController = new OrderController();
        $orderController->index();
        break;

    case 'order_detail':
        require_once 'controller/OrderController.php';
        $orderController = new OrderController();
        $id = $_GET['id'] ?? 0;
        $orderController->detail($id);
        break;

    // ===== KHÁCH HÀNG =====
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

// ==== INCLUDE FOOTER ====
require_once('view/footer.php');
?>