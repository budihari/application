<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['pilih/(:any)/(:any)'] = 'home/list_product/';
$route['pilih/(:any)/(:any)/(:any)'] = 'home/list_product/';
$route['produk/(:any)'] = 'produk/index/$1';
$route['search/(:any)'] = 'home/search/';
$route['admin'] = 'login/index';
$route['login/logout'] = 'login/logout';
$route['lost_admin'] = 'lost_admin/index';
$route['reset_admin'] = 'lost_admin/reset';
$route['signin'] = 'home/login';
$route['signup'] = 'home/registrasi';
$route['administrator'] = 'administrator/index';
$route['administrator/(:any)'] = 'administrator/$1';
$route['administrator/(:any)/(:any)'] = 'administrator/$1/$2';
$route['item'] = 'item/index';
$route['item/(:any)'] = 'item/$1';
$route['item/(:any)/(:any)'] = 'item/$1/';
$route['tag'] = 'tag/index';
$route['tag/(:any)'] = 'tag/$1';
$route['tag/(:any)/(:any)'] = 'tag/$1/';
$route['lost_user'] = 'lost_user/index';
$route['lost_user/(:any)'] = 'lost_user/$1';
$route['lost_user/(:any)/(:any)'] = 'lost_user/$1/';
$route['assets'] = 'assets/index';
$route['assets/(:any)'] = 'assets/$1';
$route['assets/(:any)/(:any)'] = 'assets/$1/';
$route['banner'] = 'banner/index';
$route['banner/(:any)'] = 'banner/$1';
$route['banner/(:any)/(:any)'] = 'banner/$1/';
$route['payment'] = 'payment/index';
$route['payment/(:any)'] = 'payment/$1';
$route['payment/(:any)/(:any)'] = 'payment/$1/';
$route['transaksi'] = 'transaksi/index';
$route['transaksi/(:any)'] = 'transaksi/$1';
$route['transaksi/(:any)/(:any)'] = 'transaksi/$1/';
$route['pembayaran'] = 'pembayaran/index';
$route['pembayaran/(:any)'] = 'pembayaran/$1';
$route['pembayaran/(:any)/(:any)'] = 'pembayaran/$1/';
$route['user'] = 'user/index';
$route['user/(:any)'] = 'user/$1';
$route['user/(:any)/(:any)'] = 'user/$1/';
$route['setting'] = 'setting/index';
$route['setting/(:any)'] = 'setting/$1';
$route['setting/(:any)/(:any)'] = 'setting/$1/';
$route['search/(:any)/(:num)'] = 'home/search/';
$route['payment'] = 'payment/index';
$route['cart'] = 'cart/index';
$route['cart/(:any)'] = 'cart/$1';
$route['cart/(:any)/(:any)'] = 'cart/$1/';
$route['checkout'] = 'checkout/index';
$route['checkout/(:any)'] = 'checkout/$1';
$route['checkout/(:any)/(:any)'] = 'checkout/$1/';
$route['home/(:any)'] = 'home/$1';
$route['home/(:any)/(:any)'] = 'home/$1/';
$route['home/kategori/(:any)'] = 'home/kategori/';
$route['terms-and-conditions'] = 'home/terms_and_condition';
$route['privacy-policy'] = 'home/privacy_policy';
$route['faq'] = 'home/faq';
$route['filter_by/(:any)/(:any)/(:any)'] = 'home/filter_by/';
$route['(:any)'] = 'kategori/index/$1';
$route['(:any)/(:any)'] = 'kategori/index/$1/$2';
$route['(:any)/page/(:num)'] = 'kategori/index/$1/page/$2';
$route['(:any)/(:any)/(:num)'] = 'kategori/index/$1/$2/$3';
$route['(:any)/(:any)/(:any)'] = 'produk/detail/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
