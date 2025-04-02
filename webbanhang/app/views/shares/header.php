<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Cải thiện navbar */
        .navbar {
            background-color: #007bff;
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: #0056b3 !important;
        }

        /* Thêm padding cho container */
        .container {
            max-width: 1200px;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Tạo không gian thoáng đãng cho các phần tử */
        .nav-item {
            margin-right: 15px;
        }

        /* Nút Logout và Login đẹp hơn */
        .nav-link {
            font-size: 16px;
            font-weight: 600;
        }

        .nav-link:hover {
            color: #ffcc00 !important;
        }

        /* Hiệu ứng cho card và sản phẩm */
        .product-item {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .product-image {
            max-width: 120px;
            height: auto;
            border-radius: 5px;
        }

        .product-title {
            font-size: 18px;
            font-weight: 600;
        }

        /* Các nút */
        .btn-primary, .btn-secondary {
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/Product/">Danh sách sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Product/add">Thêm sản phẩm</a>
                </li>
                <li class="nav-item" id="nav-login">
                    <a class="nav-link" href="/account/login">Login</a>
                </li>
                <li class="nav-item" id="nav-logout" style="display: none;">
                    <a class="nav-link" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>


    <script>
        function logout() {
            localStorage.removeItem('jwtToken');
            location.href = '/account/login';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem('jwtToken');
            if (token) {
                document.getElementById('nav-login').style.display = 'none';
                document.getElementById('nav-logout').style.display = 'block';
            } else {
                document.getElementById('nav-login').style.display = 'block';
                document.getElementById('nav-logout').style.display = 'none';
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
