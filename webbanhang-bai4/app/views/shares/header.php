<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng Apple</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .nav-link {
        display: flex;
        align-items: center;
        line-height: 1.5; /* Điều chỉnh chiều cao dòng */
    }
    .custom-title-color {
        color: #FF5733; 
        font-size: 24px;
        font-weight: bold; 
    }
    .custom-link-color:hover {
        color: #28a745; 
    }
    .navbar-nav {
        display: flex;
        justify-content: flex-end; 
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .user-name {
        padding: 5px 20px;
        border: 2px solid #007bff;
        border-radius: 20px;
        color: #007bff;
        font-weight: bold;
        text-decoration: none;
        min-width: 100px;
        display: inline-flex;
        justify-content: center;    
    }
    .user-name:hover {
        background-color: #007bff;
        color: #fff;
    }
    .user-name i {
        margin-right: 8px; /* Tăng khoảng cách giữa icon và tên */
    }
    .user-name::after {
        display: none !important;
    }
    .cart-icon {
        color: #ffd700; /* Vàng đậm hơn */
        margin-right: 5px;
        font-size: 1.2rem;
        margin-right: 8px;
    }
</style>
<body>
    <?php require_once 'app/helpers/SessionHelper.php'; // Đảm bảo include SessionHelper ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto"> <!-- Các mục bên trái -->
                <li class="nav-item">
                    <a class="nav-link" href="/Product/">Danh sách sản phẩm</a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Product/add">Thêm sản phẩm</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto"> <!-- Các mục bên phải -->
                <li class="nav-item">
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Product/cart"><i class="bi bi-cart cart-icon"></i>Giỏ hàng</a>
                        </li>
                    <?php endif; ?>
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <div class="dropdown">
                            <a class="nav-link user-name " href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-person-fill me-1"></i>
                                <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/account/logout">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="nav-link" href="/account/login">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>