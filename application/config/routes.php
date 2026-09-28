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
$route['default_controller'] = 'welcome';

$route['admin'] = 'admin/admin/index';
$route['admin/dashboard'] = 'admin/admin/dashboard';
$route['admin/change_password'] = 'admin/admin/change_password';
$route['admin/logout'] = 'admin/admin/logout';
$route['shop'] = 'product/shop';
$route['(:any).(html)'] = 'product/listing/$1';
$route['(:any)/(:any).(html)'] = 'product/detail/$1/$2';
$route['about-us'] = 'about';
$route['contact-us'] = 'contact';
$route['blog/'] = 'blog';
$route['blog/(:any)'] ='blog/detail/$1';
$route['return-policy'] = 'welcome/return_policy';
$route['apply-for-distributorship'] = 'welcome/apply_for_distributorship';
$route['international-orders'] = 'welcome/international_orders';
$route['bulk-orders'] = 'welcome/bulk_orders';
$route['coupon'] = 'welcome/coupon';
$route['FAQs'] = 'welcome/FAQs';
$route['product-detail'] = 'welcome/product_detail';
$route['checkout'] = 'welcome/checkout';
$route['login'] = 'user/login';
$route['terms-conditions'] = 'welcome/terms_conditions';
$route['privacy-policy'] = 'welcome/privacy_policy';
$route['offer'] = 'welcome/offer';
 $route['thankYou'] ='Payment/thankYou/';
 $route['success/(:any)'] ='checkout/success/';
$route['order-payment-process/(:any)'] ='payment/index/$1';
 $route['verify-phone-number'] ='checkout/verifyPhoneNumber/';
$route['404_override'] = 'welcome/error404';
$route['404'] = 'welcome/error404';
$route['translate_uri_dashes'] = FALSE;

