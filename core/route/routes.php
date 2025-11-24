<?php
$router->get('/', 'HomeController@index');
$router->get('/cms', 'DashboardController@index');

// CMS AUTH
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@loginPost');
$router->get('/register', 'AuthController@registerForm');
$router->post('/register', 'AuthController@registerPost');
$router->get('/logout', 'AuthController@logout');

// CMS PRODUCTS
$router->get('cms/products', 'CMSProductController@showAll');

// CMS Introduction (Trang giới thiệu)
$router->get('cms/introduction', 'CMSIntroductionController@index');

$router->get('/cms/faq', 'CMSFAQController@index');

$router->get('/cms/faq/static', 'CMSFAQController@static');
$router->get('/cms/faq/static/add', 'CMSFAQController@staticAdd');
$router->post('/cms/faq/static/add', 'CMSFAQController@staticStore');
$router->get('/cms/faq/static/edit/{id}', 'CMSFAQController@staticEdit');
$router->post('/cms/faq/static/edit/{id}', 'CMSFAQController@staticUpdate');
$router->post('/cms/faq/static/delete/{id}', 'CMSFAQController@staticDelete');

$router->get('/cms/faq/category', 'CMSFAQController@category');
$router->get('/cms/faq/category/add', 'CMSFAQController@categoryAdd');
$router->post('/cms/faq/category/add', 'CMSFAQController@categoryStore');
$router->get('/cms/faq/category/edit/{id}', 'CMSFAQController@categoryEdit');
$router->post('/cms/faq/category/edit/{id}', 'CMSFAQController@categoryUpdate');
$router->post('/cms/faq/category/delete/{id}', 'CMSFAQController@categoryDelete');

$router->get('/cms/faq/user', 'CMSFAQController@user');
$router->get('/cms/faq/user/detail/{id}', 'CMSFAQController@userDetail');
$router->post('/cms/faq/user/detail/{id}', 'CMSFAQController@userReply');
$router->post('/cms/faq/user/detail/{id}/comment/delete/{id}', 'CMSFAQController@deleteComment');
$router->post('/cms/faq/user/delete/{id}', 'CMSFAQController@userDelete');
$router->post('/cms/faq/user/status/{id}', 'CMSFAQController@userUpdateStatus');

// Home
$router->get('/home', 'HomeController@index');

// FAQ
$router->get('/faq', 'FAQController@index');
$router->get('/faq/questions', 'FAQController@questions');
$router->get('/faq/{id}', 'FAQController@faqDetail');