<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>
<section class="section">
    <div class="container">
        <h2 class="mb-4">Liên hệ</h2>
        <div class="row">
            <div class="col-md-6">
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo escape($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo BASE_URL; ?>/contact">
                    <div class="mb-3">
                        <label class="form-label">Họ tên *</label>
                        <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? escape($name) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? escape($email) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" name="phone" value="<?php echo isset($phone) ? escape($phone) : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề *</label>
                        <input type="text" class="form-control" name="subject" value="<?php echo isset($subject) ? escape($subject) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung *</label>
                        <textarea class="form-control" name="message" rows="5" required><?php echo isset($message) ? escape($message) : ''; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                </form>
            </div>
            <div class="col-md-6">
                <h4>Thông tin liên hệ</h4>
                <p><i class="bi bi-geo-alt"></i> Địa chỉ: <?= getContactAddress() ?></p>
                <p><i class="bi bi-telephone"></i> Điện thoại: <?= getContactPhone() ?></p>
                <?php if (getContactHotline()): ?>
                <p><i class="bi bi-headset"></i> Hotline: <?= getContactHotline() ?></p>
                <?php endif; ?>
                <p><i class="bi bi-envelope"></i> Email: <?= getContactEmail() ?></p>
                <?php if (getWorkingHours()): ?>
                <p><i class="bi bi-clock"></i> Giờ làm việc:<br><?= nl2br(escape(getWorkingHours())) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>
