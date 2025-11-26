<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <div class="text-center py-5">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
            <h2 class="mt-4">Đặt hàng thành công!</h2>
            <p class="lead">Cảm ơn bạn đã mua hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất.</p>
            <div class="mt-4">
                <a href="<?php echo BASE_URL; ?>/my-orders" class="btn btn-primary me-2">Xem đơn hàng</a>
                <a href="<?php echo BASE_URL; ?>/products" class="btn btn-outline-primary">Tiếp tục mua hàng</a>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
