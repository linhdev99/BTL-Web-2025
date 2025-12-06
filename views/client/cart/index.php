<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>

<section class="section">
    <div class="container">
        <h2 class="mb-4">Giỏ hàng của bạn</h2>

        <?php if (!empty($cartItems)): ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $item): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo getImageUrl($item['product']['image'], 'product-placeholder.jpg'); ?>"
                                                             alt="<?php echo escape($item['product']['name']); ?>"
                                                             style="width: 60px; height: 60px; object-fit: cover;"
                                                             class="me-3">
                                                        <div>
                                                            <a href="<?php echo BASE_URL; ?>/product/<?php echo $item['product']['slug']; ?>"
                                                               class="text-decoration-none">
                                                                <?php echo escape($item['product']['name']); ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo formatPrice($item['product']['sale_price'] ?: $item['product']['price']); ?></td>
                                                <td>
                                                    <input type="number"
                                                           class="form-control form-control-sm quantity-input"
                                                           style="width: 80px;"
                                                           value="<?php echo $item['quantity']; ?>"
                                                           min="1"
                                                           max="50"
                                                           data-product-id="<?php echo $item['product']['id']; ?>"
                                                           data-price="<?php echo $item['product']['sale_price'] ?: $item['product']['price']; ?>">
                                                </td>
                                                <td class="fw-bold subtotal-<?php echo $item['product']['id']; ?>"><?php echo formatPrice($item['subtotal']); ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger" onclick="removeFromCart(<?php echo $item['product']['id']; ?>)">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tổng đơn hàng</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <span id="cart-subtotal"><?php echo formatPrice($total); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Tổng cộng:</strong>
                                <strong class="text-danger" id="cart-total"><?php echo formatPrice($total); ?></strong>
                            </div>
                            <a href="<?php echo BASE_URL; ?>/checkout" class="btn btn-primary w-100 mb-2">
                                Tiến hành thanh toán
                            </a>
                            <a href="<?php echo BASE_URL; ?>/products" class="btn btn-outline-secondary w-100">
                                Tiếp tục mua hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">Giỏ hàng trống</h4>
                <p class="text-muted">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="<?php echo BASE_URL; ?>/products" class="btn btn-primary">
                    Mua sắm ngay
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Format price function
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
}

// Update cart totals
function updateCartTotals() {
    let total = 0;
    document.querySelectorAll('.quantity-input').forEach(input => {
        const productId = input.dataset.productId;
        const price = parseFloat(input.dataset.price);
        const quantity = parseInt(input.value);
        const subtotal = price * quantity;

        // Update subtotal display
        const subtotalElement = document.querySelector(`.subtotal-${productId}`);
        if (subtotalElement) {
            subtotalElement.textContent = formatPrice(subtotal);
        }

        total += subtotal;
    });

    // Update total displays
    document.getElementById('cart-subtotal').textContent = formatPrice(total);
    document.getElementById('cart-total').textContent = formatPrice(total);
}

// Handle quantity change
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');

    quantityInputs.forEach(input => {
        let timeoutId;

        input.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value);

            if (quantity < 1) {
                this.value = 1;
                return;
            }

            if (quantity > 50) {
                alert('Số lượng tối đa cho sản phẩm này là 50');
                this.value = 50;
                return;
            }

            // Update UI immediately
            updateCartTotals();

            // Clear previous timeout
            clearTimeout(timeoutId);

            // Update cart on server after 500ms delay
            timeoutId = setTimeout(() => {
                updateCartQuantity(productId, quantity);
            }, 500);
        });

        // Also handle input event for real-time calculation
        input.addEventListener('input', function() {
            const quantity = parseInt(this.value);
            if (quantity >= 1 && quantity <= 50) {
                updateCartTotals();
            }
        });
    });
});

// Update cart quantity on server
function updateCartQuantity(productId, quantity) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);

    fetch('<?php echo BASE_URL; ?>/cart/update', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert(data.message);
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
    });
}

// Remove from cart
function removeFromCart(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch('<?php echo BASE_URL; ?>/cart/remove', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        });
    }
}
</script>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
