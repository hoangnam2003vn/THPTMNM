<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class ProductController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }
    public function show($id)
    {
        if (!SessionHelper::isLoggedIn()) {
            echo "Vui lòng đăng nhập để xem chi tiết sản phẩm.";
            return;
        }
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    public function add()
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền thêm sản phẩm.";
            return;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /Product');
            }
        }
    }
    public function edit($id)
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền sửa sản phẩm.";
            return;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }
    public function delete($id)
    {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền xóa sản phẩm.";
            return;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
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

    public function addToCart($id) {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
            $username = SessionHelper::getUsername();
            $product = $this->productModel->getProductById($id);
            if (!$product) {
                echo "Không tìm thấy sản phẩm.";
                return;
            }
    
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!isset($_SESSION['cart'][$username])) {
                $_SESSION['cart'][$username] = [];
            }
    
            if (isset($_SESSION['cart'][$username][$id])) {
                $_SESSION['cart'][$username]['quantity']++;
            } else {
                $_SESSION['cart'][$username][$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                    'image' => $product->image
                ];
            }
            header('Location: /Product/cart');
        }
        
        public function cart()
        {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
    
            $username = SessionHelper::getUsername();
            $cart = isset($_SESSION['cart'][$username]) ? $_SESSION['cart'][$username] : [];
            $totalAmount = 0;
            foreach ($cart as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }
            include 'app/views/product/cart.php';
        }

        public function updateCart($id) {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
    
            $username = SessionHelper::getUsername();
            if (!isset($_SESSION['cart'][$username][$id])) {
                echo "Sản phẩm không tồn tại trong giỏ hàng.";
                return;
            }
    
            if (isset($_GET['action'])) {
                $action = $_GET['action'];
                if ($action === 'increase') {
                    $_SESSION['cart'][$username][$id]['quantity']++;
                } elseif ($action === 'decrease') {
                    if ($_SESSION['cart'][$username][$id]['quantity'] > 1) {
                        $_SESSION['cart'][$username][$id]['quantity']--;
                    } else {
                        unset($_SESSION['cart'][$username][$id]);
                    }
                }
            }
            header('Location: /Product/cart');
    
            // Chuyển hướng về trang giỏ hàng sau khi cập nhật
            exit;
        }

        public function remove($id) 
        {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
    
            $username = SessionHelper::getUsername();
            if (isset($_SESSION['cart'][$username][$id])) {
                unset($_SESSION['cart'][$username][$id]);
            }
            header('Location: /Product/cart');
            exit;
        }
            

        public function checkout()
        {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
    
            $username = SessionHelper::getUsername();
            if (!isset($_SESSION['cart'][$username]) || empty($_SESSION['cart'][$username])) {
                header('Location: /Product/cart');
                return;
            }
            include 'app/views/product/checkout.php';
        }
        
        public function processCheckout()
        {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
    
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: /Product/checkout');
                return;
            }
    
            $username = SessionHelper::getUsername();
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
    
            if (empty($name) || empty($phone) || empty($address)) {
                echo "Vui lòng điền đầy đủ thông tin.";
                return;
            }
    
            if (!isset($_SESSION['cart'][$username]) || empty($_SESSION['cart'][$username])) {
                echo "Giỏ hàng trống.";
                return;
            }
    
            $this->db->beginTransaction();
            try {
                // Lưu đơn hàng mà không cần user_id
                $query = "INSERT INTO orders (name, phone, address, username) VALUES (:name, :phone, :address, :username)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();
    
                $cart = $_SESSION['cart'][$username];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                             VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }
    
                unset($_SESSION['cart'][$username]);
                $this->db->commit();
                header('Location: /Product/orderConfirmation');
                exit;
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
        

        public function orderConfirmation()
        {
            if (!SessionHelper::isLoggedIn()) {
                header('Location: /account/login');
                return;
            }
            include 'app/views/product/orderConfirmation.php';
        }

        public function list() {
            $products = $this->productModel->getProducts();
            require_once 'app/views/product/list.php';
        }

}
?>