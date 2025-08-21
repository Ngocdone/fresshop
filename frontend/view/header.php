<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>FreshFarm</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="../public/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="../public/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../public/css/style.css" rel="stylesheet">
        <style>
    .product-title {
        min-height: 48px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* số dòng */
        -webkit-box-orient: vertical;
    }

    .owl-carousel .item {
        height: 100%;
    }

    .owl-carousel .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
    }
</style>

    </head>

    <body>


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Công viên phần mềm Quang Trung, Hồ Chí Minh</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Nhom3FPL.edu.vn</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Chính sách bảo mật</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Điều khoản sử dụng</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Bán hàng và hoàn tiền</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="?page=home" class="navbar-brand"><h1 class="text-primary display-6">FreshFarm</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="?page=home" class="nav-item nav-link active">Trang chủ</a>
                            <a href="?page=product" class="nav-item nav-link">Sản Phẩm</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="chackout.html" class="dropdown-item">Checkout</a>
                                    <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                    <a href="404.html" class="dropdown-item">404 Page</a>
                                </div>
                            </div>
                            <a href="?page=contact" class="nav-item nav-link">Liên Hệ</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <?php
                            // Xóa session_start() ở đây để tránh lỗi session đã được khởi tạo
                            require_once __DIR__ . '/../model/database.php';

                            $cartCount = 0;
                            if (isset($_SESSION['user_id'])) {
                                $userId = $_SESSION['user_id'];
                                $db = Database::getInstance();
                                $conn = $db->getConnection();

                                $sqlCount = "SELECT SUM(SoLuong) as total_quantity FROM chitietdonhang 
                                             JOIN donhang ON chitietdonhang.MaDonHang = donhang.id
                                             WHERE donhang.MaKhachHang = :user_id AND donhang.TrangThaiThanhToan = 0";
                                $stmtCount = $conn->prepare($sqlCount);
                                $stmtCount->execute(['user_id' => $userId]);
                                $resultCount = $stmtCount->fetch();
                                if ($resultCount && $resultCount['total_quantity']) {
                                    $cartCount = $resultCount['total_quantity'];
                                }
                            }
                            ?>
                            <a href="?page=cart" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;"><?= $cartCount ?></span>
                            </a>
<div class="dropdown">
    <a href="#" class="my-auto dropdown-toggle" data-bs-toggle="dropdown">
        <i class="fas fa-user fa-2x"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i><?php echo $_SESSION['fullname']; ?></a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart me-2"></i>Đơn hàng</a></li>
            <li><hr class="dropdown-divider"></li>
<li><a class="dropdown-item" href="/fresshop/frontend/controller/UserController.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
        <?php else: ?>
            <li><a class="dropdown-item" href="?page=login"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</a></li>
            <li><a class="dropdown-item" href="?page=register"><i class="fas fa-user-plus me-2"></i>Đăng ký</a></li>
        <?php endif; ?>
    </ul>
</div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

