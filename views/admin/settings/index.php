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

<form method="POST" action="<?php echo ADMIN_URL; ?>/settings/update" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">

    <?php
    $groupTitles = [
        'general' => 'Cài đặt chung',
        'contact' => 'Thông tin liên hệ',
        'about' => 'Trang giới thiệu',
        'social' => 'Mạng xã hội',
        'banner' => 'Quản lý Banner trang chủ'
    ];

    foreach ($settingsGrouped as $group => $settings):
        $groupTitle = $groupTitles[$group] ?? ucfirst($group);
    ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><?php echo escape($groupTitle); ?></h3>
            </div>
            <div class="card-body">
                <?php
                // Special handling for banner group - group by banner number
                if ($group === 'banner'):
                    // Group settings by banner (1, 2, 3)
                    $bannerGroups = [];
                    foreach ($settings as $setting) {
                        preg_match('/banner_(\d+)_/', $setting['setting_key'], $matches);
                        if ($matches) {
                            $bannerNum = $matches[1];
                            $bannerGroups[$bannerNum][] = $setting;
                        }
                    }

                    foreach ($bannerGroups as $bannerNum => $bannerSettings):
                ?>
                    <div class="border rounded p-3 mb-3 bg-light">
                        <h4 class="text-primary mb-3">
                            <i class="ti ti-photo"></i> Banner <?php echo $bannerNum; ?>
                        </h4>
                        <div class="row">
                            <?php foreach ($bannerSettings as $setting): ?>
                                <div class="col-md-<?php echo strpos($setting['setting_key'], '_image') !== false ? '12' : '6'; ?> mb-3">
                                    <label class="form-label fw-bold" for="<?php echo escape($setting['setting_key']); ?>">
                                        <?php echo escape($setting['description'] ?? $setting['setting_key']); ?>
                                    </label>

                                    <?php if ($setting['setting_type'] === 'textarea'): ?>
                                        <textarea
                                            class="form-control"
                                            id="<?php echo escape($setting['setting_key']); ?>"
                                            name="<?php echo escape($setting['setting_key']); ?>"
                                            rows="2"
                                            placeholder="Nhập mô tả cho banner"
                                        ><?php echo escape($setting['setting_value']); ?></textarea>

                                    <?php elseif ($setting['setting_type'] === 'image'): ?>
                                        <div class="mb-2">
                                            <input
                                                type="file"
                                                class="form-control mb-2"
                                                id="file_<?php echo escape($setting['setting_key']); ?>"
                                                name="file_<?php echo escape($setting['setting_key']); ?>"
                                                accept="image/*"
                                                onchange="previewImage(this, 'preview_<?php echo escape($setting['setting_key']); ?>')"
                                            >
                                            <small class="form-hint d-block mb-2">Hoặc nhập URL ảnh:</small>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="<?php echo escape($setting['setting_key']); ?>"
                                                name="<?php echo escape($setting['setting_key']); ?>"
                                                value="<?php echo escape($setting['setting_value']); ?>"
                                                placeholder="https://example.com/image.jpg"
                                            >
                                        </div>
                                        <?php if ($setting['setting_value']): ?>
                                            <img
                                                id="preview_<?php echo escape($setting['setting_key']); ?>"
                                                src="<?php echo escape($setting['setting_value']); ?>"
                                                alt="Preview"
                                                class="img-thumbnail d-block"
                                                style="max-width: 100%; max-height: 200px;">
                                        <?php else: ?>
                                            <img
                                                id="preview_<?php echo escape($setting['setting_key']); ?>"
                                                src=""
                                                alt="Preview"
                                                class="img-thumbnail d-none"
                                                style="max-width: 100%; max-height: 200px;">
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="<?php echo escape($setting['setting_key']); ?>"
                                            name="<?php echo escape($setting['setting_key']); ?>"
                                            value="<?php echo escape($setting['setting_value']); ?>"
                                            placeholder="<?php
                                                if (strpos($setting['setting_key'], 'link') !== false) echo '/products hoặc https://...';
                                                elseif (strpos($setting['setting_key'], 'button_text') !== false) echo 'Xem chi tiết';
                                                else echo 'Nhập nội dung';
                                            ?>"
                                        >
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php
                    endforeach;
                else:
                    // Normal settings display for other groups
                    foreach ($settings as $setting):
                ?>
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
                            <div class="mb-2">
                                <input
                                    type="file"
                                    class="form-control mb-2"
                                    id="file_<?php echo escape($setting['setting_key']); ?>"
                                    name="file_<?php echo escape($setting['setting_key']); ?>"
                                    accept="image/*"
                                    onchange="previewImage(this, 'preview_<?php echo escape($setting['setting_key']); ?>')"
                                >
                                <small class="form-hint d-block mb-2">Hoặc nhập đường dẫn ảnh:</small>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="<?php echo escape($setting['setting_key']); ?>"
                                    name="<?php echo escape($setting['setting_key']); ?>"
                                    value="<?php echo escape($setting['setting_value']); ?>"
                                    placeholder="/public/images/logo.png"
                                >
                            </div>
                            <?php if ($setting['setting_value']): ?>
                                <img
                                    id="preview_<?php echo escape($setting['setting_key']); ?>"
                                    src="<?php echo escape($setting['setting_value']); ?>"
                                    alt="Preview"
                                    class="img-thumbnail"
                                    style="max-width: 200px; max-height: 200px;">
                            <?php else: ?>
                                <img
                                    id="preview_<?php echo escape($setting['setting_key']); ?>"
                                    src=""
                                    alt="Preview"
                                    class="img-thumbnail d-none"
                                    style="max-width: 200px; max-height: 200px;">
                            <?php endif; ?>

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
                <?php
                    endforeach;
                endif;
                ?>
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

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            preview.classList.add('d-block');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include PATH_ROOT . '/views/admin/layouts/footer.php'; ?>
