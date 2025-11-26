<?php

namespace Controllers;

use Core\Auth;
use Models\CategoryModel;

class CMSCategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    /**
     * List all categories
     */
    public function index()
    {
        Auth::requireAdminOrStaff();

        // Get all categories with product count
        $sql = "SELECT c.*, COUNT(p.id) as product_count
                FROM categories c
                LEFT JOIN products p ON c.id = p.category_id
                GROUP BY c.id
                ORDER BY c.name ASC";

        $categories = $this->categoryModel->getAll($sql);

        $pageTitle = 'Quản lý danh mục';
        $this->view('admin/categories/index', compact('pageTitle', 'categories'));
    }

    /**
     * Show add category form
     */
    public function add()
    {
        Auth::requireAdminOrStaff();

        // Store return_to parameter in session if provided
        if (isset($_GET['return_to'])) {
            $_SESSION['return_to'] = $_GET['return_to'];
        }

        $pageTitle = 'Thêm danh mục mới';
        $this->view('admin/categories/add', compact('pageTitle'));
    }

    /**
     * Store new category
     */
    public function store()
    {
        Auth::requireAdminOrStaff();

        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/categories');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $returnTo = trim($_POST['return_to'] ?? '');

        $errors = [];

        // Validation
        if (empty($name)) {
            $errors[] = 'Tên danh mục không được để trống';
        }

        // Auto-generate slug if empty
        if (empty($slug)) {
            $slug = $this->generateSlug($name);
        }

        // Check if slug exists
        if (!empty($slug)) {
            $existing = $this->categoryModel->getOne("SELECT id FROM categories WHERE slug = :slug", ['slug' => $slug]);
            if ($existing) {
                $slug = $slug . '-' . time();
            }
        }

        // If there are errors, return to form
        if (!empty($errors)) {
            $_SESSION['category_errors'] = $errors;
            $_SESSION['category_form_data'] = $_POST;

            if ($returnTo) {
                redirect('/cms/categories/add?return_to=' . urlencode($returnTo));
            } else {
                redirect('/cms/categories/add');
            }
            return;
        }

        // Insert category
        $categoryData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'is_active' => 1,
            'ordering' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            // insert() method returns lastInsertId directly
            $categoryId = $this->categoryModel->insert('categories', $categoryData);

            if ($categoryId) {
                $_SESSION['success'] = 'Đã thêm danh mục "' . $name . '" thành công';
                $_SESSION['new_category_id'] = $categoryId;

                // Redirect back to the page that initiated the add
                if ($returnTo) {
                    redirect('/cms/' . $returnTo);
                } else {
                    redirect('/cms/categories');
                }
            } else {
                $errors[] = 'Không thể thêm danh mục';
                $_SESSION['category_errors'] = $errors;
                $_SESSION['category_form_data'] = $_POST;

                if ($returnTo) {
                    redirect('/cms/categories/add?return_to=' . urlencode($returnTo));
                } else {
                    redirect('/cms/categories/add');
                }
            }
        } catch (\Exception $e) {
            $errors[] = 'Lỗi: ' . $e->getMessage();
            $_SESSION['category_errors'] = $errors;
            $_SESSION['category_form_data'] = $_POST;

            if ($returnTo) {
                redirect('/cms/categories/add?return_to=' . urlencode($returnTo));
            } else {
                redirect('/cms/categories/add');
            }
        }
    }

    /**
     * Show edit category form
     */
    public function edit($id)
    {
        Auth::requireAdminOrStaff();

        $category = $this->categoryModel->getById($id);

        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại';
            redirect('/cms/categories');
            return;
        }

        $pageTitle = 'Chỉnh sửa danh mục';
        $this->view('admin/categories/edit', compact('pageTitle', 'category'));
    }

    /**
     * Update category
     */
    public function update($id)
    {
        Auth::requireAdminOrStaff();

        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/categories');
            return;
        }

        $category = $this->categoryModel->getById($id);
        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại';
            redirect('/cms/categories');
            return;
        }

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        $errors = [];

        // Validation
        if (empty($name)) {
            $errors[] = 'Tên danh mục không được để trống';
        }

        // Auto-generate slug if empty
        if (empty($slug)) {
            $slug = $this->generateSlug($name);
        }

        // Check if slug exists (except current category)
        if (!empty($slug)) {
            $existing = $this->categoryModel->getOne(
                "SELECT id FROM categories WHERE slug = :slug AND id != :id",
                ['slug' => $slug, 'id' => $id]
            );
            if ($existing) {
                $slug = $slug . '-' . time();
            }
        }

        // If there are errors, return to form
        if (!empty($errors)) {
            $_SESSION['category_errors'] = $errors;
            $_SESSION['category_form_data'] = $_POST;
            redirect('/cms/categories/edit/' . $id);
            return;
        }

        // Update category
        $categoryData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'is_active' => $isActive,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $result = $this->categoryModel->update(
                'categories',
                $categoryData,
                'id = :id',
                ['id' => $id]
            );

            if ($result) {
                $_SESSION['success'] = 'Đã cập nhật danh mục "' . $name . '" thành công';
                redirect('/cms/categories');
            } else {
                $_SESSION['error'] = 'Không thể cập nhật danh mục';
                redirect('/cms/categories/edit/' . $id);
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            redirect('/cms/categories/edit/' . $id);
        }
    }

    /**
     * Delete category
     */
    public function delete($id)
    {
        Auth::requireAdminOrStaff();

        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('/cms/categories');
            return;
        }

        $category = $this->categoryModel->getById($id);
        if (!$category) {
            $_SESSION['error'] = 'Danh mục không tồn tại';
            redirect('/cms/categories');
            return;
        }

        try {
            // Check if category has products
            $productCount = $this->categoryModel->getOne(
                "SELECT COUNT(*) as count FROM products WHERE category_id = :id",
                ['id' => $id]
            );

            if ($productCount['count'] > 0) {
                // Set products' category_id to NULL instead of deleting category
                $this->categoryModel->execute(
                    "UPDATE products SET category_id = NULL WHERE category_id = :id",
                    ['id' => $id]
                );
            }

            // Delete category
            $result = $this->categoryModel->delete('categories', 'id = :id', ['id' => $id]);

            if ($result) {
                $_SESSION['success'] = 'Đã xóa danh mục "' . $category['name'] . '" thành công';
            } else {
                $_SESSION['error'] = 'Không thể xóa danh mục';
            }
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }

        redirect('/cms/categories');
    }
}
