    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>Toy Model Shop</h3>
                    <p>Cửa hàng mô hình đồ chơi chất lượng cao, chính hãng với giá tốt nhất thị trường.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook" style="font-size: 24px;"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram" style="font-size: 24px;"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-youtube" style="font-size: 24px;"></i></a>
                    </div>
                </div>

                <div class="col-md-4">
                    <h3>Liên kết nhanh</h3>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>" class="text-white-50">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about" class="text-white-50">Giới thiệu</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/products" class="text-white-50">Sản phẩm</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/news" class="text-white-50">Tin tức</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/faq" class="text-white-50">Hỏi đáp</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact" class="text-white-50">Liên hệ</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h3>Thông tin liên hệ</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-geo-alt"></i> 123 Đường ABC, Quận XYZ, TP.HCM
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-telephone"></i> 0123-456-789
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-envelope"></i> contact@toyshop.com
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-clock"></i> Thứ 2 - Chủ Nhật: 8:00 - 22:00
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary mt-4 mb-3">

            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-white-50 mb-0">
                        &copy; <?php echo date('Y'); ?> Toy Model Shop. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php if (isset($additionalJS)): ?>
        <?php echo $additionalJS; ?>
    <?php endif; ?>

    <script>
        // Auto dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>
