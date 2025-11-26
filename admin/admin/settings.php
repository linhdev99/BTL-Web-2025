<?php
require_once '../config/config.php';
require_once '../includes/functions.php';

$pageTitle = 'Cài đặt Website';

// Initialize model
$settingModel = new Setting();

$errors = [];
$success = false;

// Get all settings
$settings = $settingModel->getAllSettings();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $settingsToSave = [
        'site_name' => sanitize($_POST['site_name'] ?? ''),
        'site_description' => sanitize($_POST['site_description'] ?? ''),
        'site_email' => sanitize($_POST['site_email'] ?? ''),
        'site_phone' => sanitize($_POST['site_phone'] ?? ''),
        'site_address' => sanitize($_POST['site_address'] ?? ''),
        'facebook_url' => sanitize($_POST['facebook_url'] ?? ''),
        'instagram_url' => sanitize($_POST['instagram_url'] ?? ''),
        'youtube_url' => sanitize($_POST['youtube_url'] ?? ''),
    ];

    // Validation
    if (empty($settingsToSave['site_name'])) {
        $errors[] = 'Vui lòng nhập tên website';
    }

    if (!empty($settingsToSave['site_email']) && !isValidEmail($settingsToSave['site_email'])) {
        $errors[] = 'Email không hợp lệ';
    }

    if (!empty($settingsToSave['site_phone']) && !isValidPhone($settingsToSave['site_phone'])) {
        $errors[] = 'Số điện thoại không hợp lệ';
    }

    // Handle logo upload
    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['site_logo'], 'settings');
        if ($uploadResult['success']) {
            // Delete old logo if exists
            if (!empty($settings['site_logo']) && $settings['site_logo'] !== 'logo.png') {
                deleteImage('settings/' . $settings['site_logo']);
            }
            $settingsToSave['site_logo'] = $uploadResult['path'];
        } else {
            $errors[] = $uploadResult['message'];
        }
    }

    if (empty($errors)) {
        // Save all settings
        $allSuccess = true;
        foreach ($settingsToSave as $key => $value) {
            if (!$settingModel->saveSetting($key, $value)) {
                $allSuccess = false;
            }
        }

        if ($allSuccess) {
            $success = true;
            setFlashMessage('success', 'Cập nhật cài đặt thành công');
            // Reload settings
            $settings = $settingModel->getAllSettings();
        } else {
            $errors[] = 'Có lỗi xảy ra khi lưu cài đặt';
        }
    }
}

include 'layouts/header.php';
?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Cài đặt Website</h2>
            <div class="text-muted mt-1">Quản lý thông tin và cấu hình website</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <h4 class="alert-title">Có lỗi xảy ra!</h4>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo escape($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <h4 class="alert-title">Thành công!</h4>
                <p class="mb-0">Cài đặt đã được cập nhật.</p>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <!-- General Settings -->
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin chung</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Tên website</label>
                                <input type="text"
                                       class="form-control"
                                       name="site_name"
                                       value="<?php echo escape($settings['site_name'] ?? ''); ?>"
                                       required>
                                <small class="form-hint">Tên hiển thị của website</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mô tả website</label>
                                <textarea class="form-control"
                                          name="site_description"
                                          rows="3"><?php echo escape($settings['site_description'] ?? ''); ?></textarea>
                                <small class="form-hint">Mô tả ngắn về website (dùng cho SEO)</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email liên hệ</label>
                                    <input type="email"
                                           class="form-control"
                                           name="site_email"
                                           value="<?php echo escape($settings['site_email'] ?? ''); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text"
                                           class="form-control"
                                           name="site_phone"
                                           value="<?php echo escape($settings['site_phone'] ?? ''); ?>">
                                </div>
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Địa chỉ</label>
                                <textarea class="form-control"
                                          name="site_address"
                                          rows="2"><?php echo escape($settings['site_address'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Mạng xã hội</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="ti ti-brand-facebook text-primary"></i> Facebook URL
                                </label>
                                <input type="url"
                                       class="form-control"
                                       name="facebook_url"
                                       value="<?php echo escape($settings['facebook_url'] ?? ''); ?>"
                                       placeholder="https://facebook.com/your-page">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="ti ti-brand-instagram text-danger"></i> Instagram URL
                                </label>
                                <input type="url"
                                       class="form-control"
                                       name="instagram_url"
                                       value="<?php echo escape($settings['instagram_url'] ?? ''); ?>"
                                       placeholder="https://instagram.com/your-account">
                            </div>

                            <div class="mb-0">
                                <label class="form-label">
                                    <i class="ti ti-brand-youtube text-danger"></i> YouTube URL
                                </label>
                                <input type="url"
                                       class="form-control"
                                       name="youtube_url"
                                       value="<?php echo escape($settings['youtube_url'] ?? ''); ?>"
                                       placeholder="https://youtube.com/your-channel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logo & Images -->
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Logo Website</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if (!empty($settings['site_logo'])): ?>
                                    <img src="<?php echo getImageUrl($settings['site_logo']); ?>"
                                         alt="Current Logo"
                                         class="img-fluid rounded mb-2"
                                         style="max-height: 150px;">
                                <?php else: ?>
                                    <div class="bg-light p-4 rounded mb-2">
                                        <i class="ti ti-photo" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mt-2">Chưa có logo</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Upload logo mới</label>
                                <input type="file"
                                       class="form-control"
                                       name="site_logo"
                                       accept="image/*">
                                <small class="form-hint">PNG, JPG hoặc GIF (tối đa 5MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Preview -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin hiện tại</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-5">Tên web:</dt>
                                <dd class="col-7"><?php echo escape($settings['site_name'] ?? 'N/A'); ?></dd>

                                <dt class="col-5">Email:</dt>
                                <dd class="col-7"><?php echo escape($settings['site_email'] ?? 'N/A'); ?></dd>

                                <dt class="col-5">Điện thoại:</dt>
                                <dd class="col-7"><?php echo escape($settings['site_phone'] ?? 'N/A'); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-footer text-end">
                            <button type="submit" name="save_settings" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Lưu cài đặt
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
