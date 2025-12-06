<?php

namespace Controllers;

use Core\Auth;
use Models\OrderModel;

class CMSOrderController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    /**
     * List all orders
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = $_GET['status'] ?? null;
        $search = $_GET['search'] ?? null;

        if ($search) {
            $result = $this->orderModel->searchOrders($search, $page, ADMIN_ITEMS_PER_PAGE);
        } else {
            $result = $this->orderModel->getAllOrders($page, ADMIN_ITEMS_PER_PAGE, $status);
        }

        $this->view('admin/orders/index', [
            'pageTitle' => 'Quản lý đơn hàng',
            'orders' => $result['orders'],
            'pagination' => $result['pagination'],
            'currentStatus' => $status,
            'search' => $search
        ]);
    }

    /**
     * View order detail
     */
    public function viewOrder($id)
    {
        Auth::requireAdminOrStaff();

        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            $this->redirectWithMessage(BASE_URL . '/cms/orders', 'Đơn hàng không tồn tại', 'error');
            return;
        }

        $items = $this->orderModel->getOrderItems($id);

        $this->view('admin/orders/view', [
            'pageTitle' => 'Chi tiết đơn hàng #' . $id,
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/orders', 'Invalid request', 'error');
            return;
        }

        $status = $_POST['status'] ?? '';

        $allowedStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            $this->redirectWithMessage(BASE_URL . '/cms/orders', 'Trạng thái không hợp lệ', 'error');
            return;
        }

        try {
            // Admin can override status transition validation
            $this->orderModel->updateStatus($id, $status, true);
            $this->redirectWithMessage(BASE_URL . '/cms/orders/' . $id, 'Đã cập nhật trạng thái đơn hàng', 'success');
        } catch (\Exception $e) {
            $this->redirectWithMessage(BASE_URL . '/cms/orders/' . $id, $e->getMessage(), 'error');
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/orders', 'Invalid request', 'error');
            return;
        }

        $paymentStatus = $_POST['payment_status'] ?? '';

        $allowedStatuses = ['pending', 'paid', 'failed'];
        if (!in_array($paymentStatus, $allowedStatuses)) {
            $this->redirectWithMessage(BASE_URL . '/cms/orders', 'Trạng thái thanh toán không hợp lệ', 'error');
            return;
        }

        try {
            $this->orderModel->updatePaymentStatus($id, $paymentStatus);
            $this->redirectWithMessage(BASE_URL . '/cms/orders/' . $id, 'Đã cập nhật trạng thái thanh toán', 'success');
        } catch (\Exception $e) {
            $this->redirectWithMessage(BASE_URL . '/cms/orders/' . $id, 'Có lỗi xảy ra', 'error');
        }
    }
}
