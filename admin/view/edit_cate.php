<div class="container mt-5">
    <h2>Sửa danh mục</h2>
    <form action="index.php?page=updatecate" method="post" enctype="multipart/form-data">
        <!-- ID danh mục (ẩn) -->
        <input type="hidden" name="id" value="<?= $category['id'] ?>">

        <!-- Tên danh mục -->
        <div class="mb-3">
            <label for="TenDanhMuc" class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" id="TenDanhMuc" name="TenDanhMuc" 
                   value="<?= htmlspecialchars($category['TenDanhMuc']) ?>" required>
        </div>

        <!-- Hình ảnh -->
        <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label><br>
            <?php if (!empty($category['HinhAnh'])): ?>
                <img src="public/img/<?= $category['HinhAnh'] ?>" alt="" width="100">
            <?php else: ?>
                <span>Chưa có ảnh</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="HinhAnh" class="form-label">Chọn hình ảnh mới</label>
            <input type="file" class="form-control" id="HinhAnh" name="HinhAnh">
        </div>

        <!-- Nút submit -->
        <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
    </form>
</div>
