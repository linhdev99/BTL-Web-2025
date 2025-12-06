<?php

namespace Models;

class OrderModel extends BaseModel
{
    protected string $table = 'orders';

    /**
     * Get all orders with pagination
     */
    public function getAllOrders($page = 1, $perPage = 20, $status = null)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where = [];

        if ($status) {
            $where[] = "o.status = :status";
            $params['status'] = $status;
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        // Get orders (customer info is already in orders table)
        $sql = "SELECT o.*
                FROM {$this->table} o
                {$whereClause}
                ORDER BY o.created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $orders = $this->getAll($sql, $params);

        // Get total count
        $totalSql = "SELECT COUNT(*) as total FROM {$this->table} o {$whereClause}";
        $totalResult = $this->getOne($totalSql, $params);
        $total = $totalResult['total'];

        return [
            'orders' => $orders,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }

    /**
     * Get order by ID with details
     */
    public function getOrderById($id)
    {
        $sql = "SELECT o.*
                FROM {$this->table} o
                WHERE o.id = :id
                LIMIT 1";

        return $this->getOne($sql, ['id' => $id]);
    }

    /**
     * Get order items
     */
    public function getOrderItems($orderId)
    {
        $sql = "SELECT oi.*, p.name as product_name, p.image as product_image
                FROM order_items oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";

        return $this->getAll($sql, ['order_id' => $orderId]);
    }

    /**
     * Update order status
     * @param int $id Order ID
     * @param string $status New status
     * @param bool $skipValidation Skip status transition validation (for admin override)
     */
    public function updateStatus($id, $status, $skipValidation = false)
    {
        try {
            // Get current order status
            $order = $this->getOrderById($id);
            if (!$order) {
                throw new \Exception("Đơn hàng không tồn tại");
            }

            $oldStatus = $order['status'];

            // Validate status transition (unless skipped by admin)
            if (!$skipValidation) {
                $this->validateStatusTransition($oldStatus, $status);
            }

            // Begin transaction
            $this->db->beginTransaction();

            // Update order status
            $result = $this->update(
                $this->table,
                ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')],
                'id = :id',
                ['id' => $id]
            );

            // If cancelling order, restore stock
            if ($status === 'cancelled' && $oldStatus !== 'cancelled') {
                $this->restoreStock($id);
            }

            $this->db->commit();
            return $result;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Validate status transition
     */
    private function validateStatusTransition($oldStatus, $newStatus)
    {
        $allowedTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => []
        ];

        if (!isset($allowedTransitions[$oldStatus])) {
            throw new \Exception("Trạng thái hiện tại không hợp lệ");
        }

        if (!in_array($newStatus, $allowedTransitions[$oldStatus])) {
            throw new \Exception("Không thể chuyển từ trạng thái '{$oldStatus}' sang '{$newStatus}'");
        }
    }

    /**
     * Restore stock when order is cancelled
     */
    private function restoreStock($orderId)
    {
        $items = $this->getOrderItems($orderId);

        foreach ($items as $item) {
            if ($item['product_id']) {
                $sql = "UPDATE products SET stock = stock + :quantity WHERE id = :product_id";
                $this->execute($sql, [
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id']
                ]);
            }
        }
    }

    /**
     * Create new order
     */
    public function createOrder($orderData, $orderItems)
    {
        try {
            // Begin transaction
            $this->db->beginTransaction();

            // Generate unique order code
            $orderCode = $this->generateOrderCode();

            // Insert order
            $sql = "INSERT INTO {$this->table}
                    (user_id, order_code, customer_name, customer_email, customer_phone, customer_address,
                     total_amount, status, payment_method, payment_status, note, created_at, updated_at)
                    VALUES
                    (:user_id, :order_code, :customer_name, :customer_email, :customer_phone, :customer_address,
                     :total_amount, :status, :payment_method, :payment_status, :note, NOW(), NOW())";

            $this->execute($sql, [
                'user_id' => $orderData['user_id'] ?? null,
                'order_code' => $orderCode,
                'customer_name' => $orderData['customer_name'],
                'customer_email' => $orderData['customer_email'],
                'customer_phone' => $orderData['customer_phone'],
                'customer_address' => $orderData['customer_address'],
                'total_amount' => $orderData['total_amount'],
                'status' => $orderData['status'] ?? 'pending',
                'payment_method' => $orderData['payment_method'] ?? 'cod',
                'payment_status' => $orderData['payment_status'] ?? 'pending',
                'note' => $orderData['note'] ?? null
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert order items and update stock
            $itemSql = "INSERT INTO order_items
                        (order_id, product_id, product_name, price, quantity, total)
                        VALUES
                        (:order_id, :product_id, :product_name, :price, :quantity, :total)";

            foreach ($orderItems as $item) {
                // Lock product row and check stock
                $stockCheckSql = "SELECT id, stock FROM products WHERE id = :product_id FOR UPDATE";
                $product = $this->getOne($stockCheckSql, ['product_id' => $item['product_id']]);

                if (!$product) {
                    throw new \Exception("Sản phẩm ID {$item['product_id']} không tồn tại");
                }

                if ($product['stock'] < $item['quantity']) {
                    throw new \Exception("Sản phẩm '{$item['product_name']}' không đủ hàng trong kho");
                }

                // Insert order item
                $this->execute($itemSql, [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total']
                ]);

                // Decrease stock
                $updateStockSql = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
                $this->execute($updateStockSql, [
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id']
                ]);
            }

            // Commit transaction
            $this->db->commit();

            return $orderId;
        } catch (\Exception $e) {
            // Rollback on error
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Generate unique order code
     */
    private function generateOrderCode()
    {
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        return "ORD-{$date}-{$random}";
    }

    /**
     * Get orders by user ID
     */
    public function getOrdersByUserId($userId, $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $orders = $this->getAll($sql, ['user_id' => $userId]);

        // Get total count
        $totalSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = :user_id";
        $totalResult = $this->getOne($totalSql, ['user_id' => $userId]);
        $total = $totalResult['total'];

        return [
            'orders' => $orders,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($id, $paymentStatus)
    {
        return $this->update(
            $this->table,
            ['payment_status' => $paymentStatus, 'updated_at' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $id]
        );
    }

    /**
     * Get order statistics
     */
    public function getStats()
    {
        $sql = "SELECT
                    COUNT(*) as total_orders,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'processing' THEN 1 ELSE 0 END) as processing,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
                FROM {$this->table}";

        return $this->getOne($sql);
    }

    /**
     * Get sales statistics
     * Revenue is only counted for completed and paid orders
     */
    public function getSalesStats($startDate = null, $endDate = null)
    {
        $params = [];
        // Only count revenue from completed and paid orders
        $whereClause = "WHERE status = 'completed' AND payment_status = 'paid'";

        if ($startDate) {
            $whereClause .= " AND DATE(created_at) >= :start_date";
            $params['start_date'] = $startDate;
        }

        if ($endDate) {
            $whereClause .= " AND DATE(created_at) <= :end_date";
            $params['end_date'] = $endDate;
        }

        $sql = "SELECT
                    COUNT(*) as total_orders,
                    COALESCE(SUM(total_amount), 0) as total_revenue,
                    COALESCE(AVG(total_amount), 0) as avg_order_value
                FROM {$this->table}
                {$whereClause}";

        return $this->getOne($sql, $params);
    }

    /**
     * Get revenue by date range
     * Only count completed and paid orders
     */
    public function getRevenueByDateRange($days = 7)
    {
        $sql = "SELECT
                    DATE(created_at) as date,
                    COUNT(*) as orders,
                    SUM(total_amount) as revenue
                FROM {$this->table}
                WHERE DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
                    AND status = 'completed'
                    AND payment_status = 'paid'
                GROUP BY DATE(created_at)
                ORDER BY date ASC";

        return $this->getAll($sql, ['days' => $days]);
    }

    /**
     * Search orders by customer info or order code
     */
    public function searchOrders($search, $page = 1, $perPage = 20)
    {
        $offset = ($page - 1) * $perPage;
        $searchTerm = '%' . $search . '%';

        $sql = "SELECT *
                FROM {$this->table}
                WHERE order_code LIKE :search
                    OR customer_name LIKE :search
                    OR customer_email LIKE :search
                    OR customer_phone LIKE :search
                ORDER BY created_at DESC
                LIMIT {$perPage} OFFSET {$offset}";

        $orders = $this->getAll($sql, ['search' => $searchTerm]);

        $totalSql = "SELECT COUNT(*) as total
                     FROM {$this->table}
                     WHERE order_code LIKE :search
                        OR customer_name LIKE :search
                        OR customer_email LIKE :search
                        OR customer_phone LIKE :search";
        $totalResult = $this->getOne($totalSql, ['search' => $searchTerm]);
        $total = $totalResult['total'];

        return [
            'orders' => $orders,
            'pagination' => [
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'total_pages' => ceil($total / $perPage)
            ]
        ];
    }
}
