<?php

namespace Controllers;

use Core\Auth;

class CMSSettingController extends BaseController
{
    /**
     * Show settings page - redirect to old admin
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        // Settings management is complex, use old admin for now
        header('Location: ' . BASE_URL . '/admin/settings.php');
        exit;
    }

    /**
     * Update settings
     */
    public function update()
    {
        Auth::requireAdminOrStaff();

        // TODO: Update settings
        $this->redirectWithMessage(ADMIN_URL . '/settings', 'Đã cập nhật cài đặt', 'success');
    }
}
