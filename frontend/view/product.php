        <!-- Modal Search Start -->
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


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Sản Phẩm</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
        </div>
        <!-- Single Page Header End -->


        <!-- Fruits Shop Start-->
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4">Cửa hàng trái cây tươi</h1>
                <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                    <div class="alert alert-info mb-4">
                        Kết quả tìm kiếm cho: <strong>"<?= htmlspecialchars($_GET['search']) ?>"</strong>
                        <a href="?page=product<?= isset($_GET['id']) ? '&id='.$_GET['id'] : '' ?>" class="btn btn-sm btn-outline-secondary ms-2">Xóa tìm kiếm</a>
                    </div>
                <?php endif; ?>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-xl-3">
                                <form method="GET" action="">
                                    <input type="hidden" name="page" value="product">
                                    <?php if(isset($_GET['id'])): ?>
                                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                    <?php endif; ?>
                                    <?php if(isset($_GET['sort'])): ?>
                                        <input type="hidden" name="sort" value="<?= $_GET['sort'] ?>">
                                    <?php endif; ?>
                                    <div class="input-group w-100 mx-auto d-flex">
                                        <input type="search" name="search" class="form-control p-3" placeholder="Tìm kiếm sản phẩm..." 
                                               value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" aria-describedby="search-icon-1">
                                        <button type="submit" class="input-group-text p-3 border-0 bg-primary text-white btn" id="search-icon-1">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6"></div>
                            <div class="col-xl-3">
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Sắp xếp theo:</label>
                                    <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" onchange="sortProducts(this.value)">
                                        <option value="">Mặc định</option>
                                        <option value="name_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : '' ?>>Tên A → Z</option>
                                        <option value="name_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : '' ?>>Tên Z → A</option>
                                        <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                                        <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Thể loại</h4>
                                            <ul class="list-unstyled fruite-categorie">
                                                <li>
                                                    <?php if (isset($categories)){foreach($categories as $c){?>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="?page=product&id=<?=$c['id'] ?>"><i class="fas fa-apple-alt me-2"></i><?=$c['TenDanhMuc'] ?></a>
                                                        <span>(3)</span>
                                                    </div>
                                                    <?php }} ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Thêm vào</h4>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                                                <label for="Categories-1"> Hữu cơ</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                                                <label for="Categories-2">  Tươi</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                                                <label for="Categories-3"> Việc bán hàng</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                                                <label for="Categories-4"> Giảm giá</label>
                                            </div>
                                            <div class="mb-2">
                                                <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                                                <label for="Categories-5"> Hết hạn</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <h4 class="mb-3">Sản phẩm nổi bật</h4>
                                        <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded" style="width: 100px; height: 100px;">
                                        <img src="../public/img/featur-3.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Súp Lơ</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="../public/img/vegetable-item-4.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Ớt Chuông</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded me-4" style="width: 100px; height: 100px;">
                                        <img src="../public/img/vegetable-item-6.jpg" class="img-fluid rounded" alt="">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">Rau cần tây</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">2.99 $</h5>
                                            <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                        </div>
                                    </div>
                                </div>
                                        <div class="d-flex justify-content-center my-4">
                                            <a href="#" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem thêm</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative">
                                            <img src="../public/img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                            <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                                <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                    <?php if (isset($products) && !empty($products)) { ?>
                                        <?php foreach ($products as $p) { ?>
                                            <div class="col-md-6 col-lg-6 col-xl-4 mb-4">
                                                <div class="card h-100 border border-secondary">
                                                    <div class="position-relative">
                                                        <img src="../public/img/<?= $p['HinhAnh'] ?>" class="card-img-top rounded-top" alt="<?= $p['TenSanPham'] ?>">
                                                        <span class="badge bg-secondary position-absolute top-0 start-0 m-2">Fruits</span>
                                                    </div>
                                                    <div class="card-body d-flex flex-column justify-content-between">
                                                        <h5 class="card-title">
                                                            <a href="?page=detail&id=<?=$p['id'] ?>"><h4><?=$p['TenSanPham']?></h4></a>
                                                                <?= $p['TenSanPham'] ?>
                                                            </a>
                                                        </h5>
                                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                                            <span class="text-dark fs-5 fw-bold"><?= number_format($p['GiaGoc'], 0, ',', '.') ?>₫/kg</span>
                                                            <form method="POST" action="?page=addcart" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                        <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="btn btn-outline-primary rounded-pill px-3">              
                                                                <i class="fa fa-shopping-bag me-2"></i> Add to cart
                                                            </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="col-12">
                                            <div class="text-center py-5">
                                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                                <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                                                <p class="text-muted">Hãy thử tìm kiếm với từ khóa khác hoặc xem tất cả sản phẩm</p>
                                                <a href="?page=product" class="btn btn-primary">Xem tất cả sản phẩm</a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <a href="#" class="rounded">&laquo;</a>
                                            <a href="#" class="active rounded">1</a>
                                            <a href="#" class="rounded">2</a>
                                            <a href="#" class="rounded">3</a>
                                            <a href="#" class="rounded">4</a>
                                            <a href="#" class="rounded">5</a>
                                            <a href="#" class="rounded">6</a>
                                            <a href="#" class="rounded">&raquo;</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fruits Shop End-->