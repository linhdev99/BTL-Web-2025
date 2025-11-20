<?php
$router->get('/', 'HomeController@index');
$router->get('/cms', 'DashboardController@index');

// CMS AUTH
$router->get('/cms/login', 'CMSAuthController@loginForm');
$router->post('/cms/login', 'CMSAuthController@loginPost');
$router->get('/cms/register', 'CMSAuthController@registerForm');
$router->post('/cms/register', 'CMSAuthController@registerPost');
$router->get('/cms/logout', 'CMSAuthController@logout');
