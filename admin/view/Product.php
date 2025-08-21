<!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Quản lý sản phẩm</h1>
                <div class="header-actions">
                    <a href="?page=showaddproduct"><button class="btn btn-primary">+ Thêm sản phẩm</button></a>
                    <button class="btn btn-primary">📤 Xuất Excel</button>
                </div>
            </div>

            <!-- Product Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Danh sách sản phẩm</h3>
                    <input type="text" class="search-box" placeholder="Tìm kiếm sản phẩm...">
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th>Ngày nhập</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $key => $value) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><img src="../public/img/<?= urlencode($value['HinhAnh']) ?>" alt="Product" class="product-img" width="80"></td>
                            <td><?= $value['TenSanPham'] ?></td>
                            <td><?= $value['TenDanhMuc'] ?></td>
                            <td><?= number_format($value['GiaGoc']) ?>₫</td>
                            <td ><?= $value['SoLuong'] ?></td>
                            <td><span class="status active">Hoạt động</span></td>
                            <td><?= $value['NgayNhap'] ?? '---' ?></td>
                            <td>
                                <div class="action-buttons">
                                <a href="?page=editproduct&id=<?= $value['id'] ?>" class="btn btn-sm btn-warning">✎</a>
                                <a href="?page=deleteproduct&id=<?= $value['id'] ?>" 
                                onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" 
                                class="btn btn-sm btn-danger">✕</a>
                            </div>
                            </td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="page-btn">« Trước</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">Tiếp »</button>
                </div>
            </div>
        </div>
    </div>