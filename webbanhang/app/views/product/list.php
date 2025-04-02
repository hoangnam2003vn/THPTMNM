<?php include 'app/views/shares/header.php'; ?>
<div class="container my-4">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>
    <a href="/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <div class="row" id="product-list">
        <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
    </div>
</div>

<!-- Thêm CSS vào đây -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 1200px;
    }

    h1 {
        color: #333;
        font-size: 36px;
        font-weight: bold;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .card {
        border-radius: 10px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 20px;
        color: #007bff;
    }

    .card-text {
        color: #6c757d;
    }

    .price, .category {
        color: #28a745;
        font-weight: bold;
    }

    .price {
        font-size: 18px;
    }

    .category {
        font-size: 16px;
    }

    .btn {
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-sm {
        padding: 5px 10px;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập');
        location.href = '/account/login'; // Điều hướng đến trang đăng nhập
        return;
    }
    fetch('/api/product', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token
        }
    })
    .then(response => response.json())
    .then(data => {
        const productList = document.getElementById('product-list');
        data.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'col-md-4 mb-4';
            productItem.innerHTML = `
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><a href="/Product/show/${product.id}" class="text-decoration-none">${product.name}</a></h5>
                        <p class="card-text">${product.description}</p>
                        <p class="price">Giá: ${product.price} VND</p>
                        <p class="category">Danh mục: ${product.category_name}</p>
                        <div class="d-flex justify-content-between">
                            <a href="/Product/edit/${product.id}" class="btn btn-warning btn-sm">Sửa</a>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">Xóa</button>
                        </div>
                    </div>
                </div>
            `;
            productList.appendChild(productItem);
        });
    });
});

function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/api/product/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        });
    }
}
</script>
