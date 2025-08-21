<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Thêm sản phẩm</h4>
                </div>
                <div class="card-body">
                    <form action="?page=addProduct" method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="TenSanPham" class="form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="TenSanPham" id="TenSanPham" required>
                            </div>
                            <div class="col-md-6">
                                <label for="MaDanhMuc" class="form-label">Danh mục</label>
                                <select name="MaDanhMuc" required>
                            <?php foreach ($categories as $cate): ?>
                                <option value="<?= $cate['id'] ?>"
                            <?= (isset($product['MaDanhMuc']) && $cate['id'] == $product['MaDanhMuc']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cate['TenDanhMuc']) ?>
                        </option>
                            <?php endforeach; ?>
                        </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="GiaGoc" class="form-label">Giá (VND)</label>
                                <input type="number" class="form-control" name="GiaGoc" id="GiaGoc" required>
                            </div>
                            <div class="col-md-6">
                                <label for="SoLuong" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" name="SoLuong" id="SoLuong" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="HinhAnh" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" name="HinhAnh"  required>
                        </div>

                        <div class="mb-3">
                            <label for="NgayNhap" class="form-label">Ngày nhập</label>
                            <input type="date" class="form-control" name="NgayNhap" id="NgayNhap">
                        </div>

                        <div class="mb-3">
                            <label for="TrangThai" class="form-label">Trạng thái</label>
                            <select class="form-select" name="TrangThai" id="TrangThai">
                                <option value="1" selected>Hoạt động</option>
                                <option value="0">Ngưng hoạt động</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
