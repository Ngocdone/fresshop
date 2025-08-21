tôi  <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm theo từ khóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <form method="GET" action="index.php" class="w-75 mx-auto">
                            <input type="hidden" name="page" value="product">
                            <div class="input-group d-flex">
                                <input type="search" name="search" class="form-control p-3" placeholder="Nhập từ khóa tìm kiếm..." 
                                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" aria-describedby="search-icon-modal">
                                <button type="submit" class="input-group-text p-3 bg-primary text-white border-0 btn" id="search-icon-modal">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- baner đã sửa -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
                        <h4 class="mb-3 text-secondary">100% Thực phẩm hữu cơ</h4>
                        <h1 class="mb-5 display-3 text-primary">Thực phẩm rau củ quả hữu cơ</h1>
                        <div class="position-relative mx-auto">
                            <input class="form-control border-2 border-secondary w-75 py-3 px-4 rounded-pill" type="number" placeholder="Tìm kiếm">
                            <button type="submit" class="btn btn-primary border-2 border-secondary py-3 px-4 position-absolute rounded-pill text-white h-100" style="top: 0; right: 25%;">Tìm kiếm</button>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="../public/../public/img/hero-img-1.png" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Trái cây</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="../public/../public/img/hero-img-2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Rau củ</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- baner -->


        <!-- tt đã chỉnh -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-car-side fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Miễn phí vận chuyển</h5>
                                <p class="mb-0">Miễn phí cho đơn hàng trên 200.000 ₫/kg</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-user-shield fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Thanh toán bảo mật</h5>
                                <p class="mb-0">Cam kết thanh toán bảo mật 100%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-exchange-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Trả hàng trong 24h</h5>
                                <p class="mb-0">Hoàn lại tiền 100% nếu sản phẩm lỗi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-phone-alt fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
                                <h5>Hỗ trợ 24/7</h5>
                                <p class="mb-0">Hỗ trợ nhanh chóng mọi lúc mọi nơi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--tt -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-2">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>SẢN PHẨM NỔI BẬT</h1>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <?php if (isset($productsHot)){foreach($productsHot as $p){?>
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                            <div class="card h-100 border border-secondary">
                                                <div class="position-relative">
                                                    <img src="../public/img/<?= $p['HinhAnh'] ?>" class="card-img-top rounded-top" alt="<?= $p['TenSanPham'] ?>">
                                                    <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Fruits</span>
                                                </div>
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <h5 class="card-title">
                                                        <a href="?page=detail&id=<?= $p['id'] ?>" class="text-decoration-none text-dark">
                                                            <?= $p['TenSanPham'] ?>
                                                        </a>
                                                    </h5>
                                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                                        <span class="text-dark fs-5 fw-bold"><?= number_format($p['GiaGoc'], 0, ',', '.') ?>₫/kg</span>
                                                        <a href="#" class="btn btn-outline-primary rounded-pill px-3">
                                                            <i class="fa fa-shopping-bag me-2"></i>Mua
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <div class="container-fluid fruite py-2">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>RAU SẠCH</h1>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <?php if (isset($productsCate2)){foreach($productsCate2 as $p){?>
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                            <div class="card h-100 border border-secondary">
                                                <div class="position-relative">
                                                    <img src="../public/img/<?= $p['HinhAnh'] ?>" class="card-img-top rounded-top" alt="<?= $p['TenSanPham'] ?>">
                                                    <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Fruits</span>
                                                </div>
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <h5 class="card-title">
                                                        <a href="?page=detail&id=<?= $p['id'] ?>" class="text-decoration-none text-dark">
                                                            <?= $p['TenSanPham'] ?>
                                                        </a>
                                                    </h5>
                                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                                        <span class="text-dark fs-5 fw-bold"><?= number_format($p['GiaGoc'], 0, ',', '.') ?>₫/kg</span>
                                                        <a href="#" class="btn btn-outline-primary rounded-pill px-3">
                                                            <i class="fa fa-shopping-bag me-2"></i>Mua
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <div class="container-fluid fruite py-2">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            <h1>TRÁI CÂY</h1>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <?php if (isset($productsCate1)){foreach($productsCate1 as $p){?>
                                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                                            <div class="card h-100 border border-secondary">
                                                <div class="position-relative">
                                                    <img src="../public/img/<?= $p['HinhAnh'] ?>" class="card-img-top rounded-top" alt="<?= $p['TenSanPham'] ?>">
                                                    <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Fruits</span>
                                                </div>
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <h5 class="card-title">
                                                        <a href="?page=detail&id=<?= $p['id'] ?>" class="text-decoration-none text-dark">
                                                            <?= $p['TenSanPham'] ?>
                                                        </a>
                                                    </h5>
                                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                                        <span class="text-dark fs-5 fw-bold"><?= number_format($p['GiaGoc'], 0, ',', '.') ?>₫/kg</span>
                                                        <a href="#" class="btn btn-outline-primary rounded-pill px-3">
                                                            <i class="fa fa-shopping-bag me-2"></i>Mua
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        <!-- Featurs Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-secondary rounded border border-secondary">
                                <img src="../public/img/Dao.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-primary text-center p-4 rounded">
                                        <h5 class="text-white">Táo </h5>
                                        <h3 class="mb-0">GIẢM GIÁ 20%</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-dark rounded border border-dark">
                                <img src="../public/img/Dau.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-light text-center p-4 rounded">
                                        <h5 class="text-primary">trái cây ngon</h5>
                                        <h3 class="mb-0">Giao hàng miễn phí</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-primary rounded border border-primary">
                                <img src="../public/img/featur-3.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-secondary text-center p-4 rounded">
                                        <h5 class="text-white">Rau củ</h5>
                                        <h3 class="mb-0">Giảm giá 5.000₫/kg</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs End -->


        <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable py-5">
            <div class="container py-5">
                <h1 class="mb-0">Rau Củ Mới Về</h1>
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    <?php if (isset($productsNew)){foreach($productsNew as $p){?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="../public/img/<?=$p['HinhAnh'] ?>" class="img-fluid w-100 rounded-top" alt="">
                        </div>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">Vegetable</div>
                        <div class="p-4 rounded-bottom">
                            <a href="?page=detail&id=<?=$p['id'] ?>"><h4><?=$p['TenSanPham']?></h4></a>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <span class="text-dark fs-5 fw-bold"><?= number_format($p['GiaGoc'], 0, ',', '.') ?>₫/kg</span>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua</a>
                            </div>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
                
        </div>
        <!-- Vesitable Shop End -->


        <!-- Banner Section Start-->
        <div class="container-fluid banner bg-secondary my-5">
            <div class="container py-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6">
                        <div class="py-4">
                            <h1 class="display-3 text-white">Trái cây tươi</h1>
                            <p class="fw-normal display-3 text-dark mb-4">Trong cửa hàng của chúng tôi</p>
                            <p class="mb-4 text-dark">Do đó, Lorem Ipsum được tạo ra luôn không có sự lặp lại, không có sự hài hước, hoặc các từ ngữ không phù hợp, v.v.</p>
                            <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">MUA</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative">
                            <img src="../public/img/baner-1.png" class="img-fluid w-100 rounded" alt="">
                            <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 250px; height: 150px; top: 0; left: 0;">
                                <h1 style="font-size: 100px;">1</h1>
                                <div class="d-flex flex-column">
                                    <span class="h2 mb-0">50.000₫/kg</span>
                                    <span class="h4 text-muted mb-0">kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Section End -->


        <!-- Bestsaler Product Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Sản phẩm bán chạy nhất</h1>
                    <p>Tươi ngon mỗi ngày, Được thu hoạch trong ngày, sạch, an toàn, không chất bảo quản.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="../public/img/best-product-1.jpg" class="img-fluid rounded-circle w-100" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5">Cam Mỹ</a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <h4 class="mb-3">3.12 $</h4>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Mua</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- Bestsaler Product End -->


        <!-- Fact Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>khách hàng hài lòng</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>chất lượng dịch vụ</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Chứng nhận chất lượng</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Sản phẩm có sẵn</h4>
                                <h1>789</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
