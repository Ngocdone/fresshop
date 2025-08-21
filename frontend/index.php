<?php
session_start();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

ob_start(); // ✅ Bắt đầu bộ đệm đầu ra – ngăn việc gửi dữ liệu sớm (rất quan trọng)
require_once('view/header.php'); // OK – giờ có thể ở trên cùng
switch ($page) {
    case 'home':
        require_once('controller/ProductController.php');
        $productController = new ProductController();
        $productController->renderHome();
        break;
    case 'product':
        $id = $_GET['id'];
        require_once('controller/ProductController.php');
        $productController = new ProductController();
        $productController->renderproduct($id);
        break;
    case "detail":
        $id = $_GET['id'];
        require_once('controller/ProductController.php');
        $productController = new ProductController();
        $productController->renderDetail($id);
        break;
    case 'cart':
        require_once('view/cart.php');
        break;
    case 'addcart':
        require_once('controller/CartController.php');
        $cartController = new CartController();
        $cartController->addToCart();
        break;
    case 'removeFromCart':
        require_once('controller/CartController.php');
        $cartController = new CartController();
        $cartController->removeFromCart();
        break;
    case 'contact':
        require_once('view/contact.php');
        break;
    case 'register':
        require_once('view/register.php');
        break;
    case 'login':
        require_once('view/login.php');
        break;
    case 'checkout':
        require_once('view/checkout.php');
        break;
    case 'header':
        require_once('view/header.php');
        break;
    case 'checkoutform':   // xử lý thanh toán => redirect
        require_once('controller/PaymentSuccessController.php');
        $orderController = new OrderController();
        $orderController->checkout();
        break;
    case 'orderSuccess':   // cảm ơn
        require_once('controller/PaymentSuccessController.php');
        $orderController = new OrderController();
        $orderController->orderSuccess();
        break;
    default:
        echo "Không tồn tại trang đó";
        break;
}
require_once('view/footer.php');
ob_end_flush(); // ✅ Gửi toàn bộ dữ liệu ra sau khi xử lý xong
