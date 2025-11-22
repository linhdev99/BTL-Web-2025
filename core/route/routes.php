<?php
$router->get('/', 'HomeController@index');
$router->get('/cms', 'DashboardController@index');

// CMS AUTH
$router->get('/cms/login', 'CMSAuthController@loginForm');
$router->post('/cms/login', 'CMSAuthController@loginPost');
$router->get('/cms/register', 'CMSAuthController@registerForm');
$router->post('/cms/register', 'CMSAuthController@registerPost');
$router->get('/cms/logout', 'CMSAuthController@logout');

// CMS PRODUCTS
$router->get('cms/products', 'CMSProductController@showAll');

// CMS Introduction (Trang giới thiệu)
$router->get('cms/introduction', 'CMSIntroductionController@index');

// CMS FAQ
$router->get('/cms/faq', 'CMSFAQController@index');
$router->get('/cms/faq/add', 'CMSFAQController@add');
$router->post('/cms/faq/add', 'CMSFAQController@store');
$router->get('/cms/faq/edit/{id}', 'CMSFAQController@edit');
$router->post('/cms/faq/edit/{id}', 'CMSFAQController@update');
$router->post('/cms/faq/delete/{id}', 'CMSFAQController@delete');

// Home
$router->get('/home', 'HomeController@index');
//test
