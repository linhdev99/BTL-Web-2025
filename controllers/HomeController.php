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

        // Get banner settings
        $banners = [];
        for ($i = 1; $i <= 3; $i++) {
            $banners[$i] = [
                'image' => getSetting("banner_{$i}_image", ''),
                'title' => getSetting("banner_{$i}_title", ''),
                'description' => getSetting("banner_{$i}_description", ''),
                'button_text' => getSetting("banner_{$i}_button_text", ''),
                'button_link' => getSetting("banner_{$i}_button_link", '')
            ];
        }

        // Render homepage view
        $this->view('client/home/index', [
            'featuredProducts' => $featuredProducts,
            'banners' => $banners,
            'pageTitle' => 'Trang chủ'
        ]);
    }
}
