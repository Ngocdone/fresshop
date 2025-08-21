
<div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>Quản lý sản phẩm</h1>
                <div class="header-actions">
                    <a href="?page=showaddcate"><button  class="btn btn-primary">+ Thêm sản phẩm</button></a>
                    <button class="btn btn-primary">📤 Xuất Excel</button>
                </div>
            </div>

            <!-- Product Table -->
            <div class="table-container">
                <div class="table-header">
                    <h3>Danh sách sản phẩm</h3>
                    <input type="text" class="search-box" placeholder="Tìm kiếm danh mục...">
                </div>
        </div>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $key => $value) { ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $value['TenDanhMuc'] ?></td>
                    <td><img src="../public/img/<?= urlencode($value['HinhAnh']) ?>" alt="Product" class="product-img" width="80"></td>
                    <td>
                        <a href="?page=editcate&id=<?= $value['id'] ?>"><button class="btn btn-sm btn-primary">✎</button></a>
                       <a href="?page=deletecate&id=<?= $value['id'] ?>" 
   onclick="return confirm('Bạn có chắc muốn xóa không?')">
    <button class="btn btn-sm btn-danger">✕</button>
</a>
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