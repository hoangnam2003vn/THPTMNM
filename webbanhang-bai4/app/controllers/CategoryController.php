<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryController
{
    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name'])) {
            $name = trim($_POST['name']);
            if ($this->categoryModel->addCategory($name)) {
                header("Location: /Category/list");
                exit();
            } else {
                echo "Lỗi khi thêm danh mục.";
            }
        } else {
            echo "Tên danh mục không hợp lệ.";
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Danh mục không tồn tại.";
        }
    }

    private function uploadImage($file) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
        throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
        throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
        }

    // Cập nhật danh mục
    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
            $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $this->uploadImage($_FILES['image']);
        } else {
            $image = $_POST['existing_image'];
        }
        $edit = $this->categoryModel->updateCategory($id, $name, $description, $price, $category_id, $image);
        if ($edit) {
            header('Location: /Category/list');
        } else {
            echo "Đã xảy ra lỗi khi lưu sản phẩm.";
        }
    }
}

    // Xóa danh mục
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
}
?>