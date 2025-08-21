<?php
require_once('model/CategoryModel.php');

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function renderCategory() {
        $categories = $this->model->getAllCate();
        require_once('view/category.php');
    }

    public function renderAddCate() {
        require_once('view/addcategory.php');
    }

    public function addCategory($data) {
        $this->model->addCategory($data['TenDanhMuc'], $data['HinhAnh']);
    }

    public function updateCate() {
        $id = $_POST['id'];
        $TenDanhMuc = $_POST['TenDanhMuc'];
        $HinhAnh = $_FILES['HinhAnh']['name'] ?? $_POST['old_image'];

        if (!empty($_FILES['HinhAnh']['name']) && $_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['HinhAnh']['tmp_name'], "../public/img/" . $HinhAnh);
        }

        $this->model->updateCategory($id, $TenDanhMuc, $HinhAnh);
    }

    public function deleteCategory($id) {
        $this->model->deleteCategory($id);
    }

    public function editCate($id) {
        $category = $this->model->getCategoryById($id);
        require_once('view/edit_cate.php');
    }
}
?>
