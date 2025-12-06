<?php

namespace Controllers;

use Core\Auth;
use Models\ContactModel;

class CMSContactController extends BaseController
{
    private $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    /**
     * List all contacts
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = $_GET['status'] ?? null;

        $result = $this->contactModel->getAllContacts($page, ADMIN_ITEMS_PER_PAGE, $status);

        $this->view('admin/contacts/index', [
            'pageTitle' => 'Quản lý liên hệ',
            'contacts' => $result['contacts'],
            'pagination' => $result['pagination'],
            'currentStatus' => $status
        ]);
    }

    /**
     * View contact detail
     */
    public function viewContact($id)
    {
        Auth::requireAdminOrStaff();

        $contact = $this->contactModel->getContactById($id);

        if (!$contact) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Liên hệ không tồn tại', 'error');
            return;
        }

        // Mark as read if unread
        if (!$contact['is_read']) {
            $this->contactModel->markAsRead($id);
            $contact['is_read'] = 1; // Update local variable
        }

        $this->view('admin/contacts/view', [
            'pageTitle' => 'Chi tiết liên hệ',
            'contact' => $contact
        ]);
    }

    /**
     * Delete contact
     */
    public function delete($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Invalid request', 'error');
            return;
        }

        $success = $this->contactModel->delete('contacts', 'id = :id', ['id' => $id]);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Đã xóa liên hệ', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Có lỗi xảy ra', 'error');
        }
    }

    /**
     * Toggle read/unread status
     */
    public function toggleRead($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Invalid request', 'error');
            return;
        }

        $contact = $this->contactModel->getContactById($id);
        if (!$contact) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Liên hệ không tồn tại', 'error');
            return;
        }

        // Toggle status
        if ($contact['is_read']) {
            $this->contactModel->markAsUnread($id);
            $message = 'Đã đánh dấu chưa đọc';
        } else {
            $this->contactModel->markAsRead($id);
            $message = 'Đã đánh dấu đã đọc';
        }

        $this->redirectWithMessage(BASE_URL . '/cms/contacts', $message, 'success');
    }

    /**
     * Update contact status
     */
    public function updateStatus($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts', 'Invalid request', 'error');
            return;
        }

        $status = $_POST['status'] ?? '';
        $success = $this->contactModel->updateStatus($id, $status);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Đã cập nhật trạng thái', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Có lỗi xảy ra', 'error');
        }
    }

    /**
     * Add reply to contact
     */
    public function addReply($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Invalid request', 'error');
            return;
        }

        $reply = $_POST['admin_reply'] ?? '';

        if (empty($reply)) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Vui lòng nhập nội dung phản hồi', 'error');
            return;
        }

        $user = Auth::optionalUser();
        $success = $this->contactModel->addReply($id, $reply, $user['id']);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Đã thêm phản hồi', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/contacts/' . $id, 'Có lỗi xảy ra', 'error');
        }
    }
}
