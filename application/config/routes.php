<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
$route['default_controller'] = 'home/index';
$route['404_override'] = 'home/index';

$route['paypal/cancel'] = 'paypal/cancel';
$route['paypal/success'] = 'paypal/success';

$route['kd2a2a0u1g4'] = 'kd2a2a0u1g4/index';
$route['kd2a2a0u1g4/signup'] = 'kd2a2a0u1g4/signup';
$route['kd2a2a0u1g4/create_member'] = 'kd2a2a0u1g4/create_member';
$route['kd2a2a0u1g4/login'] = 'kd2a2a0u1g4/index';
$route['kd2a2a0u1g4/logout'] = 'kd2a2a0u1g4/logout';
$route['kd2a2a0u1g4/login/validate_credentials'] = 'kd2a2a0u1g4/validate_credentials';

$route['kd2a2a0u1g4/products'] = 'admin_products/index';
$route['kd2a2a0u1g4/products/add'] = 'admin_products/add';
$route['kd2a2a0u1g4/products/update'] = 'admin_products/update';
$route['kd2a2a0u1g4/products/update/(:any)'] = 'admin_products/update/$1';
$route['kd2a2a0u1g4/products/delete/(:any)'] = 'admin_products/delete/$1';
$route['kd2a2a0u1g4/products/(:any)'] = 'admin_products/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/category'] = 'admin_newsletter_category/index';
$route['kd2a2a0u1g4/category/add'] = 'admin_newsletter_category/add';
$route['kd2a2a0u1g4/category/update'] = 'admin_newsletter_category/update';
$route['kd2a2a0u1g4/category/update/(:any)'] = 'admin_newsletter_category/update/$1';
$route['kd2a2a0u1g4/category/delete/(:any)'] = 'admin_newsletter_category/delete/$1';
$route['kd2a2a0u1g4/category/(:any)'] = 'admin_newsletter_category/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/keyword'] = 'admin_newsletter_keyword/index';
$route['kd2a2a0u1g4/keyword/add'] = 'admin_newsletter_keyword/add';
$route['kd2a2a0u1g4/keyword/update'] = 'admin_newsletter_keyword/update';
$route['kd2a2a0u1g4/keyword/update/(:any)'] = 'admin_newsletter_keyword/update/$1';
$route['kd2a2a0u1g4/keyword/delete/(:any)'] = 'admin_newsletter_keyword/delete/$1';
$route['kd2a2a0u1g4/keyword/(:any)'] = 'admin_newsletter_keyword/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/language'] = 'admin_newsletter_language/index';
$route['kd2a2a0u1g4/language/add'] = 'admin_newsletter_language/add';
$route['kd2a2a0u1g4/language/update'] = 'admin_newsletter_language/update';
$route['kd2a2a0u1g4/language/update/(:any)'] = 'admin_newsletter_language/update/$1';
$route['kd2a2a0u1g4/language/delete/(:any)'] = 'admin_newsletter_language/delete/$1';
$route['kd2a2a0u1g4/language/(:any)'] = 'admin_newsletter_keyword/index/$1'; //$1 = page number


$route['kd2a2a0u1g4/newsletter'] = 'admin_newsletter/index';
$route['kd2a2a0u1g4/newsletter/add'] = 'admin_newsletter/add';
$route['kd2a2a0u1g4/newsletter/update'] = 'admin_newsletter/update';
$route['kd2a2a0u1g4/newsletter/update/(:any)'] = 'admin_newsletter/update/$1';
$route['kd2a2a0u1g4/newsletter/process/(:any)'] = 'admin_newsletter/process/$1';
$route['kd2a2a0u1g4/newsletter/delete/(:any)'] = 'admin_newsletter/delete/$1';
$route['kd2a2a0u1g4/newsletter/multidelete'] = 'admin_newsletter/multidelete';
$route['kd2a2a0u1g4/newsletter/multidelete/(:any)'] = 'admin_newsletter/multidelete/$1';
$route['kd2a2a0u1g4/newsletter/issues/(:num)'] = 'admin_newsletter/issues/$1';
$route['kd2a2a0u1g4/newsletter/issues/(:num)/(:num)'] = 'admin_newsletter/issues/$1/$2';
$route['kd2a2a0u1g4/newsletter/(:any)'] = 'admin_newsletter/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/admin-inbox'] = 'admin_newsletter_clone/index';
//$route['kd2a2a0u1g4/admin-inbox/add'] = 'admin_newsletter/add';
$route['kd2a2a0u1g4/admin-inbox/update'] = 'admin_newsletter_clone/update';
$route['kd2a2a0u1g4/admin-inbox/update/(:any)'] = 'admin_newsletter_clone/update/$1';
$route['kd2a2a0u1g4/admin-inbox/delete/(:any)'] = 'admin_newsletter_clone/delete/$1';
$route['kd2a2a0u1g4/admin-inbox/process/(:any)'] = 'admin_newsletter_clone/process/$1';
$route['kd2a2a0u1g4/admin-inbox/process_without_check/(:any)'] = 'admin_newsletter_clone/process_without_check/$1';
//$route['kd2a2a0u1g4/newsletter/multidelete'] = 'admin_newsletter/multidelete';
//$route['kd2a2a0u1g4/newsletter/multidelete/(:any)'] = 'admin_newsletter/multidelete/$1';
//$route['kd2a2a0u1g4/admin-inbox/issues/(:any)'] = 'admin_newsletter_clone/issues/$1';
//$route['kd2a2a0u1g4/admin-inbox/(:any)'] = 'admin_newsletter/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/administration-folder'] = 'admin_administration_folder/index';
//$route['kd2a2a0u1g4/admin-inbox/add'] = 'admin_newsletter/add';
$route['kd2a2a0u1g4/administration-folder/update'] = 'admin_administration_folder/update';
$route['kd2a2a0u1g4/administration-folder/update/(:any)'] = 'admin_administration_folder/update/$1';
$route['kd2a2a0u1g4/administration-folder/delete/(:any)'] = 'admin_administration_folder/delete/$1';
$route['kd2a2a0u1g4/administration-folder/process/(:any)'] = 'admin_administration_folder/process/$1';
//$route['kd2a2a0u1g4/newsletter/multidelete'] = 'admin_newsletter/multidelete';
//$route['kd2a2a0u1g4/newsletter/multidelete/(:any)'] = 'admin_newsletter/multidelete/$1';
//$route['kd2a2a0u1g4/admin-inbox/issues/(:any)'] = 'admin_newsletter_clone/issues/$1';
//$route['kd2a2a0u1g4/administration-folder/(:any)'] = 'admin_newsletter/index/$1'; //$1 = page number


$route['kd2a2a0u1g4/user'] = 'admin_user/index';
$route['kd2a2a0u1g4/user/add'] = 'admin_user/add';
$route['kd2a2a0u1g4/user/update'] = 'admin_user/update';
$route['kd2a2a0u1g4/user/exportcsv'] = 'admin_user/exportcsv';
$route['kd2a2a0u1g4/user/update/(:any)'] = 'admin_user/update/$1';
$route['kd2a2a0u1g4/user/delete/(:any)'] = 'admin_user/delete/$1';
$route['kd2a2a0u1g4/user/(:any)'] = 'admin_user/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/sitelanguage'] = 'admin_site_language/index';
$route['kd2a2a0u1g4/sitelanguage/add'] = 'admin_site_language/add';
$route['kd2a2a0u1g4/sitelanguage/update'] = 'admin_site_language/update';
$route['kd2a2a0u1g4/sitelanguage/update/(:any)'] = 'admin_site_language/update/$1';
$route['kd2a2a0u1g4/sitelanguage/delete/(:any)'] = 'admin_site_language/delete/$1';
$route['kd2a2a0u1g4/sitelanguage/(:any)'] = 'admin_site_language/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/languagekeyword'] = 'admin_language_keyword/index';
$route['kd2a2a0u1g4/languagekeyword/add'] = 'admin_language_keyword/add';
$route['kd2a2a0u1g4/languagekeyword/update'] = 'admin_language_keyword/update';
$route['kd2a2a0u1g4/languagekeyword/update/(:any)'] = 'admin_language_keyword/update/$1';
$route['kd2a2a0u1g4/languagekeyword/delete/(:any)'] = 'admin_language_keyword/delete/$1';
$route['kd2a2a0u1g4/languagekeyword/(:any)'] = 'admin_language_keyword/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/languagekeyword/(:any)'] = 'admin_language_keyword/index/$1';

$route['kd2a2a0u1g4/advertisement'] = 'admin_advertisement/index';
$route['kd2a2a0u1g4/advertisement/add'] = 'admin_advertisement/add';
$route['kd2a2a0u1g4/advertisement/update'] = 'admin_advertisement/update';
$route['kd2a2a0u1g4/advertisement/update/(:any)'] = 'admin_advertisement/update/$1';
$route['kd2a2a0u1g4/advertisement/delete/(:any)'] = 'admin_advertisement/delete/$1';
$route['kd2a2a0u1g4/advertisement/(:any)'] = 'admin_advertisement/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/advertisement/(:any)'] = 'admin_advertisement/index/$1';

$route['kd2a2a0u1g4/wanted-add'] = 'admin_wanted_add/index';
$route['kd2a2a0u1g4/wanted-add/add'] = 'admin_wanted_add/add';
$route['kd2a2a0u1g4/wanted-add/update'] = 'admin_wanted_add/update';
$route['kd2a2a0u1g4/wanted-add/update/(:any)'] = 'admin_wanted_add/update/$1';
$route['kd2a2a0u1g4/wanted-add/status'] = 'admin_wanted_add/status';
$route['kd2a2a0u1g4/wanted-add/status/(:any)'] = 'admin_wanted_add/status/$1';
$route['kd2a2a0u1g4/wanted-add/delete/(:any)'] = 'admin_wanted_add/delete/$1';
$route['kd2a2a0u1g4/wanted-add/(:any)'] = 'admin_wanted_add/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/wanted-add/(:any)'] = 'admin_wanted_add/index/$1';

$route['kd2a2a0u1g4/cpanel'] = 'admin_cpanel/index';
$route['kd2a2a0u1g4/cpanel/add'] = 'admin_cpanel/add';
$route['kd2a2a0u1g4/cpanel/update'] = 'admin_cpanel/update';
$route['kd2a2a0u1g4/cpanel/update/(:any)'] = 'admin_cpanel/update/$1';
$route['kd2a2a0u1g4/cpanel/delete/(:any)'] = 'admin_cpanel/delete/$1';
$route['kd2a2a0u1g4/cpanel/(:any)'] = 'admin_cpanel/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/cpanel/(:any)'] = 'admin_cpanel/index/$1';

$route['kd2a2a0u1g4/emailinbox'] = 'admin_email_inbox/index';
$route['kd2a2a0u1g4/emailinbox/inboxlist'] = 'admin_email_inbox/inboxlist';
$route['kd2a2a0u1g4/emailinbox/body'] = 'admin_email_inbox/body';
$route['kd2a2a0u1g4/emailinbox/body/(:any)/(:any)'] = 'admin_email_inbox/body/$1/$2';
$route['kd2a2a0u1g4/emailinbox/process'] = 'admin_email_inbox/process';
$route['kd2a2a0u1g4/emailinbox/process/(:any)/(:any)'] = 'admin_email_inbox/process/$1/$2';
$route['kd2a2a0u1g4/emailinbox/delete/(:any)'] = 'admin_email_inbox/delete/$1';
$route['kd2a2a0u1g4/emailinbox/delete_mail/(:any)/(:any)'] = 'admin_email_inbox/delete_mail/$1/$2';
$route['kd2a2a0u1g4/emailinbox/(:any)'] = 'admin_email_inbox/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/emailinbox/(:any)'] = 'admin_email_inbox/index/$1';

$route['kd2a2a0u1g4/cms'] = 'admin_cms/index';
$route['kd2a2a0u1g4/cms/add'] = 'admin_cms/add';
$route['kd2a2a0u1g4/cms/update'] = 'admin_cms/update';
$route['kd2a2a0u1g4/cms/update/(:any)'] = 'admin_cms/update/$1';
$route['kd2a2a0u1g4/cms/delete/(:any)'] = 'admin_cms/delete/$1';
$route['kd2a2a0u1g4/cms/(:any)'] = 'admin_cms/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/cms/(:any)'] = 'admin_cms/index/$1';

$route['kd2a2a0u1g4/blog'] = 'admin_blog/index';
$route['kd2a2a0u1g4/blog/add'] = 'admin_blog/add';
$route['kd2a2a0u1g4/blog/update'] = 'admin_blog/update';
$route['kd2a2a0u1g4/blog/update/(:any)'] = 'admin_blog/update/$1';
$route['kd2a2a0u1g4/blog/delete/(:any)'] = 'admin_blog/delete/$1';
$route['kd2a2a0u1g4/blog/clone/(:any)'] = 'admin_blog/do_clone/$1';
$route['kd2a2a0u1g4/blog/delete_image/(:any)'] = 'admin_blog/delete_image/$1';
$route['kd2a2a0u1g4/blog/(:any)'] = 'admin_blog/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/blog/(:any)'] = 'admin_blog/index/$1';

$route['kd2a2a0u1g4/comment'] = 'admin_comment/index';
$route['kd2a2a0u1g4/comment/status/(:any)'] = 'admin_comment/status/$1';
$route['kd2a2a0u1g4/comment/delete/(:any)'] = 'admin_comment/delete/$1';
$route['kd2a2a0u1g4/comment/update/(:any)'] = 'admin_comment/update/$1';
$route['kd2a2a0u1g4/comment/(:any)'] = 'admin_comment/index/$1'; //$1 = page number

$route['kd2a2a0u1g4/remove-unsubscribe'] = 'admin_remove_unsubscribe/index';
$route['kd2a2a0u1g4/remove-unsubscribe/add'] = 'admin_remove_unsubscribe/add';
$route['kd2a2a0u1g4/remove-unsubscribe/update'] = 'admin_remove_unsubscribe/update';
$route['kd2a2a0u1g4/remove-unsubscribe/update/(:any)'] = 'admin_remove_unsubscribe/update/$1';
$route['kd2a2a0u1g4/remove-unsubscribe/delete/(:any)'] = 'admin_remove_unsubscribe/delete/$1';
$route['kd2a2a0u1g4/remove-unsubscribe/(:any)'] = 'admin_remove_unsubscribe/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/remove-unsubscribe/(:any)'] = 'admin_advertisement/index/$1';

$route['help'] = 'help/index';
$route['help/(:any)'] = 'help/index/$1';

$route['ajax_call/set_session_language_shortcode/(:any)'] = 'ajax_call/set_session_language_shortcode/$1';
//$route['ajax_call/set_session_language_shortcode/(:any)'] = 'ajax_call/set_session_language_shortcode/$1';

$route['kd2a2a0u1g4/dashboard'] = 'dashboard/index';

//Front End Routes rules

$route['newsletter'] = 'newsletter/index';
$route['newsletter/(:num)'] = 'newsletter/index/$1';
$route['newsletter/(:num)/(:num)'] = 'newsletter/index/$1/$2';
$route['newsletter/specific/(:any)'] = 'newsletter/specific/$1';
$route['newsletter/rateit/(:any)'] = 'newsletter/rateit/$1';
$route['newsletter/display-rate/(:any)'] = 'newsletter/display_rate/$1';
$route['newsletter/addreview/(:any)'] = 'newsletter/addreview/$1';
//$route['newsletter/subscribe/add/(:any)'] = 'newsletter/subscribe/add/$1';

$route['myknewdog'] = 'myknewdog/index';
$route['myknewdog/(:num)'] = 'myknewdog/index/$1';
$route['myknewdog/edit_profile'] = 'myknewdog/edit_profile';
$route['myknewdog/schedule'] = 'myknewdog/schedule';
$route['myknewdog/upload_avtar'] = 'myknewdog/upload_avtar';
$route['myknewdog/upload_avtar'] = 'myknewdog/upload_crop_avatar';
$route['myknewdog/cancle_account'] = 'myknewdog/cancle_account';

//bhushan changes
$route['kd2a2a0u1g4/email_template'] = 'admin_email_template/index';
$route['kd2a2a0u1g4/email_template/update'] = 'admin_email_template/update';
$route['kd2a2a0u1g4/email_template/update/(:any)'] = 'admin_email_template/update/$1';
$route['kd2a2a0u1g4/email_template/(:any)'] = 'admin_email_template/index/$1'; //$1 = page number
$route['kd2a2a0u1g4/email_template/(:any)'] = 'admin_email_template/index/$1';
//end changes

$route['kd2a2a0u1g4/invoice'] = 'admin_invoice/index';
//$route['kd2a2a0u1g4/invoice/update'] = 'admin_invoice/update';
//$route['kd2a2a0u1g4/invoice/update/(:any)'] = 'admin_invoice/update/$1';
$route['kd2a2a0u1g4/invoice/(:num)'] = 'admin_invoice/index/$1';
//$route['kd2a2a0u1g4/invoice/(:any)'] = 'admin_invoice/index/$1';

$route['kd2a2a0u1g4/invoice/(:any)'] = 'admin_invoice/invoicepdf/$1';

$route['kd2a2a0u1g4/newsletter_email'] = 'admin_newsletter_email/index';
//$route['kd2a2a0u1g4/invoice/update'] = 'admin_invoice/update';
//$route['kd2a2a0u1g4/invoice/update/(:any)'] = 'admin_invoice/update/$1';
$route['kd2a2a0u1g4/newsletter_email/(:num)'] = 'admin_newsletter_email/index/$1';
//$route['kd2a2a0u1g4/invoice/(:any)'] = 'admin_invoice/index/$1';


$route['blog'] = 'blog/index';
$route['blog/(:num)'] = 'blog/index/$1';
//$route['blog/(:num)/(:num)'] = 'newsletter/index/$1/$2';
$route['blog/specific/(:any)'] = 'blog/specific/$1';

$route['premium-account'] = 'gopremium';
$route['premium-account/paypal'] = 'gopremium/paypal';
$route['premium-account/(:any)'] = 'gopremium/$1';

$route['about'] = 'page/index';
$route['legal'] = 'page/index';
$route['privacy'] = 'page/index';

$route['contact'] = 'contactus/index';
//$route['404_override'] = 'error/index';
//crons
$route['cron_email_issues/process'] = 'cron_email_issues/process';


$route['sitemap\.xml'] = "sitemap";
$route['robot\.txt'] = "robot";
//
/*$route['kd2a2a0u1g4/newsletter/add'] = 'admin_newsletter/add';
$route['kd2a2a0u1g4/newsletter/update'] = 'admin_newsletter/update';
$route['kd2a2a0u1g4/newsletter/update/(:any)'] = 'admin_newsletter/update/$1';
$route['kd2a2a0u1g4/newsletter/delete/(:any)'] = 'admin_newsletter/delete/$1';
$route['kd2a2a0u1g4/newsletter/multidelete'] = 'admin_newsletter/multidelete';
$route['kd2a2a0u1g4/newsletter/multidelete/(:any)'] = 'admin_newsletter/multidelete/$1';
$route['kd2a2a0u1g4/newsletter/issues/(:any)'] = 'admin_newsletter/issues/$1';
$route['kd2a2a0u1g4/newsletter/(:any)'] = 'admin_newsletter/index/$1'; //$1 = page number
*/
/* End of file routes.php */
/* Location: ./application/config/routes.php */