<?php

namespace Controllers;

use Core\Auth;
use Models\ProductModel;
use Models\OrderModel;

class CartController extends BaseController
{
    private $productModel;
    private $orderModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->orderModel = new OrderModel();

        // Initialize cart session if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Show cart page
     */
    public function index()
    {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            // Fix N+1 query: Get all products in one query
            $productIds = array_keys($cart);
            $products = $this->productModel->getProductsByIds($productIds);

            // Index products by ID for fast lookup
            $productsById = [];
            foreach ($products as $product) {
                $productsById[$product['id']] = $product;
            }

            // Build cart items
            foreach ($cart as $productId => $quantity) {
                if (isset($productsById[$productId])) {
                    $product = $productsById[$productId];
                    $price = $product['sale_price'] ?: $product['price'];
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $price * $quantity
                    ];
                    $total += $price * $quantity;
                }
            }
        }

        $this->view('client/cart/index', [
            'pageTitle' => 'Giỏ hàng',
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Add to cart
     */
    public function add()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        // Validate product ID and quantity
        if ($productId <= 0) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không hợp lệ'], 400);
            return;
        }

        if ($quantity <= 0) {
            $this->json(['success' => false, 'message' => 'Số lượng phải lớn hơn 0'], 400);
            return;
        }

        // Max quantity per add to cart
        if ($quantity > 10) {
            $this->json(['success' => false, 'message' => 'Chỉ được mua tối đa 10 sản phẩm mỗi lần'], 400);
            return;
        }

        // Check if product exists
        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
            return;
        }

        // Calculate new quantity in cart
        $currentQuantity = $_SESSION['cart'][$productId] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        // Check stock availability
        if ($product['stock'] < $newQuantity) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không đủ số lượng trong kho (còn ' . $product['stock'] . ')'], 400);
            return;
        }

        // Max quantity per product in cart
        if ($newQuantity > 50) {
            $this->json(['success' => false, 'message' => 'Số lượng tối đa cho sản phẩm này là 50'], 400);
            return;
        }

        // Add to cart
        $_SESSION['cart'][$productId] = $newQuantity;

        $cartCount = array_sum($_SESSION['cart']);

        $this->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng',
            'cart_count' => $cartCount
        ]);
    }

    /**
     * Update cart
     */
    public function update()
    {
        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);

        if ($productId <= 0) {
            $this->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
            return;
        }

        if ($quantity <= 0) {
            // Remove from cart
            unset($_SESSION['cart'][$productId]);
            $this->json(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
            return;
        }

        // Validate max quantity
        if ($quantity > 50) {
            $this->json(['success' => false, 'message' => 'Số lượng tối đa cho sản phẩm này là 50'], 400);
            return;
        }

        // Check stock
        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không tồn tại'], 404);
            return;
        }

        if ($product['stock'] < $quantity) {
            $this->json(['success' => false, 'message' => 'Sản phẩm không đủ số lượng trong kho (còn ' . $product['stock'] . ')'], 400);
            return;
        }

        // Update quantity
        $_SESSION['cart'][$productId] = $quantity;

        $this->json(['success' => true, 'message' => 'Đã cập nhật giỏ hàng']);
    }

    /**
     * Remove from cart
     */
    public function remove()
    {
        $productId = (int)($_POST['product_id'] ?? 0);

        if ($productId <= 0) {
            $this->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ'], 400);
            return;
        }

        unset($_SESSION['cart'][$productId]);

        $this->json(['success' => true, 'message' => 'Đã xóa khỏi giỏ hàng']);
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        Auth::requireLogin();

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $this->redirectWithMessage(BASE_URL . '/cart', 'Giỏ hàng trống', 'warning');
            return;
        }

        $cartItems = [];
        $total = 0;

        // Fix N+1 query: Get all products in one query
        $productIds = array_keys($cart);
        $products = $this->productModel->getProductsByIds($productIds);

        // Index products by ID
        $productsById = [];
        foreach ($products as $product) {
            $productsById[$product['id']] = $product;
        }

        foreach ($cart as $productId => $quantity) {
            if (isset($productsById[$productId])) {
                $product = $productsById[$productId];
                $price = $product['sale_price'] ?: $product['price'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity
                ];
                $total += $price * $quantity;
            }
        }

        $this->view('client/cart/checkout', [
            'pageTitle' => 'Thanh toán',
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    /**
     * Process checkout
     */
    public function processCheckout()
    {
        Auth::requireLogin();

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $this->redirectWithMessage(BASE_URL . '/cart', 'Giỏ hàng trống', 'warning');
            return;
        }

        // Get form data
        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');
        $customerPhone = trim($_POST['customer_phone'] ?? '');
        $customerAddress = trim($_POST['customer_address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $shippingMethod = $_POST['shipping_method'] ?? 'standard';
        $notes = trim($_POST['notes'] ?? '');

        // Validate input
        $errors = [];
        if (empty($customerName)) $errors[] = 'Vui lòng nhập họ tên';
        if (empty($customerEmail)) $errors[] = 'Vui lòng nhập email';
        if (empty($customerPhone)) $errors[] = 'Vui lòng nhập số điện thoại';
        if (empty($customerAddress)) $errors[] = 'Vui lòng nhập địa chỉ';

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect(BASE_URL . '/checkout');
            return;
        }

        // Calculate total and prepare order items
        // Fix N+1 query: Get all products in one query
        $productIds = array_keys($cart);
        $products = $this->productModel->getProductsByIds($productIds);

        // Index products by ID
        $productsById = [];
        foreach ($products as $product) {
            $productsById[$product['id']] = $product;
        }

        $orderItems = [];
        $totalAmount = 0;

        foreach ($cart as $productId => $quantity) {
            if (isset($productsById[$productId])) {
                $product = $productsById[$productId];
                $price = $product['sale_price'] ?: $product['price'];
                $subtotal = $price * $quantity;

                $orderItems[] = [
                    'product_id' => $productId,
                    'product_name' => $product['name'],
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $subtotal
                ];

                $totalAmount += $subtotal;
            }
        }

        // Prepare order data
        $orderData = [
            'user_id' => getCurrentUserId(),
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
            'note' => $notes
        ];

        try {
            // Create order
            $orderId = $this->orderModel->createOrder($orderData, $orderItems);

            // Clear cart
            $_SESSION['cart'] = [];

            // Redirect to my orders page with success message
            $this->redirectWithMessage(
                BASE_URL . '/my-orders',
                'Đặt hàng thành công! Mã đơn hàng của bạn sẽ được hiển thị trong danh sách.',
                'success'
            );
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage();
            $this->redirect(BASE_URL . '/checkout');
        }
    }

    /**
     * Order success page
     */
    public function orderSuccess()
    {
        $this->view('client/cart/success', [
            'pageTitle' => 'Đặt hàng thành công'
        ]);
    }
}
