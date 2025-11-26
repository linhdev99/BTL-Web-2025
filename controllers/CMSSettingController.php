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
}
