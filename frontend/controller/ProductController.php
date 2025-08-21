<?php
class ProductController{
    //thuộc tính
    private $productModel;
    private $CategoryModel;
    //khởi tạo
    public function __construct(){
        require_once('model/ProductModel.php');
        $this->productModel = new ProductModel();
        require_once('model/CategoryModel.php');
        $this->categoryModel = new CategoryModel();
    }
    //phương thức

    //tạo trang chủ
    public function renderHome(){
        $productsHot=$this->productModel ->getHotProduct();
        $productsCate1=$this->productModel ->getByCate(1);
        $productsCate2=$this->productModel ->getByCate(2);
        $productsCate3=$this->productModel ->getByCate(3);
        $productsCate4=$this->productModel ->getByCate(4);
        $productsNew=$this->productModel ->getNewProduct();
        require_once('view/home.php');
    }
    // //tạo trang sản phẩm
    //  public function renderProduct($id){
    //     if ($id) {
    //          $products=$this->productModel ->getByCate($id);
    //      }else{
    //          $products=$this->productModel ->getAllProduct();
    //     }
    //      $categories =$this->categoryModel->getAllCate();
    //      print_r($catgories);
    //      require_once('view/product.php');

    // }
    public function renderProduct($id) {
    // Lấy tham số search và sort từ URL
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $sortBy = isset($_GET['sort']) ? $_GET['sort'] : '';

    // Lấy sản phẩm theo search + sort + lọc danh mục
    $products = $this->productModel->getProductsWithSearchAndSort($id, $search, $sortBy);

    // Lấy danh mục
    $categories = $this->categoryModel->getAllCate();

    // Gọi view
    require_once('view/product.php');
}

// tạo trang chi tiết
        public function renderDetail($id){
            if ($id) {
                # code...
            }
        $product=$this->productModel ->getProductById($id);
        $relateProduct=$this->productModel ->getRelateProduct($id);
        // print_r($relateProduct);
        require_once('view/Detail.php');
    }
    
}
?>