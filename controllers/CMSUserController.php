<?php

namespace Controllers;

use Models\UserModel;
use Core\Auth;

class CMSUserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * List all users
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        // For now, just get all users - pagination can be added later
        $users = $this->userModel->getAllUser();

        $this->view('admin/users/index', [
            'pageTitle' => 'Quản lý người dùng',
            'users' => $users
        ]);
    }

    /**
     * Show add user form
     */
    public function add()
    {
        Auth::requireAdminOrStaff();

        $this->view('admin/users/add', [
            'pageTitle' => 'Thêm người dùng'
        ]);
    }

    /**
     * Store new user
     */
    public function store()
    {
        Auth::requireAdminOrStaff();

        // TODO: Handle form submission
        $this->redirectWithMessage(ADMIN_URL . '/users', 'Đã thêm người dùng', 'success');
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        Auth::requireAdminOrStaff();

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->redirectWithMessage(ADMIN_URL . '/users', 'Người dùng không tồn tại', 'error');
            return;
        }

        $this->view('admin/users/edit', [
            'pageTitle' => 'Sửa người dùng',
            'user' => $user
        ]);
    }

    /**
     * Update user
     */
    public function update($id)
    {
        Auth::requireAdminOrStaff();

        // TODO: Handle form submission
        $this->redirectWithMessage(ADMIN_URL . '/users', 'Đã cập nhật người dùng', 'success');
    }

    /**
     * Delete user
     */
    public function delete($id)
    {
        Auth::requireAdminOrStaff();

        // Prevent deleting self
        if ($id == $_SESSION['user_id']) {
            $this->redirectWithMessage(ADMIN_URL . '/users', 'Không thể xóa chính mình', 'error');
            return;
        }

        $success = $this->userModel->delete('users', 'id = :id', ['id' => $id]);

        if ($success) {
            $this->redirectWithMessage(ADMIN_URL . '/users', 'Đã xóa người dùng', 'success');
        } else {
            $this->redirectWithMessage(ADMIN_URL . '/users', 'Có lỗi xảy ra', 'error');
        }
    }
}
