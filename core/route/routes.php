<?php

/**
 * Application Routes
 * Define all routes here
 */

// ========================================
// PUBLIC ROUTES (Client-facing)
// ========================================

// Home
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');

// Authentication
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@loginPost');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@registerPost');
$router->get('/logout', 'AuthController@logout');

// Products
$router->get('/products', 'ProductController@index');
$router->get('/product/{slug}', 'ProductController@detail');

// Cart & Checkout
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/update', 'CartController@update');
$router->post('/cart/remove', 'CartController@remove');
$router->get('/checkout', 'CartController@checkout');
$router->post('/checkout', 'CartController@processCheckout');
$router->get('/order-success', 'CartController@orderSuccess');

// User Profile & Orders
$router->get('/profile', 'UserController@profile');
$router->post('/profile', 'UserController@updateProfile');
$router->get('/my-orders', 'UserController@myOrders');
$router->get('/order/{id}', 'UserController@orderDetail');
$router->post('/order/{id}/cancel', 'UserController@cancelOrder');

// News
$router->get('/news', 'NewsController@index');
$router->get('/news/{slug}', 'NewsController@detail');

// About & Contact
$router->get('/about', 'PageController@about');
$router->get('/contact', 'PageController@contact');
$router->post('/contact', 'PageController@submitContact');

// FAQ - BTL FAQ system (tables created: faq_categories, faq, faq_questions, faq_comments)
$router->get('/faq', 'FAQController@index');
$router->get('/faq/questions', 'FAQController@questions');
$router->get('/faq/{id}', 'FAQController@faqDetail');

// ========================================
// ADMIN ROUTES (CMS)
// ========================================

// Dashboard - Updated to use DashboardController from BTL-Web-2025
$router->get('/cms', 'DashboardController@index');

// Products Management
$router->get('/cms/products', 'CMSProductController@index');
$router->get('/cms/products/add', 'CMSProductController@add');
$router->post('/cms/products/store', 'CMSProductController@store');
$router->get('/cms/products/{id}/edit', 'CMSProductController@edit');
$router->post('/cms/products/{id}/update', 'CMSProductController@update');
$router->post('/cms/products/{id}/delete', 'CMSProductController@delete');

// Orders Management
$router->get('/cms/orders', 'CMSOrderController@index');
$router->get('/cms/orders/{id}', 'CMSOrderController@viewOrder');
$router->post('/cms/orders/{id}/update-status', 'CMSOrderController@updateStatus');
$router->post('/cms/orders/{id}/update-payment-status', 'CMSOrderController@updatePaymentStatus');

// Users Management
$router->get('/cms/users', 'CMSUserController@index');
$router->get('/cms/users/add', 'CMSUserController@add');
$router->post('/cms/users/add', 'CMSUserController@store');
$router->get('/cms/users/edit/{id}', 'CMSUserController@edit');
$router->post('/cms/users/edit/{id}', 'CMSUserController@update');
$router->post('/cms/users/delete/{id}', 'CMSUserController@delete');

// News Management
$router->get('/cms/news', 'CMSNewsController@index');
$router->get('/cms/news/add', 'CMSNewsController@add');
$router->post('/cms/news/add', 'CMSNewsController@store');
$router->get('/cms/news/edit/{id}', 'CMSNewsController@edit');
$router->post('/cms/news/edit/{id}', 'CMSNewsController@update');
$router->post('/cms/news/delete/{id}', 'CMSNewsController@delete');

// Contacts Management
$router->get('/cms/contacts', 'CMSContactController@index');
$router->get('/cms/contacts/{id}', 'CMSContactController@viewContact');
$router->post('/cms/contacts/{id}/delete', 'CMSContactController@delete');

// Settings
$router->get('/cms/settings', 'CMSSettingController@index');
$router->post('/cms/settings/update', 'CMSSettingController@update');

// FAQ Management - BTL FAQ system
$router->get('/cms/faq', 'CMSFAQController@index');

// FAQ Static (Câu hỏi tĩnh)
$router->get('/cms/faq/static', 'CMSFAQController@static');
$router->get('/cms/faq/static/add', 'CMSFAQController@staticAdd');
$router->post('/cms/faq/static/add', 'CMSFAQController@staticStore');
$router->get('/cms/faq/static/edit/{id}', 'CMSFAQController@staticEdit');
$router->post('/cms/faq/static/edit/{id}', 'CMSFAQController@staticUpdate');
$router->post('/cms/faq/static/delete/{id}', 'CMSFAQController@staticDelete');

// FAQ Category
$router->get('/cms/faq/category', 'CMSFAQController@category');
$router->get('/cms/faq/category/add', 'CMSFAQController@categoryAdd');
$router->post('/cms/faq/category/add', 'CMSFAQController@categoryStore');
$router->get('/cms/faq/category/edit/{id}', 'CMSFAQController@categoryEdit');
$router->post('/cms/faq/category/edit/{id}', 'CMSFAQController@categoryUpdate');
$router->post('/cms/faq/category/delete/{id}', 'CMSFAQController@categoryDelete');

// FAQ User Questions
$router->get('/cms/faq/user', 'CMSFAQController@user');
$router->get('/cms/faq/user/detail/{id}', 'CMSFAQController@userDetail');
$router->post('/cms/faq/user/detail/{id}', 'CMSFAQController@userReply');
$router->post('/cms/faq/user/delete/{id}', 'CMSFAQController@userDelete');
$router->post('/cms/faq/user/status/{id}', 'CMSFAQController@userUpdateStatus');

// Categories Management
$router->get('/cms/categories', 'CMSCategoryController@index');
$router->get('/cms/categories/add', 'CMSCategoryController@add');
$router->post('/cms/categories/store', 'CMSCategoryController@store');
$router->get('/cms/categories/edit/{id}', 'CMSCategoryController@edit');
$router->post('/cms/categories/update/{id}', 'CMSCategoryController@update');
$router->post('/cms/categories/delete/{id}', 'CMSCategoryController@delete');
