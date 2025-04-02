<?php include 'app/views/shares/header.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container mt-5">
    <div class="card shadow-lg border-light">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body">
            <?php if ($product): ?>
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="product-image">
                            <?php if ($product->image): ?>
                                <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                     class="img-fluid rounded shadow-sm" 
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                            <?php else: ?>
                                <img src="/images/no-image.png" class="img-fluid rounded shadow-sm" alt="Không có ảnh">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="card-title text-dark font-weight-bold mb-3">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </h3>
                        <p class="card-text mb-3">
                            <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                        </p>
                        <p class="text-danger font-weight-bold h4 mb-4">
                            💰 <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                        </p>
                        <p><strong>Danh mục:</strong>
                            <span class="badge bg-info text-white">
                                <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                            </span>
                        </p>
                        <div class="mt-4">
                        <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary flex-shrink-0">
                                <i class="bi bi-cart me-1"></i> Thêm vào giỏ hàng
                        </a>
                            <a href="/Product/list" class="btn btn-secondary px-4 ml-2">Quay lại danh sách</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center">
                    <h4>Không tìm thấy sản phẩm!</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
