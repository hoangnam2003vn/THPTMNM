<?php include 'app/views/shares/header.php'; ?>
<div class="container my-4">
    <h1 class="text-center mb-4">Sửa sản phẩm</h1>
    <form id="edit-product-form" class="card shadow-sm p-4">
        <input type="hidden" id="id" name="id">
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-3">Lưu thay đổi</button>
    </form>
    <a href="/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
</div>

<!-- Thêm CSS vào đây -->
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 900px;
        margin-top: 50px;
    }

    h1 {
        color: #333;
        font-size: 32px;
        font-weight: bold;
    }

    .card {
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 30px;
    }

    .form-group label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    button.btn {
        font-size: 16px;
        padding: 12px;
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #4e555b;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .mt-2 {
        margin-top: 1rem;
    }

    .mt-3 {
        margin-top: 1.5rem;
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productId = <?= $editId ?>;
    fetch(`/api/product/${productId}`)
    .then(response => response.json())
    .then(data => {
        document.getElementById('id').value = data.id;
        document.getElementById('name').value = data.name;
        document.getElementById('description').value = data.description;
        document.getElementById('price').value = data.price;
        document.getElementById('category_id').value = data.category_id;
    });

    fetch('/api/category')
    .then(response => response.json())
    .then(data => {
        const categorySelect = document.getElementById('category_id');
        data.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    });

    document.getElementById('edit-product-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        fetch(`/api/product/${jsonData.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jsonData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product updated successfully') {
                location.href = '/Product';
            } else {
                alert('Cập nhật sản phẩm thất bại');
            }
        });
    });
});
</script>
