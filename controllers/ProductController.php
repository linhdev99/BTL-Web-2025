<?php

namespace Controllers;

use Models\ProductModel;
use Models\CategoryModel;

class ProductController extends BaseController
{
    private ProductModel $productModel;
    private CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Display product listing page with filtering and pagination
     */
    public function index()
    {
        // Get filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $categoryParam = isset($_GET['category']) ? $_GET['category'] : null;
        $search = isset($_GET['search']) && trim($_GET['search']) !== '' ? trim($_GET['search']) : null;

        // Get current category info if filtered (support both ID and slug)
        $currentCategory = null;
        $categoryId = null;

        if ($categoryParam) {
            // Check if it's numeric ID or slug
            if (is_numeric($categoryParam)) {
                $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
                $currentCategory = $this->categoryModel->getOne($sql, ['id' => (int)$categoryParam]);
            } else {
                $sql = "SELECT * FROM categories WHERE slug = :slug LIMIT 1";
                $currentCategory = $this->categoryModel->getOne($sql, ['slug' => $categoryParam]);
            }

            if ($currentCategory) {
                $categoryId = $currentCategory['id'];
            }
        }

        // Get products with pagination
        $result = $this->productModel->getAllProducts($page, 12, $categoryId, $search);

        // Get all active categories for filter
        $categories = $this->categoryModel->getActiveCategories();

        // Render view
        $this->view('client/products/index', [
            'products' => $result['products'],
            'pagination' => $result['pagination'],
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'search' => $search,
            'pageTitle' => 'Sản phẩm'
        ]);
    }

    /**
     * Display product detail page
     */
    public function detail($slug)
    {
        // Get product by slug
        $product = $this->productModel->getBySlug($slug);

        if (!$product) {
            // Product not found - show 404
            header("HTTP/1.0 404 Not Found");
            $this->view('client/error/404', [
                'pageTitle' => 'Không tìm thấy sản phẩm'
            ]);
            exit;
        }

        // Get related products in same category
        $relatedProducts = $this->productModel->getRelatedProducts(
            $product['id'],
            $product['category_id'],
            4
        );

        // Render view
        $this->view('client/products/detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'pageTitle' => $product['name']
        ]);
    }
}
