<div class="container mt-5">
    <h3>Sửa sản phẩm</h3>
    <form action="?page=updateProduct" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="hidden" name="old_image" value="<?= $product['HinhAnh'] ?>">

        <div class="mb-3">
            <label>Tên sản phẩm</label>
            <input type="text" name="TenSanPham" class="form-control" value="<?= $product['TenSanPham'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Giá gốc</label>
            <input type="number" name="GiaGoc" class="form-control" value="<?= $product['GiaGoc'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Danh mục</label>
            <select name="id_danhmuc" class="form-control">
                <?php foreach($categories as $cate): ?>
                    <option value="<?= $cate['id'] ?>" <?= ($product['MaDanhMuc'] == $cate['id']) ? 'selected' : '' ?>>
                        <?= $cate['TenDanhMuc'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="SoLuong" class="form-control" value="<?= $product['SoLuong'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Ngày nhập</label>
            <input type="date" name="NgayNhap" class="form-control" value="<?= $product['NgayNhap'] ?>">
        </div>

        <div class="mb-3">
            <label>Trạng thái</label>
            <select name="TrangThai" class="form-control">
                <option value="1" <?= ($product['TrangThai'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                <option value="0" <?= ($product['TrangThai'] == 0) ? 'selected' : '' ?>>Ẩn</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Hình ảnh</label><br>
            <img src="/duan1/public/img/<?= $product['HinhAnh'] ?>" width="100"><br><br>
            <input type="file" name="HinhAnh" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="?page=productlist" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
