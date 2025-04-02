<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Giỏ hàng</h1>

    <?php if (!empty($cart)): ?>
        <div class="card shadow-lg border-light">
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($cart as $id => $item): ?>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="row w-100">
                                <!-- Product Image -->
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <?php if ($item['image']): ?>
                                        <img src="/<?php echo $item['image']; ?>" alt="Product Image" class="img-fluid rounded shadow-sm" style="max-width: 120px;">
                                    <?php else: ?>
                                        <img src="/images/no-image.png" alt="No Image" class="img-fluid rounded shadow-sm" style="max-width: 120px;">
                                    <?php endif; ?>
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-6">
                                    <h5 class="mb-2"><?php echo htmlspecialchars($item['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h5>

                                    <p class="text-muted mb-1">Giá: <?php echo is_numeric($item['price']) ? number_format($item['price'], 0, ',', '.') : '0'; ?> VND</p>
                                    
                                    <!-- Quantity Update Form -->
                                    <div class="d-flex align-items-center">
                                        <a href="/Product/updateCart/<?php echo $id; ?>?action=decrease" class="btn btn-outline-secondary btn-sm">-</a>
                                        <span class="mx-2"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <a href="/Product/updateCart/<?php echo $id; ?>?action=increase" class="btn btn-outline-secondary btn-sm">+</a>
                                    </div>
                                </div>

                                <!-- Remove Button -->
                                <div class="col-md-3 text-center">
                                    <a href="/Product/remove/<?php echo $id; ?>" class="btn btn-danger btn-sm mb-2" onclick= "return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="total-amount">
                    <h3>Tổng tiền: 
                        <?php echo number_format($totalAmount, 0, ',', '.'); ?> VND
                    </h3>
                </div>
                <div class="mt-4">
                    <a href="/Product" class="btn btn-primary px-4">Tiếp tục mua sắm</a>
                    <a href="/Product/checkout" class="btn btn-success px-4 ml-2">Thanh Toán</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-4">
            <h4>Giỏ hàng của bạn đang trống!</h4>
        </div>
        <div class="text-center">
            <a href="/Product" class="btn btn-primary mt-3">Quay lại cửa hàng</a>
        </div>
    <?php endif; ?>
    <?php
        foreach ($cart as $id => $item): 
            if (!is_array($item)) continue; // Đảm bảo $item là mảng trước khi truy cập
    ?>
    <!-- Tiếp tục xử lý phần tử $item -->
<?php endforeach; ?>

</div>

<?php include 'app/views/shares/footer.php'; ?>
