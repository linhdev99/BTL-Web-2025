<?php include PATH_ROOT . '/views/admin/layouts/header.php'; ?>

<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Cài đặt website</h2>
        </div>
    </div>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check"></i> <?php echo escape($success); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle"></i> <?php echo escape($error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo ADMIN_URL; ?>/settings/update">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

    <?php
    $groupTitles = [
        'general' => 'Cài đặt chung',
        'contact' => 'Thông tin liên hệ',
        'about' => 'Trang giới thiệu',
        'social' => 'Mạng xã hội'
    ];

    foreach ($settingsGrouped as $group => $settings):
        $groupTitle = $groupTitles[$group] ?? ucfirst($group);
    ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><?php echo escape($groupTitle); ?></h3>
            </div>
            <div class="card-body">
                <?php foreach ($settings as $setting): ?>
                    <div class="mb-3">
                        <label class="form-label" for="<?php echo escape($setting['setting_key']); ?>">
                            <?php echo escape($setting['description'] ?? $setting['setting_key']); ?>
                        </label>

                        <?php if ($setting['setting_type'] === 'textarea'): ?>
                            <textarea
                                class="form-control"
                                id="<?php echo escape($setting['setting_key']); ?>"
                                name="<?php echo escape($setting['setting_key']); ?>"
                                rows="<?php echo ($setting['setting_key'] === 'about_content') ? 10 : 4; ?>"
                            ><?php echo escape($setting['setting_value']); ?></textarea>
                            <?php if ($setting['setting_key'] === 'about_content'): ?>
                                <small class="form-hint">Hỗ trợ HTML. Sử dụng các thẻ như &lt;h3&gt;, &lt;p&gt;, &lt;h4&gt;, &lt;ul&gt;, &lt;li&gt; để định dạng nội dung.</small>
                            <?php endif; ?>

                        <?php elseif ($setting['setting_type'] === 'image'): ?>
                            <input
                                type="text"
                                class="form-control mb-2"
                                id="<?php echo escape($setting['setting_key']); ?>"
                                name="<?php echo escape($setting['setting_key']); ?>"
                                value="<?php echo escape($setting['setting_value']); ?>"
                                placeholder="/assets/img/logo.png"
                            >
                            <?php if ($setting['setting_value']): ?>
                                <img src="<?php echo BASE_URL . escape($setting['setting_value']); ?>"
                                     alt="Preview"
                                     class="img-thumbnail"
                                     style="max-width: 200px; max-height: 200px;">
                            <?php endif; ?>
                            <small class="form-hint">Nhập đường dẫn ảnh hoặc upload ảnh mới (tính năng upload sẽ được bổ sung)</small>

                        <?php else: ?>
                            <input
                                type="<?php echo $setting['setting_type'] === 'email' ? 'email' : ($setting['setting_type'] === 'url' ? 'url' : 'text'); ?>"
                                class="form-control"
                                id="<?php echo escape($setting['setting_key']); ?>"
                                name="<?php echo escape($setting['setting_key']); ?>"
                                value="<?php echo escape($setting['setting_value']); ?>"
                            >
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="card">
        <div class="card-footer text-end">
            <button type="reset" class="btn btn-secondary">
                <i class="ti ti-x"></i> Hủy thay đổi
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy"></i> Lưu cài đặt
            </button>
        </div>
    </div>
</form>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
