<?php

namespace Controllers;

use Core\Auth;
use Models\OrderModel;
use Models\UserModel;

class UserController extends BaseController
{
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->userModel = new UserModel();
    }

    /**
     * User profile page
     */
    public function profile()
    {
        Auth::requireLogin();

        $userId = getCurrentUserId();
        $user = $this->userModel->getById($userId);

        $this->view('client/user/profile', [
            'pageTitle' => 'Thông tin tài khoản',
            'user' => $user
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        Auth::requireLogin();

        $userId = getCurrentUserId();
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($fullName)) {
            $_SESSION['error'] = 'Vui lòng nhập họ tên';
            $this->redirect(BASE_URL . '/profile');
            return;
        }

        $data = [
            'full_name' => $fullName,
            'phone' => $phone,
            'address' => $address
        ];

        if ($this->userModel->updateUser($userId, $data)) {
            $_SESSION['user']['full_name'] = $fullName;
            $_SESSION['user']['phone'] = $phone;
            $_SESSION['user']['address'] = $address;
            $_SESSION['success'] = 'Cập nhật thông tin thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật';
        }

        $this->redirect(BASE_URL . '/profile');
    }

    /**
     * My orders page
     */
    public function myOrders()
    {
        Auth::requireLogin();

        $userId = getCurrentUserId();
        $page = max(1, (int)($_GET['page'] ?? 1));

        $result = $this->orderModel->getOrdersByUserId($userId, $page, 10);

        $this->view('client/user/orders', [
            'pageTitle' => 'Đơn hàng của tôi',
            'orders' => $result['orders'],
            'pagination' => $result['pagination']
        ]);
    }

    /**
     * Order detail page
     */
    public function orderDetail($id)
    {
        Auth::requireLogin();

        $userId = getCurrentUserId();
        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            $this->redirectWithMessage(BASE_URL . '/my-orders', 'Đơn hàng không tồn tại', 'error');
            return;
        }

        // Check if order belongs to current user
        if ($order['user_id'] != $userId) {
            $this->redirectWithMessage(BASE_URL . '/my-orders', 'Bạn không có quyền xem đơn hàng này', 'error');
            return;
        }

        $items = $this->orderModel->getOrderItems($id);

        $this->view('client/user/order-detail', [
            'pageTitle' => 'Chi tiết đơn hàng #' . $id,
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * Cancel order
     */
    public function cancelOrder($id)
    {
        Auth::requireLogin();

        $userId = getCurrentUserId();
        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            $this->json(['success' => false, 'message' => 'Đơn hàng không tồn tại'], 404);
            return;
        }

        // Check if order belongs to current user
        if ($order['user_id'] != $userId) {
            $this->json(['success' => false, 'message' => 'Bạn không có quyền hủy đơn hàng này'], 403);
            return;
        }

        // Only allow cancel if order is pending
        if ($order['status'] != 'pending') {
            $this->json(['success' => false, 'message' => 'Chỉ có thể hủy đơn hàng đang chờ xử lý'], 400);
            return;
        }

        if ($this->orderModel->updateStatus($id, 'cancelled')) {
            $this->json(['success' => true, 'message' => 'Đã hủy đơn hàng thành công']);
        } else {
            $this->json(['success' => false, 'message' => 'Có lỗi xảy ra khi hủy đơn hàng'], 500);
        }
    }
}
