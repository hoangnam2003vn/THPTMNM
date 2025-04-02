<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h1 class="mb-4">Thêm sản phẩm mới</h1>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="card shadow-sm p-4 w-75 mx-auto">
        <form method="POST" action="/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
            
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>
            
            
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>
            
            
                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>">
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh:</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>
        
            
            <button type="submit" class="btn btn-primary w-100">Thêm sản phẩm</button>
        </form>
    </div>
    
    <a href="/Product/list" class="btn btn-secondary mt-3">Quay lại danh sách sản phẩm</a>
</div>
<?php include 'app/views/shares/footer.php'; ?>