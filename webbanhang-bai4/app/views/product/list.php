<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .custom-link-color {
        color: black; 
    }
</style>
<div class="container mt-4">
    <h1 class="mb-3">Danh sách sản phẩm</h1>
    <?php if (SessionHelper::isAdmin()): ?>
        <a href="/Product/add" class="btn btn-success mb-3">Thêm sản phẩm mới</a>
    <?php endif; ?>
    
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 rounded-lg shadow-sm">
                    <?php if ($product->image): ?>
                        <img src="/<?php echo $product->image; ?>" class="card-img-top mt-3 rounded-4" alt="Hình ảnh sản phẩm"
                            style="width: 300px; height: 300px; object-fit: cover; display: block; margin: 0 auto;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/Product/show/<?php echo $product->id; ?>" class="text-decoration-none custom-link-color">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <p class="card-text">
                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="fw-bold">Giá: <span class="text-danger" style="font-size: 20px; font-weight: bold;"><?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VND</span></p>
                        <p class="text-muted">Danh mục: <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-between gap-2" style="min-width: 0;">
                        <?php if (SessionHelper::isAdmin()): ?>
                            <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm flex-shrink-0">
                                <i class="bi bi-pencil-square me-1"></i> Sửa
                            </a>
                            <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm flex-shrink-0" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                <i class="bi bi-trash me-1"></i> Xóa
                            </a>
                        <?php endif; ?>
                        <?php if (SessionHelper::isLoggedIn()): ?>
                            <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm flex-shrink-0">
                                <i class="bi bi-cart me-1"></i> Thêm vào giỏ hàng
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>