<?php

namespace Controllers;

use Core\Auth;
use Models\SettingsModel;

class CMSSettingController extends BaseController
{
    private $settingsModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
    }

    /**
     * Show settings page
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        // Get all settings grouped by category
        $settingsGrouped = $this->settingsModel->getAllGrouped();

        // Check for flash messages
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        $this->view('admin/settings/index', [
            'settingsGrouped' => $settingsGrouped,
            'success' => $success,
            'error' => $error
        ]);
    }

    /**
     * Update settings
     */
    public function update()
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(ADMIN_URL . '/settings', 'Invalid request method', 'error');
        }

        try {
            // Get all POST data except CSRF token
            $settings = $_POST;
            unset($settings['csrf_token']);

            // Handle image uploads for banner images and other images
            $imageFields = [
                'site_logo',
                'about_banner',
                'banner_1_image',
                'banner_2_image',
                'banner_3_image'
            ];

            foreach ($imageFields as $field) {
                $fileKey = 'file_' . $field;

                // Check if file was uploaded
                if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = $this->handleImageUpload($_FILES[$fileKey], $field);

                    if ($uploadResult['success']) {
                        // Update settings with new image path
                        $settings[$field] = $uploadResult['path'];
                    } else {
                        $this->redirectWithMessage(ADMIN_URL . '/settings', 'Lỗi upload ảnh: ' . $uploadResult['error'], 'error');
                    }
                }
            }

            // Update all settings
            $result = $this->settingsModel->updateMultiple($settings);

            if ($result) {
                $this->redirectWithMessage(ADMIN_URL . '/settings', 'Đã cập nhật cài đặt thành công!', 'success');
            } else {
                $this->redirectWithMessage(ADMIN_URL . '/settings', 'Có lỗi xảy ra khi cập nhật cài đặt', 'error');
            }
        } catch (\Exception $e) {
            $this->redirectWithMessage(ADMIN_URL . '/settings', 'Lỗi: ' . $e->getMessage(), 'error');
        }
    }

    /**
     * Handle image upload for settings
     */
    private function handleImageUpload($file, $settingKey)
    {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['success' => false, 'error' => 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)'];
        }

        // Validate file size (max 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB
        if ($file['size'] > $maxSize) {
            return ['success' => false, 'error' => 'Kích thước file không được vượt quá 5MB'];
        }

        // Determine upload directory based on setting key
        if (strpos($settingKey, 'banner') !== false) {
            $uploadDir = PATH_ROOT . '/public/images/banners/';
            $urlPath = '/public/images/banners/';
        } else {
            $uploadDir = PATH_ROOT . '/public/images/';
            $urlPath = '/public/images/';
        }

        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $settingKey . '_' . time() . '.' . $extension;
        $uploadPath = $uploadDir . $filename;

        // Delete old image if exists
        $oldImage = $this->settingsModel->get($settingKey);
        if ($oldImage && !empty($oldImage['setting_value'])) {
            $oldImagePath = PATH_ROOT . $oldImage['setting_value'];
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => true, 'path' => $urlPath . $filename];
        } else {
            return ['success' => false, 'error' => 'Không thể upload file'];
        }
    }
}
