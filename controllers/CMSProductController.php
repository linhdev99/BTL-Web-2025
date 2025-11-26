<?php

namespace Controllers;

use Core\Auth;
use Models\ProductModel;
use Models\CategoryModel;

class CMSProductController extends BaseController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * List all products
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = $_GET['search'] ?? '';

        $result = $this->productModel->getProductsForAdmin($page, ADMIN_ITEMS_PER_PAGE, $search);

        $this->view('admin/products/index', [
            'pageTitle' => 'Quản lý sản phẩm',
            'products' => $result['products'],
            'pagination' => $result['pagination'],
            'search' => $search
        ]);
    }

    /**
     * Show add product form
     */
    public function add()
    {
        Auth::requireAdminOrStaff();

        $categories = $this->categoryModel->getActiveCategories();

        $this->view('admin/products/add', [
            'pageTitle' => 'Thêm sản phẩm',
            'categories' => $categories
        ]);
    }

    /**
     * Store new product
     */
    public function store()
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Invalid request', 'error');
            return;
        }

        // Get form data
        $formData = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'sku' => trim($_POST['sku'] ?? ''),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'price' => (float)($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null,
            'stock' => (int)($_POST['stock'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0
        ];

        $errors = [];

        // Validation
        if (empty($formData['name'])) {
            $errors[] = 'Vui lòng nhập tên sản phẩm';
        }

        // SKU is optional, but if provided, must be unique
        if (!empty($formData['sku'])) {
            // Check SKU unique
            $existing = $this->productModel->getOne(
                "SELECT id FROM products WHERE sku = :sku",
                ['sku' => $formData['sku']]
            );
            if ($existing) {
                $errors[] = 'Mã SKU đã tồn tại';
            }
        }

        if (empty($formData['category_id'])) {
            $errors[] = 'Vui lòng chọn danh mục';
        }

        if ($formData['price'] <= 0) {
            $errors[] = 'Giá sản phẩm phải lớn hơn 0';
        }

        if ($formData['sale_price'] && $formData['sale_price'] >= $formData['price']) {
            $errors[] = 'Giá khuyến mãi phải nhỏ hơn giá gốc';
        }

        if ($formData['stock'] < 0) {
            $errors[] = 'Số lượng tồn kho không được âm';
        }

        // Auto generate slug if empty
        if (empty($formData['slug'])) {
            $formData['slug'] = generateSlug($formData['name']);
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadImage($_FILES['image'], 'products');
            if ($uploadResult['success']) {
                $formData['image'] = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $formData;
            header('Location: ' . BASE_URL . '/cms/products/add');
            exit;
        }

        // Insert product
        $success = $this->productModel->insert('products', $formData);

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Đã thêm sản phẩm thành công', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/products/add', 'Có lỗi xảy ra khi thêm sản phẩm', 'error');
        }
    }

    /**
     * Show edit product form
     */
    public function edit($id)
    {
        Auth::requireAdminOrStaff();

        $product = $this->productModel->getProductById($id);

        if (!$product) {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Sản phẩm không tồn tại', 'error');
            return;
        }

        $categories = $this->categoryModel->getActiveCategories();

        $this->view('admin/products/edit', [
            'pageTitle' => 'Sửa sản phẩm',
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Update product
     */
    public function update($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Invalid request', 'error');
            return;
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Sản phẩm không tồn tại', 'error');
            return;
        }

        // Get form data
        $formData = [
            'name' => trim($_POST['name'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'sku' => trim($_POST['sku'] ?? ''),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'price' => (float)($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null,
            'stock' => (int)($_POST['stock'] ?? 0),
            'description' => trim($_POST['description'] ?? ''),
            'content' => $_POST['content'] ?? '',
            'status' => $_POST['status'] ?? 'active',
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0
        ];

        $errors = [];

        // Validation
        if (empty($formData['name'])) {
            $errors[] = 'Vui lòng nhập tên sản phẩm';
        }

        // SKU is optional, but if provided, must be unique
        if (!empty($formData['sku'])) {
            // Check SKU unique (exclude current product)
            $existing = $this->productModel->getOne(
                "SELECT id FROM products WHERE sku = :sku AND id != :id",
                ['sku' => $formData['sku'], 'id' => $id]
            );
            if ($existing) {
                $errors[] = 'Mã SKU đã tồn tại';
            }
        }

        if (empty($formData['category_id'])) {
            $errors[] = 'Vui lòng chọn danh mục';
        }

        if ($formData['price'] <= 0) {
            $errors[] = 'Giá sản phẩm phải lớn hơn 0';
        }

        if ($formData['sale_price'] && $formData['sale_price'] >= $formData['price']) {
            $errors[] = 'Giá khuyến mãi phải nhỏ hơn giá gốc';
        }

        if ($formData['stock'] < 0) {
            $errors[] = 'Số lượng tồn kho không được âm';
        }

        // Auto generate slug if empty
        if (empty($formData['slug'])) {
            $formData['slug'] = generateSlug($formData['name']);
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = uploadImage($_FILES['image'], 'products');
            if ($uploadResult['success']) {
                // Delete old image if exists
                if (!empty($product['image']) && file_exists(PATH_ROOT . '/' . $product['image'])) {
                    unlink(PATH_ROOT . '/' . $product['image']);
                }
                $formData['image'] = $uploadResult['path'];
            } else {
                $errors[] = $uploadResult['message'];
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $formData;
            header('Location: ' . BASE_URL . '/cms/products/' . $id . '/edit');
            exit;
        }

        $formData['updated_at'] = date('Y-m-d H:i:s');

        // Update product
        $success = $this->productModel->update(
            'products',
            $formData,
            'id = :id',
            ['id' => $id]
        );

        if ($success) {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Đã cập nhật sản phẩm thành công', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/products/' . $id . '/edit', 'Có lỗi xảy ra khi cập nhật sản phẩm', 'error');
        }
    }

    /**
     * Delete product
     */
    public function delete($id)
    {
        Auth::requireAdminOrStaff();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Invalid request', 'error');
            return;
        }

        // Get product to delete image
        $product = $this->productModel->getProductById($id);

        $success = $this->productModel->delete('products', 'id = :id', ['id' => $id]);

        if ($success) {
            // Delete image file if exists
            if ($product && !empty($product['image']) && file_exists(PATH_ROOT . '/' . $product['image'])) {
                unlink(PATH_ROOT . '/' . $product['image']);
            }
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Đã xóa sản phẩm', 'success');
        } else {
            $this->redirectWithMessage(BASE_URL . '/cms/products', 'Có lỗi xảy ra', 'error');
        }
    }
}
