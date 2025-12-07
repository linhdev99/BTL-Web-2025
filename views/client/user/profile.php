<?php include PATH_ROOT . '/app/views/layouts/header.php'; ?>

<section class="section py-5">
  <div class="container">
    <h2 class="text-center fw-bold text-primary mb-4">👤 Thông tin cá nhân</h2>

    <div class="row justify-content-center">
      <!-- CỘT AVATAR -->
      <div class="col-md-4 text-center mb-4">
        <div class="card shadow-sm p-4">
          <?php
          $avatar = !empty($data['avatar'])
            ? htmlspecialchars($data['avatar'])
            : 'https://i.pravatar.cc/100?u=' . urlencode($data['full_name']);
          ?>
          <div class="mb-3">
            <img src="<?= $avatar ?>" alt="Avatar" class="rounded-circle border shadow-sm"
              style="width: 180px; height: 180px; object-fit: cover;">
          </div>
          <p class="fw-semibold mb-1"><?= htmlspecialchars($data['full_name'] ?? '') ?></p>
          <p class="text-muted mb-0"><?= htmlspecialchars($data['email'] ?? '') ?></p>
          <p class="text-secondary small mt-2">
            <?php
            $role = $data['role'] ?? 'customer';
            echo ($role === 'admin')
              ? '👑 Quản trị viên'
              : (($role === 'staff') ? '🧑‍💼 Nhân viên' : '🙋 Khách hàng');
            ?>
          </p>
        </div>
      </div>

      <!-- CỘT FORM -->
      <div class="col-md-8">
        <div class="card shadow-sm p-4">
          <div class="card-body">
            <?php if (!empty($errors ?? [])): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars((string) $error) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <?php if (!empty($success_message ?? '')): ?>
              <div class="alert alert-success">
                ✅ <?= htmlspecialchars((string) $success_message) ?>
              </div>
            <?php endif; ?>

            <form method="POST" action="<?= htmlspecialchars(BASE_URL . '/profile') ?>">

              <!-- EMAIL (chỉ đọc) -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Email đăng nhập</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($data['email'] ?? '') ?>" readonly>
                <div class="form-text text-muted">
                  (Email dùng để đăng nhập, không thể thay đổi)
                </div>
              </div>

              <!-- USERNAME -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Tên người dùng</label>
                <input type="text" class="form-control" name="username"
                  value="<?= htmlspecialchars($data['username'] ?? '') ?>" placeholder="Nhập tên người dùng (tuỳ chọn)">
              </div>

              <!-- AVATAR -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Ảnh đại diện (URL)</label>
                <input type="url" class="form-control" name="avatar"
                  value="<?= htmlspecialchars($data['avatar'] ?? '') ?>" placeholder="https://example.com/avatar.jpg">
              </div>

              <!-- HỌ TÊN -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Họ và tên *</label>
                <input type="text" class="form-control" name="full_name"
                  value="<?= htmlspecialchars($data['full_name'] ?? '') ?>" required>
              </div>

              <!-- SỐ ĐIỆN THOẠI -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Số điện thoại</label>
                <input type="tel" class="form-control" name="phone"
                  value="<?= htmlspecialchars($data['phone'] ?? '') ?>" placeholder="Ví dụ: 0901234567">
              </div>

              <!-- ĐỊA CHỈ -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Địa chỉ</label>
                <textarea class="form-control" name="address" rows="3"
                  placeholder="Nhập địa chỉ của bạn..."><?= htmlspecialchars($data['address'] ?? '') ?></textarea>
              </div>

              <!-- NÚT CẬP NHẬT -->
              <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                  💾 Cập nhật thông tin
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include PATH_ROOT . '/app/views/layouts/footer.php'; ?>