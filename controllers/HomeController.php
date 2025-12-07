<?php

namespace Controllers;

use Models\ProductModel;

class HomeController extends BaseController
{
    private ProductModel $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Get featured products for homepage (show only 4)
        $featuredProducts = $this->productModel->getFeaturedProducts(4);

        // Render homepage view
        $this->view('client/home/index', [
            'featuredProducts' => $featuredProducts,
            'pageTitle' => 'Trang chủ'
        ]);
    }
}
