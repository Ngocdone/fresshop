<?php
session_start();
require_once('view/header.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
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
    case 'payment':
        require_once('controller/PaymentSuccessController.php');
        $paymentSuccessController = new PaymentSuccessController();
        $paymentSuccessController->showSuccessPage();
        // echo "hello";
        // require_once('view/paymentSuccess.php');
        break;
    default:
        echo "Không tồn tại trang đó";
        break;
}
require_once('view/footer.php');
?>
