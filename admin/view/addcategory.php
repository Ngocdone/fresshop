<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Thêm danh mục</h4>
                </div>
                <div class="card-body">
                    <form action="?page=addCate" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="TenDanhMuc" class="form-label">Tên danh mục</label>
                            <input type="text" class="form-control" name="TenDanhMuc" id="TenDanhMuc" placeholder="Nhập tên danh mục" required>
                        </div>

                        <div class="mb-3">
                            <label for="HinhAnh" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" name="HinhAnh" id="HinhAnh" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Thêm danh mục</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
