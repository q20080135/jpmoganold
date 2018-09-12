<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'main';
$route['business/login']="busAdmin/LoginController/business_login";
$route['404_override'] = '';
$route['login.html'] = 'jt_admin/auth/index';
$route['Auth/login'] = 'jt_admin/Auth/login';
$route['product/detail.html']="api/ProductNController/getProductSharingDetailByID";
$route['member/invitaion/(:any).html']="api/InvitationNController/memberInvitationRegisterBymCode/$1";
$route['member/invitation.html']="api/InvitationNController/memberInvitationRegisterInfoAdd";
$route['fight/(:num)/(:num)/detail.html']="api/FightNController/shareFightGroupDetail/$1/$2";
$route['member/extension.html']="api/RegisterNController/jtMartRegisterMember";

$route['account.html']="front/index/account";
$route['brand_story.html']="front/index/brand_story";
$route['activity.html']="front/index/activity";
$route['announcement.html']="front/index/announcement";
$route['announcement.html/(:num)/(:num)']="front/index/announcement/$1/$2";

$route['back2c.html']="front/index/back2c";
$route['broker.html']="front/index/broker";
$route['crude.html']="front/index/crude";
$route['datadownload.html']="front/index/datadownload";
$route['dictionary.html']="front/index/dictionary";
$route['forex.html']="front/index/forex";
$route['linkus.html']="front/index/linkus";
$route['manager.html']="front/index/manager";
$route['metal.html']="front/index/metal";
$route['moneysafety.html']="front/index/moneysafety";
$route['mt4pc.html']="front/index/mt4pc";
$route['regulations.html']="front/index/regulations";
$route['rule.html']="front/index/rule";
$route['trader.html']="front/index/trader";
$route['training.html/(:num)']="front/index/training/$1";
$route['training.html']="front/index/training";
$route['whyus.html']="front/index/whyus";
$route['zhishu.html']="front/index/zhishu";
$route['headline.html']="front/index/headline";
$route['submit.html']="front/index/submit";
$route['helpcenter.html']="front/index/helpcenter";
$route['xq.html/(:num)']="front/index/xq/$1";
$route['search.html/(:any)']="front/index/search/$1";
$route['search.html']="front/index/search/''";











$route['translate_uri_dashes'] = false;
