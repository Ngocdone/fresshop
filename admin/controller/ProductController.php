<?php
require_once('model/ProductModel.php');
require_once('model/CategoryModel.php');

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // ====================== DANH SÁCH SẢN PHẨM ======================
    public function renderProductList() {
        $products = $this->productModel->getAllProductWithCategory();
        require_once('view/product.php');
    }

    // ====================== THÊM SẢN PHẨM ======================
    public function renderAddProduct() {
        $categories = $this->categoryModel->getAllCate();
        require_once('view/addProduct.php');
    }

   public function addProduct($postData, $filesData) {
    $TenSanPham = trim($postData['TenSanPham']);
    $GiaGoc = $postData['GiaGoc'];
    $MaDanhMuc = $postData['MaDanhMuc']; // đổi cho khớp với form
    $SoLuong = $postData['SoLuong'];
    $NgayNhap = !empty($postData['NgayNhap']) ? $postData['NgayNhap'] : date('Y-m-d');
    $TrangThai = $postData['TrangThai'];

    // Kiểm tra danh mục hợp lệ
    if (empty($MaDanhMuc)) {
        die('Vui lòng chọn danh mục hợp lệ.');
    }

    // Xử lý upload ảnh
    $fileName = '';
    if (isset($filesData['HinhAnh']) && $filesData['HinhAnh']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($filesData['HinhAnh']['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($filesData['HinhAnh']['tmp_name'], __DIR__ . '/../uploads/' . $fileName);
    }

    // Thêm vào DB
    $this->productModel->addProduct(
        $TenSanPham,
        $GiaGoc,
        $fileName,
        $MaDanhMuc,
        $SoLuong,
        $NgayNhap,
        $TrangThai
    );

    header("Location: index.php?page=productList");
}



    // ====================== SỬA SẢN PHẨM ======================
    public function renderEditProduct($id) {
    $categories = $this->categoryModel->getAllCate();
    $product = $this->productModel->getProductById($id);
    require_once('view/edit_product.php');
    }
    public function updateProduct($data, $files) {
        $id = $data['id']; 
        $product = $this->productModel->getProductById($id);
        $hinhAnh = $product['HinhAnh'];

        if (!empty($files['HinhAnh']['name'])) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . basename($files['HinhAnh']['name']);
            $targetPath = $uploadDir . $fileName;
            move_uploaded_file($files['HinhAnh']['tmp_name'], $targetPath);
            $hinhAnh = $fileName;
        }

        $this->productModel->updateProduct(
    $id,
    $data['TenSanPham'],
    $data['GiaGoc'],
    $data['SoLuong'],
    $hinhAnh,
    $data['id_danhmuc'],   // ✅ Truyền đúng MaDanhMuc
    $data['TrangThai']     // ✅ Truyền đúng Trạng thái
);

        header("Location: ?page=product");
        exit;
    }

    // ====================== XÓA SẢN PHẨM ======================
    public function deleteProduct($id) {
        $this->productModel->deleteProduct($id);
        header("Location: ?page=product");
        exit;
    }
}
