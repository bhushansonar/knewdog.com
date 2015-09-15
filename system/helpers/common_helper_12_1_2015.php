<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */
// ------------------------------------------------------------------------

/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns FALSE (or whatever you specify as the default value.)
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @return	mixed	depends on what the array contains
 */
if (!function_exists('random_number')) {

    function random_number($digits = 5) {

        return $randno = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

}
if (!function_exists('get_number_zero')) {

    function get_number_zero($number, $max = 10) {
        $numbercount = strlen($number);
        $newcount = $max - $numbercount;
        $mainstring = "";
        for ($i = 0; $i < $newcount; $i++) {
            $mainstring = $mainstring . "0";
        }
        return $mainstring . $number;
    }

}
if (!function_exists('generate_invoice_number')) {

    function generate_invoice_number() {
        $ci = & get_instance();
        $ci->load->model('invoice_model');
        $sql = "SELECT invoice_id FROM `invoice` ORDER BY `invoice_id` DESC limit 0,1";
        $query = $ci->db->query($sql);
        $data = $query->result();
//        if(!empty($data[0]->invoice_id))

        if (!empty($data)) {
            $number = $data[0]->invoice_id + 1;
            echo get_number_zero($number);
        } else {
            echo "0000000001";
        }
    }

}

if (!function_exists('_clang')) {

    function _clang($val) {
        $ci = & get_instance();
//$ci->do_language->set_language();
        $val = stripslashes($val);
        $val = trim($val);

        return $val;
    }

}

/**
 * Use to encrypt Password
 * return encrypt password
 * */
if (!function_exists('encrypt')) {

    function encrypt($data) {
        if ($data) {
            $returnvalue = $data;
            for ($i = 0; $i < 2; $i++) {
                $returnvalue = strrev(base64_encode($returnvalue));
            }
            return $returnvalue;
        } else {
            return;
        }
    }

}

/**
 * Use to decrypt Password
 * return decrypt password
 * */
if (!function_exists('decrypt')) {

    function decrypt($data) {
        if ($data) {
            $returnvalue = $data;
            for ($i = 0; $i < 2; $i++) {
                $returnvalue = base64_decode(strrev($returnvalue));
            }
            return $returnvalue;
        } else {
            return;
        }
    }

}

/**
 * Use to get random Password
 * return raw password
 * */
if (!function_exists('generate_password')) {

    function generate_password($length = 8) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

}




/**
 * Use to get url encode
 * return decode char
 * */
if (!function_exists('base64url_encode')) {

    function base64url_encode($str) {
        return strtr(base64_encode($str), '+/', '-_');
    }

}
/**
 * Use to get url decode
 * return encode char
 * */
if (!function_exists('base64url_decode')) {

    function base64url_decode($base64url) {
        return base64_decode(strtr($base64url, '-_', '+/'));
    }

}

/**
 * Use to get admin details
 * return array for name and email
 * */
if (!function_exists('get_admin_email')) {

    function get_admin_detail() {
//$array = array('email' => 'noreply@knewdog.com', 'name' => 'knewdog!','host' => 'knewdog.com');
        $array = array('email' => 'info@knewdog.com', 'name' => 'knewdog!', 'host' => 'knewdog.com');
        return $array;
    }

}
/**
 * Use to get google login data
 * return array for google login
 * */
if (!function_exists('K_google')) {

    function K_google() {

        $ci = & get_instance();
        $ci->load->config('google');
        $google_client_id = $ci->config->item('google_client_id');
        $google_client_secret = $ci->config->item('google_client_secret');
        $google_redirect_url = $ci->config->item('google_redirect_url'); //path to your script
        $google_developer_key = $ci->config->item('google_developer_key');

        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_Oauth2Service.php';
        $gClient = new Google_Client();
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);


        $google_oauthV2 = new Google_Oauth2Service($gClient);


//If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            unset($_SESSION['token']);
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
        }
        if (!isset($_GET['code']) && empty($_REQUEST['state'])) {
            unset($_SESSION['token']);
        }
//If code is empty, redirect user to google authentication page for code.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.

        if (isset($_GET['code']) && empty($_REQUEST['state'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
//echo $_SESSION['token'];die;
//header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
//return;
        }


        if (isset($_SESSION['token'])) {
//echo "tokent->".$_SESSION['token'];
            $gClient->setAccessToken($_SESSION['token']);
        }

//echo "aceec->". $gClient->getAccessToken(); die;
        if ($gClient->getAccessToken()) {
//For logged in user, get details from google using access token
            $data['guser'] = $google_oauthV2->userinfo->get();
            $data['guser_id'] = $data['guser']['id'];
            $data['guser_name'] = filter_var($data['guser']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $data['gemail'] = filter_var($data['guser']['email'], FILTER_SANITIZE_EMAIL);
            $data['gprofile_url'] = filter_var($data['guser']['link'], FILTER_VALIDATE_URL);
            $data['gprofile_image_url'] = filter_var($data['guser']['picture'], FILTER_VALIDATE_URL);
            $gprofile_image_url = $data['gprofile_image_url'];
            $email = $data['gemail'];
            $data['gpersonMarkup'] = "$email<div><img src='$gprofile_image_url?sz=50'></div>";
            $user = $data['guser'];
//            echo "<pre>";
//            print_r($user);
//            exit;
            //exit;
            if (!empty($user)) {

                $get_users = $ci->user_model->get_user_by_filed('primary_email', $user['email']);
                $chek_email_id_exist = $ci->user_model->check_duplicate_email_by_filed('primary_email', $user['email']);

                if ((count($get_users) == 0) && $chek_email_id_exist == True) {
                    $random_string = generate_password();
                    $username = $user['given_name'] . $random_string;
                    $data_to_store = array(
                        'firstname' => $user['given_name'],
                        'google_id' => $user['id'],
                        'username' => $username,
                        'lastname' => $user['family_name'],
                        'primary_email' => $user['email'],
                        'gender' => $user['gender'],
                        'avatar' => $user['picture'],
                        'type_of_membership' => 'FREE',
                        'date_of_registration' => date("Y-m-d H:i:s"),
                        'last_login' => date("Y-m-d H:i:s"),
                        'status' => 'Active',
                    );
                    $ci->user_model->store_user($data_to_store);
                    $last_id = $ci->db->insert_id();

                    $get_member = 'FREE';
                    $session = array(
                        'username' => $username,
                        'user_id' => $last_id,
                        'type_of_membership' => $get_member,
                        'login_google' => 1,
                        'is_logged_in' => true
                    );

                    $ci->session->set_userdata($session);
                    if (isset($_GET['code'])) {
                        echo "<script>
        window.close();
        window.opener.location.reload();
                                </script>";
                    }
                } else {
                    $username_details = $ci->user_model->get_username_by_email_id($user['email']);
                    if (!empty($username_details)) {
                        $username1 = $username_details[0]['username'];
                    }
                    $data_to_store = array(
                        'firstname' => $user['given_name'],
                        'google_id' => $user['id'],
                        'lastname' => $user['family_name'],
                        'gender' => $user['gender'],
                        'avatar' => $user['picture'],
                        'last_login' => date("Y-m-d H:i:s"),
                    );
                    $ci->user_model->update_user_by_field('primary_email', $get_users[0]['primary_email'], $data_to_store);

                    $last_id1 = $get_users[0]['user_id'];
                    $get_member = 'FREE';
                    $session = array(
                        'username' => $username1,
                        'user_id' => $last_id1,
                        'type_of_membership' => $get_member,
                        'login_google' => 1,
                        'is_logged_in' => true
                    );


                    $ci->session->set_userdata($session);
                    if (isset($_GET['code'])) {
                        echo "<script>
        window.close();
        window.opener.location.reload();
                                </script>";
                    }
                }
            }
        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
        return $data;
    }

}

/**
 * Use to get Facebook login data
 * return array for facebook User data
 * */
if (!function_exists('K_facebook')) {

    function K_facebook() {

//facebook add user and session entry process end
        $ci = & get_instance();
        $ci->load->library('facebook');
        $user = $ci->facebook->getUser();
//echo "<pre>";print_r($user);exit;
        if (!empty($user)) {

            $data['user_profile'] = $ci->facebook->api('/me');
            //echo '<pre>'; print_r($data['user_profile']);exit;
            $access_token = $ci->facebook->getAccessToken();
            $params = array('next' => base_url('welcome/logout/'), 'access_token' => $access_token);
            $data['logout_url'] = $ci->facebook->getLogoutUrl($params);

            $get_users = $ci->user_model->get_user_by_filed('primary_email', $data['user_profile']['email']);
            $chek_email_id_exist = $ci->user_model->check_duplicate_email_by_filed('primary_email', $data['user_profile']['email']);

//            echo "<pre>";
//            print_r($get_users);
//            exit;
            $firstname = (!empty($data['user_profile']['first_name']) ? $data['user_profile']['first_name'] : "");
            $lastname = (!empty($data['user_profile']['last_name']) ? $data['user_profile']['last_name'] : "");
            $email = (!empty($data['user_profile']['email']) ? $data['user_profile']['email'] : "");
            $gender = (!empty($data['user_profile']['gender']) ? $data['user_profile']['gender'] : "");

            /* if (isset($_REQUEST['state']) && isset($_REQUEST['code'])) {
              echo "<script>
              window.close();
              window.opener.location.reload();
              </script>";
              } else {
              // load page
              } */
            if (count($get_users) == 0 && $chek_email_id_exist == True) {
                $random_string = generate_password();
                $username_fb = $data['user_profile']['first_name'] . $random_string;
                //exit;
                $data_to_store = array(
                    'firstname' => $firstname,
                    'fb_id' => $data['user_profile']['id'],
                    'username' => $username_fb,
                    'lastname' => $lastname,
                    'password' => '',
                    'primary_email' => $email,
                    'gender' => $gender,
                    'avatar' => '',
                    'town' => '',
                    'type_of_membership' => 'FREE',
                    'date_of_registration' => date("Y-m-d H:i:s"),
                    'last_login' => date("Y-m-d H:i:s"),
                    'status' => 'Active',
                );
                //echo "<pre>";print_r($data_to_store);exit;
                $ci->user_model->store_user($data_to_store);
                $last_id = $ci->db->insert_id();
                //$get_fb_data = $ci->user_model->get_user_by_filed('user_id', $last_id);
                $get_member = 'FREE';
                $session = array(
                    'username' => $username_fb,
                    'user_id' => $last_id,
                    'type_of_membership' => $get_member,
                    'login_facebook' => 1,
                    'is_logged_in' => true
                );
                $ci->session->set_userdata($session);
                $facebook_redirect_url = site_url();
                //echo '<pre>'; print_r($_GET); die;
                if (isset($_GET['code']) && isset($_GET['state'])) {
                    echo "<script>
                    window.close();
                    window.opener.location.reload();
                                            </script>";
                }
            } else {
                $username_details = $ci->user_model->get_username_by_email_id($data['user_profile']['email']);
                if (!empty($username_details)) {
                    $username1 = $username_details[0]['username'];
                }
                $data_to_store = array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username1,
                    'gender' => $data['user_profile']['gender'],
                    'last_login' => date("Y-m-d H:i:s"),
                );
                $ci->user_model->update_user_by_field('primary_email', $data['user_profile']['email'], $data_to_store);
                //}
                //$get_fb_data = $ci->user_model->get_user_by_filed('fb_id', $data['user_profile']['email']);
                //$ci->user_model->get_username_by_email_id($data['user_profile']['email']);

                $last_id1 = $get_users[0]['user_id'];
                $session = array(
                    'username' => $username1,
                    'user_id' => $last_id1,
                    'type_of_membership' => $get_users[0]['type_of_membership'],
                    'login_facebook' => 1,
                    'is_logged_in' => true
                );
                $ci->session->set_userdata($session);
                $facebook_redirect_url = site_url();
                //echo '<pre>'; print_r($_GET); die;
                if (isset($_GET['code']) && isset($_GET['state'])) {
                    echo "<script>
                    window.close();
                    window.opener.location.reload();
                                            </script>";
                }
            }

            //facebook add user and session entry process end
        } else {
            $data['login_url'] = $ci->facebook->getLoginUrl(array(
                'display' => 'popup',
                'next' => site_url(),
                /* 'redirect_uri' => site_url(), */
                'scope' => array("email") // permissions here
            ));
        }
        return $data;
    }

}

/**
 * Use to get type of user
 * return array for User data
 * */
if (!function_exists('type_of_user')) {

    function type_of_user() {
        $data = array('poweradmin');
        return $data;
    }

}
/**
 * Use to validate url
 * return array
 * */
if (!function_exists('url_exists_curl')) {

    function url_exists_curl($url) {
        $ch = @curl_init($url);
        @curl_setopt($ch, CURLOPT_HEADER, TRUE);
        @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $status = array();
        preg_match('/HTTP\/.* ([0-9]+) .*/', @curl_exec($ch), $status);
        if (@$status[1] == 200) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 * Use to get user access data
 * return array for User access data

 * */
if (!function_exists('user_access')) {

    function user_access($user_id, $permission) {
        // delete_users => To display delete user button
        // delete_newsletter => To display delete newsletter button
        // add_power_admin => To display power_admin in Type of memebership in User add
        $roles = array("power_admin" => array('delete_users',
                'delete_newsletters',
                'add_power_admin'),
            "normal_admin" => array('add_power_admin'),
        );
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_role_data = $ci->user_model->get_user_by_id($user_id);
        @$user_role = $user_role_data[0]['type_of_membership'];

        if (@in_array($permission, $roles[$user_role]))
            return true;
        else
            return false;
    }

}

/**
 * Use to get CMS block data
 * return data

 * */
if (!function_exists('cms_block')) {

    function cms_block($block_name) {
        $ci = & get_instance();
        $ci->load->model('cms_model');
        $data = $ci->cms_model->get_cms_by_block_name($block_name);
        $return = @$data[0][$ci->session->userdata('language_shortcode')];
        if (empty($return)) {
            return @$data[0]['en'];
        } else if (!empty($data[0][$ci->session->userdata('language_shortcode')])) {
            return @$data[0][$ci->session->userdata('language_shortcode')];
        } else {
            return null;
        }
    }

}

/**
 * Use to get CMS block data
 * return data

 * */
if (!function_exists('cms_help_list')) {

    function cms_help_list() {
        $ci = & get_instance();
        $ci->load->model('cms_model');
        $data = $ci->cms_model->get_cms_by_field("type", "help_page");
        return $data;
    }

}
/**
 * Use to get custom radio selected data
 * return data

 * */
if (!function_exists('custom_set_radio')) {

    function custom_set_radio($field, $value, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            // does it match the value we provided?
            if ($_POST[$field] == $value) {
                // yes, so set the checkbox
                return "checked='checked'"; // valid for both checkboxes and radio buttons
            }
        }
        // There was no POST, so check to see if the provided defaults contains our field
        elseif (!is_null($defaults) && isset($defaults)) {
            // does it match the value we provided?
            // yes, so set the checkbox
            return "checked='checked'"; // valid for both checkboxes and radio buttons
        }
    }

}
/**
 * Use to get custom selected value data
 * return data

 * */
if (!function_exists('custom_set_value')) {

    function custom_set_value($field, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            // does it match the value we provided?
            if (!empty($_POST[$field])) {
                // yes, so set the checkbox
                return $_POST[$field];
                // valid for both checkboxes and radio buttons
            }
        }
        // There was no POST, so check to see if the provided defaults contains our field
    }

}
/**
 * Use to get custom select selected data
 * return data

 * */
if (!function_exists('custom_set_select')) {

    function custom_set_select($field, $value, $defaults = null) {
        // first, check to see if the form element was POSTed
        if (isset($_POST[$field])) {
            if (!is_array($_POST[$field])) {
                // does it match the value we provided?
                if ($_POST[$field] == $value) {
                    // yes, so set the checkbox
                    return "selected='selected'";
                    // valid for both checkboxes and radio buttons
                }
            } else if (is_array($_POST[$field])) {

                $field = $_POST[$field];
                if (in_array($value, $field)) {
                    return "selected='selected'";
                }
            }
        } else {

            return "";
        }
        // There was no POST, so check to see if the provided defaults contains our field
    }

}
/**
 * Use to get seo friendly url slug from any string
 * return data

 * */
if (!function_exists('create_slug')) {

    function create_slug($phrase, $maxLength = 100000000000000) {
        $result = strtolower($phrase);

        $result = preg_replace("/[^A-Za-z0-9\s-._\/]/", "", $result);
        $result = str_replace("/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    }

}
/**
 * Use to get Youtube code from URL string
 * return data

 * */
if (!function_exists('get_youtube_code')) {

    function get_youtube_code($videolink) {
        $ytarray = explode("/", $videolink);
        $ytendstring = end($ytarray);
        $ytendarray = explode("?v=", $ytendstring);
        $ytendstring = end($ytendarray);
        $ytendarray = explode("&", $ytendstring);
        $ytcode = $ytendarray[0];
        return $ytcode;
    }

}
/**
 * Use to get view path of file
 * return file path

 * */
if (!function_exists('get_youtube_code')) {

    function get_view_path($view_name) {
        $target_file = APPPATH . 'views/' . $view_name . '.php';
        if (file_exists($target_file))
            return $target_file;
    }

}
/**
 * Use to set Free user accesses
 * return as defined

 * */
if (!function_exists('get_if_free_user')) {

    function get_if_free_user($value) {
        $ci = & get_instance();
        if (!$ci->session->userdata('is_logged_in') || $ci->session->userdata('type_of_membership') == 'FREE') {
            switch ($value) {
                case 'class_free_user':
                    $data = "free_user";
                    break;
                case 'advance_search_popup':
                    $data = 'onClick="popup(\'advance_search_popup\')"';
                    break;
                case 'class_free_user_overlay_1':
                    $data = "free_user_overlay_1";
                    break;
                case 'class_free_user_overlay_2':
                    $data = "free_user_overlay_2";
                    break;
                case 'manage_schedule_popup_2':
                    $data = 'onClick="popup(\'manage_schedule_popup_2\')"';
                    break;
                case 'class_free_user_overlay_3':
                    $data = "free_user_overlay_3";
                    break;
                case 'class_free_user_overlay_4':
                    $data = "free_user_overlay_4";
                    break;
                case 'class_free_user_overlay_5':
                    $data = "free_user_overlay_5";
                    break;
                case 'manage_schedule_popup_3':
                    $data = 'onClick="popup(\'manage_schedule_popup_3\')"';
                    break;
            }
            return $data;
        } else {
            return;
        }
    }

}
/**
 * Use to get gopremium price value
 * return file path
  for ex: array("month" => 1.99,"year" => 23.88, "final"=> 95.52,"plan" => "Premium Plan", "total_years" => "4 years", "months_in_years" => 48);
 * */
if (!function_exists('get_gopremium_price')) {

    function get_gopremium_price($mode) {
        if ($mode == 'pre1_year_4') {
            $pre1_year_4 = array("month" => 1.99, "year" => 23.88, "final" => 95.52, "plan" => "Premium Plan", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE1");
            //$pre1_year_4 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "Premium Plan", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE1");
            return $pre1_year_4;
        } else
        if ($mode == 'pre1_year_2') {
            $pre1_year_2 = array("month" => 2.79, "year" => 33.48, "final" => 66.96, "plan" => "Premium Plan", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE1");
            //$pre1_year_2 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "Premium Plan", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE1");
            return $pre1_year_2;
        } else
        if ($mode == 'pre1_year_1') {
            $pre1_year_1 = array("month" => 2.99, "year" => 35.88, "final" => 35.88, "plan" => "Premium Plan", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE1");
            //$pre1_year_1 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "Premium Plan", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE1");
            return $pre1_year_1;
        } else

        if ($mode == 'pre2_year_4') {
            $pre2_year_4 = array("month" => 5.99, "year" => 71.88, "final" => 287.52, "plan" => "XXL", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE2");
            //$pre2_year_4 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "XXL", "total_years" => "4 years", "months_in_years" => 48, "type_of_membership" => "PRE2");
            return $pre2_year_4;
        } else
        if ($mode == 'pre2_year_2') {
            $pre2_year_2 = array("month" => 6.79, "year" => 81.48, "final" => 162.96, "plan" => "XXL", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE2");
            //$pre2_year_2 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "XXL", "total_years" => "2 years", "months_in_years" => 24, "type_of_membership" => "PRE2");
            return $pre2_year_2;
        } else
        if ($mode == 'pre2_year_1') {
            $pre2_year_1 = array("month" => 6.99, "year" => 83.88, "final" => 83.88, "plan" => "XXL", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE2");
            //$pre2_year_1 = array("month" => 0.01, "year" => 0.01, "final" => 0.01, "plan" => "XXL", "total_years" => "1 year", "months_in_years" => 12, "type_of_membership" => "PRE2");
            return $pre2_year_1;
        }
    }

}
/**
 * Use to Display go premium link price value
 * return file path
 * */
if (!function_exists('show_go_premium_link')) {

    function show_go_premium_link() {
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_id = $ci->session->userdata("user_id");
        if ($user_id) {
            $user_data = $ci->user_model->get_user_by_id($user_id);
            //echo '<pre>'; print_r($user_data);
            $acepted_members = array("FREE", "PRE1");
            if (in_array($user_data[0]['type_of_membership'], $acepted_members)) {
                //$data = '<a href="'.site_url('premium-account').'">(go Premium!)</a>';
                return true;
            } else {

                return false;
            }
        } else {
            return false;
        }
    }

}
/**
 * Use to get average rate by newsletter_id
 * return file path
 * */
if (!function_exists('get_average_rate')) {

    function get_average_rate($newsletter_id) {
        $ci = & get_instance();
        $ci->load->model('newsletter_model');
        $get_rate = $ci->newsletter_model->get_rate_by_user($newsletter_id);
        $total_user_rate = count($get_rate);
        $star_1 = array();
        $star_2 = array();
        $star_3 = array();
        $star_4 = array();
        $star_5 = array();
        $avg_rate = array();
        for ($r = 0; $r < count($get_rate); $r++) {
            $avg_rate[] = $get_rate[$r]['rate'];

            if ($get_rate[$r]['rate'] <= 1) {
                $star_1[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 2) {
                $star_2[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 3) {
                $star_3[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 4) {
                $star_4[] = $get_rate[$r]["rate"];
            } else if ($get_rate[$r]['rate'] <= 5) {
                $star_5[] = $get_rate[$r]["rate"];
            }
        }
        //print_r($avg_rate);
        $s_star_1 = count($star_1);
        @$s_star_1_per = (100 * $s_star_1) / $total_user_rate;
        $s_star_1_per = !empty($s_star_1_per) ? $s_star_1_per : "0";

        $s_star_2 = count($star_2);
        @$s_star_2_per = (100 * $s_star_2) / $total_user_rate;
        $s_star_2_per = !empty($s_star_2_per) ? $s_star_2_per : "0";

        $s_star_3 = count($star_3);
        @$s_star_3_per = (100 * $s_star_3) / $total_user_rate;
        $s_star_3_per = !empty($s_star_3_per) ? $s_star_3_per : "0";

        $s_star_4 = count($star_4);
        @$s_star_4_per = (100 * $s_star_4) / $total_user_rate;
        $s_star_4_per = !empty($s_star_4_per) ? $s_star_4_per : "0";

        $s_star_5 = count($star_5);
        @$s_star_5_per = (100 * $s_star_5) / $total_user_rate;
        $s_star_5_per = !empty($s_star_5_per) ? $s_star_5_per : "0";

        $s_star_1_per = round($s_star_1_per, 2);
        $s_star_2_per = round($s_star_2_per, 2);
        $s_star_3_per = round($s_star_3_per, 2);
        $s_star_4_per = round($s_star_4_per, 2);
        $s_star_5_per = round($s_star_5_per, 2);

        $rate_sum = array_sum($avg_rate);
        @$avg = (float) $rate_sum / (int) $total_user_rate;
        $avg_round = $avg; //round(2.8, 1);
        $return_array = array("avg_round" => $avg_round);
        return $return_array;
    }

}
/**
 * Use to get memeber type
 * return file path
 * */
if (!function_exists('get_type_of_membership_txt')) {

    function get_type_of_membership_txt($type_of_membership) {
        switch ($type_of_membership) {
            case 'normal_admin':
                $type_of_membership = "Normal Admin User";
                break;
            case 'power_admin':
                $type_of_membership = "Power Admin User";
                break;
            case 'FREE':
                $type_of_membership = "Free User";
                break;
            case 'PRE1':
                $type_of_membership = "Premium User";
                break;
            case 'PRE2':
                $type_of_membership = "XXL Premium User";
                break;
            case 'PUB1':
                $type_of_membership = "Publisher type 1";
                break;
            case 'PUB2':
                $type_of_membership = "Publisher type 2";
                break;
            case 'CAAD':
                $type_of_membership = "Company account Administrator";
                break;
            case 'CAUS':
                $type_of_membership = "Company Account";
                break;
        }
        return $type_of_membership;
    }

}

/**
 * Use to get memeber type
 * return file path
 * */
if (!function_exists('get_type_of_membership_array')) {

    function get_type_of_membership_array($type_of_membership) {
        switch ($type_of_membership) {
            case 'normal_admin':
                $type_of_membership = array("go_premium" => '');
                break;
            case 'power_admin':
                $type_of_membership = array("go_premium" => '');
                break;
            case 'FREE':
                $type_of_membership = array("go_premium" => _clang(GO_PREMIUM));
                break;
            case 'PRE1':
                $type_of_membership = array("go_premium" => "Go XXL!");
                break;
            case 'PRE2':
                $type_of_membership = array();
                break;
            case 'PUB1':
                $type_of_membership = array();
                break;
            case 'PUB2':
                $type_of_membership = array();
                break;
            case 'CAAD':
                $type_of_membership = array();
                break;
            case 'CAUS':
                $type_of_membership = array();
                break;
        }
        //print_r($type_of_membership); die;
        return $type_of_membership;
    }

}
/**
 * Use to Display additional email link price value
 * return file path
 * */
if (!function_exists('show_additional_email_link')) {

    function show_additional_email_link() {
        $ci = & get_instance();
        $ci->load->model('user_model');
        $user_id = $ci->session->userdata("user_id");
        if ($user_id) {
            $user_data = $ci->user_model->get_user_by_id($user_id);
            //echo '<pre>'; print_r($user_data);
            $acepted_members = array("FREE");
            if (in_array($user_data[0]['type_of_membership'], $acepted_members)) {
                //$data = '<a href="'.site_url('premium-account').'">(go Premium!)</a>';
                return false;
            } else {

                return true;
            }
        } else {
            return false;
        }
    }

}
/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('show_meta')) {

    function show_meta() {
        $return = '';
        $ci = & get_instance();
        $user_id = $ci->session->userdata("user_id");
        $default_title = 'knewdog! - The World&#039;s Best Way to Read Newsletters.';
        $default_description = 'It`s like your own dog trained to bring your newsletters when you need them, to the place you want them... And from now on knewdog! will protect your mailbox from spam and virus.';
        $default_keyword = 'Newsletter , newsletter, get newsletter';

        if ($ci->uri->segment(1) == 'blog') {
            //Blog
            $id = $ci->uri->segment(4);
            $ci->load->model('blog_model');
            $get_data = $ci->blog_model->get_blog_by_id($id);

            $data = array(
                "title" => (!empty($get_data[0]['meta_title']) ? $get_data[0]['meta_title'] : $default_title),
                "keyword" => (!empty($get_data[0]['meta_keyword']) ? $get_data[0]['meta_keyword'] : $default_keyword),
                "description" => (!empty($get_data[0]['meta_description']) ? $get_data[0]['meta_description'] : $default_description));
        } else {
            //Default
            if ($ci->uri->segment(1)) {
                $title = ucfirst($ci->uri->segment(1)) . " Page";
            } else {
                $title = 'Home Page';
            }
            $data = array("title" => $default_title, "keyword" => $default_keyword, "description" => $default_description);
        }
        return $return .='<title>' . $data['title'] . '</title>
			<meta name="description" content="' . $data['description'] . '">
			<meta name="keywords" content="' . $data['keyword'] . '">
			<meta property="og:type" content="website" />
			<meta property="og:url" content="' . current_url() . '" />
			<meta property="og:site_name" content="knewdog!" />
			<meta name="robots" content="index, follow"/>';

        //return $return;
    }

}
/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('add_head')) {

    function add_head() {
        $ci = & get_instance();
        $session_language_shortcode = $ci->session->userdata('language_shortcode');
        $data = '<link rel="stylesheet" href="' . base_url() . '/assets/css/styles_' . $session_language_shortcode . '.css">';
        $data .="<script>
                            (function(i, s, o, g, r, a, m) {
                                i['GoogleAnalyticsObject'] = r;
                                i[r] = i[r] || function() {
                                    (i[r].q = i[r].q || []).push(arguments)
                                }, i[r].l = 1 * new Date();
                                a = s.createElement(o),
                                        m = s.getElementsByTagName(o)[0];
                                a.async = 1;
                                a.src = g;
                                m.parentNode.insertBefore(a, m)
                            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                            ga('create', 'UA-30182586-2', 'auto');
                            ga('send', 'pageview');

                                            </script>";
        return $data;
    }

}

/**
 * Use to Display Meta and title value
 * return file path
 * */
if (!function_exists('get_excerpt')) {

    function get_excerpt($str, $length = 10, $trailing = '...') {
        /*
         * * $str -String to truncate
         * * $length - length to truncate
         * * $trailing - the trailing character, default: "..."
         */
        // take off chars for the trailing
        /* $length-=mb_strlen($trailing);
          if (mb_strlen($str)> $length)
          {
          // string exceeded length, truncate and add trailing dots
          $string = mb_substr($str,0,$length).$trailing;
          return strip_tags($string);
          }
          else
          {
          // string was already short enough, return the string
          $res = strip_tags($str);
          }

          return $res; */
        /* $length = 100;
          if (strlen($str) > $length)
          {
          $str = strip_tags($str);
          $str = wordwrap($str, 100);
          $i = strpos($str, "\n");
          if ($i) {
          $str = substr($str, 0, $i);
          }
          }
          return $str; */
        $startPos = 0;
        //function getExcerpt($str, $startPos=0, $maxLength=100) {
        $str = strip_tags($str);
        if (strlen($str) > $length) {
            $excerpt = substr($str, $startPos, $length - 3);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt = substr($excerpt, 0, $lastSpace);
            $excerpt .= $trailing;
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }

    //}
}

/**
 * Use to Remove Unsubscribe words from array
 * return array
 * */
if (!function_exists('remove_unsubscribe_list')) {

    /*  function remove_unsubscribe_list($html, $replacearray) {

      if (count($replacearray)) {
      $pre_coun = array();
      for ($j = 0; $j < count($replacearray); $j++) {
      $count = 0;
      $html = str_replace($replacearray[$j], "", $html, $count);
      if ($count > 0) {
      $pre_coun[] = array($replacearray[$j], $count);
      }
      }
      }
      $return_array = array("html" => $html, "count" => $pre_coun);
      return $return_array;
      } */

    /* function remove_unsubscribe_list($html, $replacearray, $repalcewith = array( 'http://knewdog.com', '<b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b>')) {

      if (count($replacearray)) {
      $pre_coun = array();
      for ($j = 0; $j < count($replacearray); $j++) {
      $count = 0;
      $repalce = $repalcewith[$j];

      $html = str_replace($replacearray[$j], $repalce, $html, $count);
      if ($count > 0) {
      $pre_coun[] = array($replacearray[$j], $count);
      }
      }
      }
      $return_array = array("html" => $html, "count" => $pre_coun);
      return $return_array;
      } */

    function remove_unsubscribe_list($string, $replace_href = array()) {
        /* $string = preg_replace('#<a href="https?://www.youtube.*?>([^>]*)</a>#i', 'replace text', $string); */
        /* $string = str_replace("<a","<a ",str_replace("&amp;","___",str_replace("?","__",$string)));
          $pre_coun = array();
          if(count($replace_href) > 0){
          for($i=0;$i<count($replace_href);$i++){
          if(!empty($replace_href[$i])){
          $url =str_replace("&","___",str_replace("?","__",$replace_href[$i]));

          $count = 0;
          $string = preg_replace('#<a .*? href="'.$url.'.*?>([^>]*)</a>#i', '<a style="color:#3B465F;text-decoration:underline;" target="_blank" href="http://knewdog.com"><b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b></a>', $string,-1,$count);
          if ($count > 0) {
          $pre_coun[] = array($url, $count);
          }
          }
          }
          }
          $string = str_replace("__","?",str_replace("___","&",$string));
          $return_array = array("html" => $string, "count" => $pre_coun);
          return $return_array; */

        /* $string = str_replace("<a","<a ",str_replace("&amp;","___",str_replace("?","__",$string)));
          $pre_coun = array();

          if(count($replace_href) > 0){
          for($i=0;$i<count($replace_href);$i++){
          if(!empty($replace_href[$i])){
          $count = 0;
          $url =str_replace("&","___",str_replace("?","__",$replace_href[$i]));
          $string = preg_replace('#<a .*? href=".*'.$url.'.*?>([^>]*)</a>#i', '<a style="color:#3B465F;text-decoration:underline;" target="_blank" href="http://knewdog.com"><b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b></a>', $string,-1,$count);
          if ($count > 0) {
          $pre_coun[] = array($url, $count);
          }
          $count = 0;
          $string = preg_replace('#<a .*? href=".*">.*'.$url.'.*</a>#i', '<a style="color:#3B465F;text-decoration:underline;" target="_blank" href="http://knewdog.com"><b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b></a>', $string,-1,$count);

          if ($count > 0) {
          $pre_coun[] = array($url, $count);
          }
          }
          }
          }
          $string = str_replace("__","?",str_replace("___","&",$string));
          $return_array = array("html" => $string, "count" => $pre_coun);
          return $return_array; */
        $pre_coun = array();
        $second_not_exist = 0;
        if (!empty($replace_href[0])) {
            $posi = strripos($string, $replace_href[0]);
            if ($posi == true) {
                $first_link_found = true;
            } else {
                $first_link_found = false;
            }
        }
        if (!empty($replace_href[1])) {
            $posi = strripos($string, $replace_href[1]);
            if ($posi == true) {
                $second_link_found = true;
            } else {
                $second_link_found = false;
            }
        } else {
            $second_not_exist = 1;
        }

        if ($first_link_found == true && $second_not_exist == 1) {

            $pre_coun[] = array("1");
        } else if ($first_link_found == true && $second_link_found == true) {

            $pre_coun[] = array("1");
        } else {

            $pre_coun = array();
        }
        //print_r($pre_coun);
        if (count($replace_href)) {
            //$pre_coun = array();
            for ($m = 0; $m < count($replace_href); $m++) {

                $return_string = strpositionofstingdeli($string, $replace_href[$m], 0);
                //print_r($return_string);

                for ($i = 0; $i < count($return_string); $i++) {
                    $strin = ssubstr($string, 0, $return_string[$i]);
                    //echo "podiyion:";
                    $posi = strripos($strin, "<a");
                    //print_r($posi);
                    //echo "<br> new posi:";
                    if ($posi == true) {
                        $newposi = strpositionofstingdeli($string, "/a>", $posi);
                        //print_r($newposi);

                        $newstrin = ssubstr($string, $posi, ((int) $newposi[0] + 3));
                        $count = 0;
                        $string = str_replace($newstrin, '<a style="color:#3B465F;text-decoration:underline;" target="_blank" href="http://knewdog.com"><b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b></a>', $string, $count);
                        if ($count > 0) {
                            $pre_coun[] = array($count);
                        }
                    } else {

                        $count = 0;
                        $string = str_replace($replace_href[$m], '<a style="color:#3B465F;text-decoration:underline;" target="_blank" href="http://knewdog.com"><b style="color:#e46c0a;">To manage your subscriptions, visit your profile at www.knewdog.com.</b></a>', $string, $count);
                        if ($count > 0) {
                            $pre_coun[] = array($count);
                        }
                    }
                }
            }
        }
        $return_array = array("html" => $string, "count" => $pre_coun);
        return $return_array;
    }

}

/**
 * Use to Remove Unsubscribe words from array
 * return array
 * */
if (!function_exists('return_calculation')) {

    function return_calculation($end_of_subscription, $start_of_subsription, $invoice_amount) {
        $today = time();
        $end_of_subscription = strtotime($end_of_subscription);
        $start_of_subsription = strtotime($start_of_subsription);
        //$invoice_amount = 100;
        $date_1 = round(($end_of_subscription - $today) / (60 * 60 * 24));
        $date_2 = round(($end_of_subscription - $start_of_subsription) / (60 * 60 * 24));
        $calc = $invoice_amount - ($invoice_amount * 0.05);
        $return = $date_1 / $date_2 * ($calc);
        return $return;
    }

}

/**
 * Use to sort
 * return array
 * */
if (!function_exists('sortFunction')) {

    function sortFunction($a, $b) {
        return strtotime($a['MailDate']) - strtotime($b['MailDate']);
    }

}

/**
 * Use to check end on schedule
 * return
 * */
if (!function_exists('check_ends_on')) {

    function check_ends_on($array) {
        if ($array['ends'] == 'Never') {
            $data = true;
        } else if ($array['ends'] == 'after') {
            $occurance = $array['ends_after'];
            $ci = & get_instance();
            $ci->load->model('subscribe_sent_data_model');
            $get_count = $ci->subscribe_sent_data_model->get_subscribe_sent_data_by_field_value(array('subscribe_id'), array($array['subscribe_id']));
            $database_occurance = count($get_count);
            if ($database_occurance < $occurance) {
                $data = true;
            } else {
                $data = false;
            }
        } else if ($array['ends'] == 'on') {
            $ends_on = strtotime($array['ends_on']);
            $today = strtotime(date("Y-m-d"));
            if ($ends_on <= $today) {
                $data = false;
            } else {
                $data = true;
            }
        }


        return $data;
    }

}
/**
 * Use to sent_mail_subscription
  array ('email'=> $email ,'content' = $content, 'subject' => $subject)
 * return
 * */
if (!function_exists('sent_mail_subscription')) {

    function sent_mail_subscription($array) {
        $ci = & get_instance();
        $ci->load->helper('email');
        //load email library
        $ci->load->library('email');
        if (valid_email($array['email'])) {
            // compose email
            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
            $ci->email->from($get_admin_detail['email'], $get_admin_detail['name']);
            $ci->email->to($array['email']);
            $ci->email->set_mailtype("html");
            $ci->email->subject($array['subject']);
            $ci->email->message($array['content']);
            if ($ci->email->send()) {
                return true;
            } else {
                return false;
            }
        }
    }

}

/**
 * Use to send mail with attachment

 * return
 * */
if (!function_exists('send_mail_attachment')) {

    function send_mail_attachment($email, $type_of_member, $yesterday = false) {
        $ci = & get_instance();
        $ci->load->model('outgoing_email_model');
        $ci->load->model('outgoing_email_yesterday_model');
        $ci->load->model('user_model');

        if ($yesterday == true) {

            $get_email_con = $ci->outgoing_email_yesterday_model->get_outgoing_email_yesterday_by_field_value_array(array("email", "type_of_member"), array($email, $type_of_member));
        } else {
            $get_email_con = $ci->outgoing_email_model->get_outgoing_email_by_field_value_array(array("email", "type_of_member"), array($email, $type_of_member));
        }
        $ci->load->helper('email');
        //load email library
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://secure146.inmotionhosting.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@knewdog.com',
            'smtp_pass' => 'G#-(6Z{!d)LJ',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $ci->load->library('email', $config);
        $ci->email->set_newline("\r\n");
        if (valid_email($email)) {
            // compose email
            $ci->email->clear(TRUE);
            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
            //$config['protocol'] = 'sendmail';
//            $config['mailpath'] = '/usr/sbin/sendmail';
//            $config['charset'] = 'iso-8859-1';
//            $config['mailtype'] = 'html';
//            $config['priority'] = 3;
//            $ci->email->initialize($config);

            $ci->email->from("admin@knewdog.com", $get_admin_detail['name']);
            $ci->email->to($email);
            $ci->email->set_mailtype("html");
            //$ci->email->subject("knewdog! newsletter");

            $random_adds = get_random_adds($get_email_con[0]['user_id']);

            $user_data = $ci->user_model->get_user_by_id($get_email_con[0]['user_id']);
            $username = $user_data[0]['username'];
            //$link = site_url() . 'signin/mynewsletter/' . base64url_encode($user_data[0]['primary_email']); //site_url("");
            $link = '<a href="' . site_url() . '">www.knewdog.com</a>';
            if (!empty($type_of_member)) {

                if ($type_of_member == "FREE") {
                    $email_template_id = 10;
                    $replace = array('{random_ads}', '{user_name}', '{link}');
                    $with = array("{$random_adds}", "{$username}", "{$link}");
                } elseif ($type_of_member == "PRE1" || $type_of_member == "PRE2") {

                    if ($user_data[0]['no_ads'] == 'NO') {
                        $email_template_id = 11;
                        $replace = array('{random_ads}', '{user_name}', '{link}');
                        $with = array("{$random_adds}", "{$username}", "{$link}");
                    } else {
                        $email_template_id = 12;
                        $replace = array('{user_name}', '{link}');
                        $with = array("{$username}", "{$link}");
                    }
                }
            } else {
                echo "Type of member is empty";
            }
            $language_interface = $ci->user_model->get_user_by_filed_2("user.user_id", $get_email_con[0]['user_id']);
            //echo '<pre>';print_r($language_interface);
            //die;
            $session_lang = $language_interface[0]['language_shortcode']; //$this->session->userdata('language_shortcode');
            $htmlcontent = get_mail_template($replace, $with, $email_template_id, $session_lang);
            //echo $htmlcontent;exit;
            //exit;
            $ci->email->message($htmlcontent);
//echo "cmming";exit;
            $filename_array = array();
            $sent_attach = 0;
            for ($i = 0; $i < count($get_email_con); $i++) {

                $check_adult_tag = check_adult_content_tag($get_email_con[$i]['newsletter_rand_id'], $get_email_con[$i]['user_id']);
                if ($check_adult_tag == true) {

                    $htmlname = "newsletter_" . rand() . ".html";
                    $filename = FCPATH . "uploads/newsletters/" . $htmlname;
                    $myfile = fopen($filename, "w") or die("Unable to open file!");
                    $txt = $get_email_con[$i]['content'];
                    fwrite($myfile, $txt);
                    fclose($myfile);
                    $filename_array[] = $filename;

                    $ci->email->attach($filename);
                    $sent_attach++;
                }
            }
            if ($sent_attach > 0) {
                //echo "hiii";exit;
                if ($ci->email->send()) {
                    echo "<br>mail sent with attachment " . count($filename_array);
                    $return = true;
                } else {
                    echo "mail not sent";
                    $return = false;
                }
            } else {
                echo "<br>No Attachment";
                $return = false;
            }
            for ($f = 0; $f < count($filename_array); $f++) {
                @unlink($filename_array[$f]);
            }
        }
    }

}
/**
 * Returns the amount of weeks into the month a date is
 * @param $date a YYYY-MM-DD formatted date
 * @param $rollover The day on which the week rolls over
  echo week_of_month(2012-06-10) //outputs 3, for the third week of the month
 */
if (!function_exists('week_of_month')) {

    function week_of_month($timestamp) {
        $maxday = date("t", $timestamp);
        $thismonth = getdate($timestamp);
        $timeStamp = mktime(0, 0, 0, $thismonth['mon'], 1, $thismonth['year']);    //Create time stamp of the first day from the give date.
        $startday = date('w', $timeStamp);    //get first day of the given month
        $day = $thismonth['mday'];
        $weeks = 0;
        $week_num = 0;

        for ($i = 0; $i < ($maxday + $startday); $i++) {
            if (($i % 7) == 0) {
                $weeks++;
            }
            if ($day == ($i - $startday + 1)) {
                $week_num = $weeks;
            }
        }
        return $week_num;
    }

}
/*
 * *
 * Use to process daily, monthly, yearly

 * return
 * */
if (!function_exists('sending_subscribed_function')) {

    function sending_subscribed_function($get_last_ns_id_array, $result_array_3, $i, $sending) {
        $type_of_membership = $result_array_3[$i]['type_of_membership'];
        if (!empty($get_last_ns_id_array[0]['newsletter_id'])) {
            $get_last_ns_id = $get_last_ns_id_array[0]['newsletter_id'];
        } else {
            $get_last_ns_id = '';
        }
        //echo "comanlas->".$get_last_ns_id;
        $ci = & get_instance();
        $ci->load->model('outgoing_newsletter_model');
        $ci->load->model('outgoing_email_model');
        $ci->load->model('subscribe_sent_data_model');
        $newsletter_issues = $ci->newsletter_model->get_newsletter_child_issues_for_send(array('newsletter_rand_id'), array($result_array_3[$i]['newsletter_rand_id']), array(), array(), '', $get_last_ns_id, $result_array_3[$i]['subscribe_date'], $result_array_3[$i]['find_last_ns']);
        //echo "last_sent_newsletter_id->".$get_last_ns_id[0]['newsletter_id'];
        //echo '<pre> '.$sending; print_r($newsletter_issues);
        if (count($newsletter_issues) > 0) {
            $count_mail = 0;
            for ($n = 0; $n < count($newsletter_issues); $n++) {
                if (count($newsletter_issues) > 0) {

                    $mail_array = array(
                        'user_id' => $result_array_3[$i]['user_id'],
                        'newsletter_id' => $result_array_3[$i]['newsletter_id'],
                        'newsletter_rand_id' => $result_array_3[$i]['newsletter_rand_id'],
                        'email' => $result_array_3[$i]['sending_to_email'],
                        'content' => $newsletter_issues[$n]['description'],
                        'subject' => $newsletter_issues[$n]['headline'],
                        'type_of_member' => $type_of_membership);
                    $ci->outgoing_email_model->store_outgoing_email($mail_array);
                    //$uniq_mail[] = $result_array_3[$i]['sending_to_email'];
                    //$sent_mail = sent_mail_subscription($mail_array);
                    //   if ($sent_mail) {
                    $count_mail++;
                    if ($n == 0) {
                        $update_array = array("sn_of_last_newsletter" => $newsletter_issues[$n]['sn']);
                        $ci->user_model->update_user($result_array_3[$i]['user_id'], $update_array);

                        $update_outgoing = array("user_id" => $result_array_3[$i]['user_id'],
                            "newsletter_id" => $result_array_3[$i]['newsletter_id'],
                            "subscribe_id" => $result_array_3[$i]['subscribe_id'],
                            "sending" => $result_array_3[$i]['sending'],
                            "sn" => $newsletter_issues[$n]['sn'],
                            "date" => date("Y-m-d H:i:s"));

                        $ci->outgoing_newsletter_model->store_outgoing_newsletter($update_outgoing);
                    }
                    $data_to_store_sent_date = array("subscribe_id" => $result_array_3[$i]['subscribe_id'],
                        "sending" => $result_array_3[$i]['sending'],
                        "sent_flag" => "sent",
                        "date_sent" => date("Y-m-d H:i:s"),
                    );
                    $ci->subscribe_sent_data_model->store_subscribe_sent_data($data_to_store_sent_date);
                    //echo $i.") Total Mail sent ".$count_mail." sending->".$sending;
                    // } else {
                    // echo "error in Mail sent! " . $i . "<br/>";
                    //}
                } else {
                    echo "No new issues found! " . $i . "<br/>";
                }
            }
            echo $i . ") Total Mail sent " . $count_mail . " sending->" . $sending . "<br/>";
        } else {
            $data_to_store_sent_date = array("subscribe_id" => $result_array_3[$i]['subscribe_id'],
                "sending" => $result_array_3[$i]['sending'],
                "sent_flag" => "not_sent",
                "date_sent" => date("Y-m-d H:i:s"),
            );
            $ci->subscribe_sent_data_model->store_subscribe_sent_data($data_to_store_sent_date);
            echo "No new Issues found!<br/>";
        }
        //echo "mail not sent today";
    }

}

/*
 * *
 * Use to process daily, monthly, yearly

 * return
 * */
if (!function_exists('sending_subscribed_free_function')) {

    function sending_subscribed_free_function($result_array_3, $i, $newsletter_issues, $n) {
        $type_of_membership = $result_array_3[$i]['type_of_membership'];

        $ci = & get_instance();

        $ci->load->model('outgoing_email_yesterday_model');


        $mail_array = array(
            'user_id' => $result_array_3[$i]['user_id'],
            'newsletter_id' => $result_array_3[$i]['newsletter_id'],
            'newsletter_rand_id' => $result_array_3[$i]['newsletter_rand_id'],
            'email' => $result_array_3[$i]['primary_email'], //use primary except sending_to_email
            'content' => $newsletter_issues[$n]['description'],
            'subject' => $newsletter_issues[$n]['headline'],
            'type_of_member' => $type_of_membership);
        //echo "<pre>";print_r($mail_array);exit;
        $ci->outgoing_email_yesterday_model->store_outgoing_email_yesterday($mail_array);

        //echo "last_sent_newsletter_id->".$get_last_ns_id[0]['newsletter_id'];
        //echo '<pre> '.$sending; print_r($newsletter_issues);
        //echo "mail not sent today";
    }

}

/*
 * *
 * Use to increase blacklist index

 * return
 * */
if (!function_exists('increase_blacklist_index')) {

    function increase_blacklist_index($subject, $newsletter_rand_id) {
        $ci = & get_instance();
        $ci->load->model('newsletter_model');
        $ci->load->helper('email');
        //load email library
        $ci->load->library('email');
        $ci->load->model('email_template_model');
        $where_field_1 = array("newsletter_rand_id", "newsletter_relation");
        $where_value_1 = array($newsletter_rand_id, "parent");
        $newsletter_parent_data = $ci->newsletter_model->get_newsletter_by_field_array($where_field_1, $where_value_1);
        //echo '<pre>'; print_r($newsletter_parent_data); die;
        if ($newsletter_parent_data[0]['blacklist_flag'] == 'NO') {

            $where_field = array("headline", "newsletter_rand_id", "newsletter_relation");
            $where_value = array($subject, $newsletter_rand_id, "child");
            $newsletter_data = $ci->newsletter_model->get_newsletter_by_field_array($where_field, $where_value);
            //if (count($newsletter_data) > 0) {

            if (stristr($subject, 'SPAM') !== FALSE) {
                //$where_field_1 = array("newsletter_rand_id","newsletter_relation");
                //$where_value_1 = array($newsletter_rand_id,"parent");
                //$newsletter_parent_data = $ci->newsletter_model->get_newsletter_by_field_array($where_field_1,$where_value_1);
                $incresebyone = ((int) ($newsletter_parent_data[0]['blacklist_index']) + 1);
                //update blacklist index by
                $ci->newsletter_model->update_newsletter($newsletter_parent_data[0]['newsletter_id'], array("blacklist_index" => $incresebyone));
                if ($incresebyone == 10) {
                    $ci->newsletter_model->update_newsletter($newsletter_parent_data[0]['newsletter_id'], array("blacklist_flag" => 'YES'));
                }
                //return with incresing blacklist index
                $newsletter_parent_data = array();
                $newsletter_parent_data = $ci->newsletter_model->get_newsletter_by_field_array($where_field_1, $where_value_1);
                //Bhushan changes
                //sent mail to

                $blacklist_index = $newsletter_parent_data[0]['blacklist_index'];
                $blacklist_flag = $newsletter_parent_data[0]['blacklist_flag'];
                $sn = $newsletter_parent_data[0]['sn'];

//                $email = 'blacklist@knewdog.com';
                $email = 's.bhushan011@gmail.com';
                /*
                  bhushan changes
                 */
                $ci->load->helper('email');
                //load email library
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://secure146.inmotionhosting.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'admin@knewdog.com',
                    'smtp_pass' => 'G#-(6Z{!d)LJ',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $ci->load->library('email', $config);
                $ci->email->set_newline("\r\n");


                $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                $ci->email->from("admin@knewdog.com", $get_admin_detail['name']);
                $ci->email->to($email);
                $ci->email->set_mailtype("html");

                $session_lang = $ci->session->userdata('language_shortcode');
                $replace = array(
                    '{blacklist_index}',
                    '{blacklist_flag}',
                    '{sn}'
                );
                $with = array(
                    "{$blacklist_index}",
                    "{$blacklist_flag}",
                    "{$sn}");
                $email_template_content = $ci->email_template_model->get_email_template_by_id(6);
                if (isset($email_template_content[0]['description_' . $session_lang]) &&
                        !empty($email_template_content[0]['description_' . $session_lang])) {
                    $ci->email->subject($email_template_content[0]['subject_' . $session_lang]);
                    $template_content = $email_template_content[0]['description_' . $session_lang];
                    $message = str_replace($replace, $with, $template_content);
                    $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $ci->email->message($content);
                } else {
                    $this->email->subject($email_template_content[0]['subject_en']);
                    $template_content = $email_template_content[0]['description_en'];
                    $message = str_replace($replace, $with, $template_content);
                    $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $ci->email->message($content);
                }


                /*
                  end bhushan changes
                 */



//                $get_admin_detail = get_admin_detail(); //common helper function for admin detail
//                $ci->email->from($get_admin_detail['email']);
//                //echo "admin->".$get_admin_detail['email'];
//                $ci->email->to($email);
//                $ci->email->set_mailtype("html");
//                //$ci->email->subject('Your Black List flag and index for KnewDog!');
//
//                $session_lang = $ci->session->userdata('language_shortcode');
//                $replace = array(
//                    '{blacklist_index}',
//                    '{blacklist_flag}',
//                    '{sn}'
//                );
//                $with = array(
//                    "{$blacklist_index}",
//                    "{$blacklist_flag}",
//                    "{$sn}");
//                $email_template_content = $ci->email_template_model->get_email_template_by_id(6);
//                if (isset($email_template_content[0]['description_' . $session_lang]) &&
//                        !empty($email_template_content[0]['description_' . $session_lang])) {
//                    $ci->email->subject($email_template_content[0]['subject_' . $session_lang]);
//                    $template_content = $email_template_content[0]['description_' . $session_lang];
//                    $message = str_replace($replace, $with, $template_content);
//                    $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                    $ci->email->message($content);
//                } else {
//                    $this->email->subject($email_template_content[0]['subject_en']);
//                    $template_content = $email_template_content[0]['description_en'];
//                    $message = str_replace($replace, $with, $template_content);
//                    $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                    $ci->email->message($content);
//                }
                $ci->email->send();

                return true;
            } else {
                //return without incresing blacklist index
                return true;
            }
        } else {

            //Bhushan changes
            //sent mail to
            $blacklist_index = $newsletter_parent_data[0]['blacklist_index'];
            $blacklist_flag = $newsletter_parent_data[0]['blacklist_flag'];
            $sn = $newsletter_parent_data[0]['sn'];
            $email = 'blacklist@knewdog.com';

            //$message = "return false resut.. Your black list flag is " . $blacklist_flag . " and your black list index is " . $blacklist_index;
//            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
//            $ci->email->from($get_admin_detail['email']);
//            $ci->email->to($email);
//            $ci->email->set_mailtype("html");
//            //$ci->email->subject('Your Black List flag and index for KnewDog!');
//
//            $session_lang = $ci->session->userdata('language_shortcode');
//            $replace = array(
//                '{blacklist_index}',
//                '{blacklist_flag}',
//                '{sn}'
//            );
//            $with = array(
//                "{$blacklist_index}",
//                "{$blacklist_flag}",
//                "{$sn}");
//            $email_template_content = $ci->email_template_model->get_email_template_by_id(6);
//            if (isset($email_template_content[0]['description_' . $session_lang]) &&
//                    !empty($email_template_content[0]['description_' . $session_lang])) {
//                $ci->email->subject($email_template_content[0]['subject_' . $session_lang]);
//                $template_content = $email_template_content[0]['description_' . $session_lang];
//                $message = str_replace($replace, $with, $template_content);
//                $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                $ci->email->message($content);
//            } else {
//                $this->email->subject($email_template_content[0]['subject_en']);
//                $template_content = $email_template_content[0]['description_en'];
//                $message = str_replace($replace, $with, $template_content);
//                $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                $ci->email->message($content);
//            }
            /*
              bhushan changes
             */
            $ci->load->helper('email');
            //load email library
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://secure146.inmotionhosting.com',
                'smtp_port' => 465,
                'smtp_user' => 'admin@knewdog.com',
                'smtp_pass' => 'G#-(6Z{!d)LJ',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );
            $ci->load->library('email', $config);
            $ci->email->set_newline("\r\n");


            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
            $ci->email->from("admin@knewdog.com", $get_admin_detail['name']);
            $ci->email->to($email);
            $ci->email->set_mailtype("html");

            $session_lang = $ci->session->userdata('language_shortcode');
            $replace = array(
                '{blacklist_index}',
                '{blacklist_flag}',
                '{sn}'
            );
            $with = array(
                "{$blacklist_index}",
                "{$blacklist_flag}",
                "{$sn}");
            $email_template_content = $ci->email_template_model->get_email_template_by_id(6);
            if (isset($email_template_content[0]['description_' . $session_lang]) &&
                    !empty($email_template_content[0]['description_' . $session_lang])) {
                $ci->email->subject($email_template_content[0]['subject_' . $session_lang]);
                $template_content = $email_template_content[0]['description_' . $session_lang];
                $message = str_replace($replace, $with, $template_content);
                $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                $ci->email->message($content);
            } else {
                $this->email->subject($email_template_content[0]['subject_en']);
                $template_content = $email_template_content[0]['description_en'];
                $message = str_replace($replace, $with, $template_content);
                $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                $ci->email->message($content);
            }


            /*
              end bhushan changes
             */
            $ci->email->send();

//end changes
//            mail($email, "your blacklist warning from knewdog!", $message);
            return false;
        }
    }

}

/*
 * *
 * Use to check subscriobtion email

 * return
 * */
if (!function_exists('check_subscribtion_email')) {

    function check_subscribtion_email($from, $fromname) {
        $ci = & get_instance();
        $ci->load->model('newsletter_model');
        $ci->load->helper('email');
        //load email library
        $ci->load->library('email');
        $ci->load->model('email_template_model');
        $where_field_1 = array("newsletter_email", "newsletter_sender_name", "newsletter_relation");
        $where_value_1 = array($from, $fromname, "parent");
        $newsletter_parent_data = $ci->newsletter_model->get_newsletter_by_field_array($where_field_1, $where_value_1);
        //echo '<pre>'; print_r($newsletter_parent_data); die;
        if (count($newsletter_parent_data) == 0) {
            //send mail to newsletter $from address
            return false;
        } else {
            //return true
            return true;
        }
    }

}

/*
 * *
 * Use to get random adds

 * return
 * */
if (!function_exists('get_random_adds')) {

    function get_random_adds($user_id) {

        $ci = & get_instance();
        $ci->load->model('user_model');
        $ci->load->model('advertisement_model');

        $user_data = $ci->user_model->get_user_by_id($user_id);
        if ($user_data[0]['no_ads'] == 'NO') {
            if (!empty($user_data[0]['user_interests'])) {

                $user_intests_array = explode(",", $user_data[0]['user_interests']);
                $add_result = $ci->advertisement_model->get_add_from_keyword($user_intests_array);
                //echo '<pre>'; print_r($add_result); die;
                $rand_key = @array_rand($add_result, 1);
                $rand_add = @$add_result[$rand_key];
            } else {

                $add_result = $ci->advertisement_model->get_advertisement('', '', '', '', '', 'Active');
                $rand_key = array_rand($add_result, 1);
                $rand_add = $add_result[$rand_key];
            }

            if ($rand_add['advertisement_flag'] == 'advertisement_image') {
                $data = '<a href="' . $rand_add['advertisement_url'] . '"><img src="' . site_url("uploads/advertisement/" . $rand_add['advertisement_image']) . '"/></a>';
                //die;
            } else {
                $data = $rand_add['advertisement_script'];
            }
        } else {
            $data = "";
        }

        return $data;
    }

}

/**
 * Use to check_adult_content_tag

 * return true / false
 * */
if (!function_exists('check_adult_content_tag')) {

    function check_adult_content_tag($newsletter_rand_id, $user_id) {
        $ci = & get_instance();
        $ci->load->model('user_model');
        $ci->load->model('newsletter_model');

        $user_data = $ci->user_model->get_user_by_id($user_id);
        $user_adult_tag = $user_data[0]['adult_content']; // YES / NO

        $newsletter_data = $ci->newsletter_model->get_newsletter_by_field_array(array("newsletter_rand_id", "newsletter_relation"), array($newsletter_rand_id, "parent"));
        $newsletter_adult_tag = $newsletter_data[0]['adult_content']; // YES / NO

        if ($user_adult_tag == "YES") {
            return true;
        } else {
            if ($newsletter_adult_tag == "YES") {
                return false;
            } else {
                return true;
            }
        }
    }

}

/*
 * *
 * Use to get Time by time zone

 * return time
 * */
if (!function_exists('get_timeby_timezone')) {

    function get_timeby_timezone($timezone, $formate) {
        date_default_timezone_set($timezone);
        $date = date($formate);
        return $date;
    }

}
/*
 * *
 * Use to Decode UTF-8 and iso-8859-1 encoded text

 * return encoded text
 * */
if (!function_exists('decode_imap_text')) {

    function decode_imap_text($var) {
        if (preg_match("/=\?.{0,}\?[Bb]\?/", $var)) {
            $var = split("=\?.{0,}\?[Bb]\?", $var);

            while (list($key, $value) = each($var)) {
                if (preg_match("/\?=/", $value)) {
                    $arrTemp = split("\?=", $value);
                    $arrTemp[0] = base64_decode($arrTemp[0]);
                    $var[$key] = join("", $arrTemp);
                }
            }
            $var = join("", $var);
        }

        if (preg_match("/=\?.{0,}\?Q\?/", $var)) {
            $var = quoted_printable_decode($var);
            $var = preg_replace("/=\?.{0,}\?[Qq]\?/", "", $var);
            $var = preg_replace("/\?=/", "", $var);
        }
        return trim($var);
    }

}
/*
 * *
 * Use to get n month date

 * return date (Y-m-d)
 * */
if (!function_exists('get_n_months_date')) {

    function get_n_months_date($date, $monthplus) {

        //$date = "2016-01-31";
        list($year, $month, $day) = explode("-", $date);
        // add month here
        $month = $month + $monthplus;
        if ($month > 12) {
            $month = $month - 12;
            $year = $year + 1;
        }
        // to avoid a month-wrap, set the day to the number of days of the new month if it's too high
        $day = min($day, date("t", strtotime($year . "-" . $month . "-01")));
        $date = $year . "-" . $month . "-" . $day;
        return $date;
    }

}
/*
 * *
 * Use to get comment details

 * return cat_assoc_arr
 * */
if (!function_exists('getCommentDetails')) {

    function getCommentDetails($whereBlogId = "") {
        $ci = & get_instance();
        $ci->load->model('comment_model');
        $ci->load->model('user_model');
        $whereClause = " status = 'Active' and blog_id =" . $whereBlogId . "";

        $sql_query = "select * FROM comment where " . $whereClause . "";
        $query = $ci->db->query($sql_query);
        $db_cat_rs = $query->result_array();

        $cat_assoc_arr = array();
        for ($c = 0, $nc = count($db_cat_rs); $c < $nc; $c++) {
            $cat_assoc_arr[$db_cat_rs[$c]['parent_id']][] = $db_cat_rs[$c];
        }
        return $cat_assoc_arr;
    }

}
/*
 * *
 * Use to get Parent comment details

 * return cat_assoc_arr
 * */
if (!function_exists('getParentCommentList')) {

    function getParentCommentList($parent_id = 0, $old_cat = "", $iCatIdNot = "0", $loop = 1, $par_cat_array = '', $child = false, $blog_id) {

        $ci = & get_instance();
        $ci->load->model('comment_model');
        $ci->load->model('user_model');
        $cat_assoc_arr = getCommentDetails($blog_id);
        if (@is_array($cat_assoc_arr[$parent_id])) {
            foreach ($cat_assoc_arr[$parent_id] as $Pid => $db_cat_rs) {
                $field = "username";
                $value = $db_cat_rs['name'];
                $user_d = $ci->user_model->get_user_by_filed($field, $value);
                $class = ($Pid % 2 == 0) ? "odd" : "even";
                if ($child == true) {
                    $par_cat_array .= '<ul style="margin: 22px 0 0 8px;">';
                }
                $par_cat_array .= '<li class="comment ' . $class . " " . $Pid . "_" . $db_cat_rs['comment_id'] . ' childof_' . $parent_id . '">
                                            <div style="float: left; margin-right: 5px;" class="comment_avatar">';
                if (@getimagesize((site_url('uploads/avatar') . "/" . $user_d[0]['avatar']))) {
                    $par_cat_array .= '<img title="' . $db_cat_rs['name'] . '" width="25" style="width:40px; height:40px;" src="' . site_url('uploads/avatar') . "/" . $user_d[0]['avatar'] . '" />';
                } else {
                    $par_cat_array .= '<img title="' . $db_cat_rs['name'] . '" style="width:40px; height:40px;" src="' . site_url('assets/img/avatarpic.png') . '" />';
                }
                $par_cat_array .= '</div>

                                            <div class="aut">' . $db_cat_rs['name'] . '</div>
                                            <div class="comment-body">' . $db_cat_rs['comment'] . '</div>
                                            <div class="timestamp"><a style="margin:6px" class="cmt_value" href="javascript:void(0)" onclick="javascript:reply_comment(this, ' . $db_cat_rs['comment_id'] . ');" id="rply_comment">' . _clang(REPLY) . '</a></div>
                                            <div class="timestamp">' . _clang(COMMENTED) . " " . date('j, F Y', strtotime($db_cat_rs['date'])) . ' </div>';
                //echo "<br>".$Pid."->".$par_cat_array;
                $par_cat_array = getParentCommentList($db_cat_rs['comment_id'], $old_cat, $iCatIdNot, $loop + 1, $par_cat_array, true, $blog_id);
                $par_cat_array .= '</li>';
                if ($child == true) {
                    $par_cat_array .= "</ul>";
                }
            }
        }
        $old_cat = "";
        return $par_cat_array;
    }

}
/*
 * *
 * Use to get Mail Template

 * return Mail content
 * */
if (!function_exists('get_mail_template')) {

    function get_mail_template($replace = array(), $with = array(), $email_template_id, $session_lang) {

        $ci = & get_instance();
        $ci->load->model('email_template_model');
        //$session_lang = $ci->session->userdata('language_shortcode');
        /* $replace = array(
          '{user_name}',
          '{user_mail}',
          '{user_site}',
          '{user_message}',
          '{user_subject}');
          $with = array(
          "{$mail_data['username']}",
          "{$mail_data['usermail']}",
          "{$mail_data['usersite']}",
          "{$mail_data['subject']}",
          "{$mail_data['message']}"); */

        $utf = "utf-8";
        $email_template_content = $ci->email_template_model->get_email_template_by_id($email_template_id);

        if (isset($email_template_content[0]['description_' . $session_lang]) &&
                !empty($email_template_content[0]['description_' . $session_lang])) {
            $ci->email->subject($email_template_content[0]['subject_' . $session_lang]);
            $contact_content = $email_template_content[0]['description_' . $session_lang];
            $message = str_replace($replace, $with, $contact_content);
            $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
            $return_mail_content = $content;
            //$this->email->message($content);
        } else {
            $ci->email->subject($email_template_content[0]['subject_en']);
            $contact_content = $email_template_content[0]['description_en'];
            $message = str_replace($replace, $with, $contact_content);
            $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
            $return_mail_content = $content;
            //$this->email->message($content);
        }

        return $return_mail_content;
    }

}
/*
 * *
 * Use to find first day of month

 * return date Y-m-d
 * */
if (!function_exists('find_the_first_day_of_month')) {

    function find_the_first_day_of_month($date, $day_int) {
        //1 = monday,
        //$days_array = array('Sunday'=>1,'Monday'=>2,'Tuesday'=>3,'Wednesday' => 4,'Thursday' => 5, 'Friday' => 6, 'Saturday' => 7);
        $day_arry = array(2 => 1, 3 => 2, 4 => 3, 5 => 4, 6 => 5, 7 => 6, 1 => 7);
        $checkday = $day_arry[$day_int];
        $time = strtotime($date);
        $year = date('Y', $time);
        $month = date('m', $time);

        for ($day = 1; $day <= 31; $day++) {
            $time = mktime(0, 0, 0, $month, $day, $year);
            if (date('N', $time) == $checkday) {
                return date('Y-m-d', $time);
            }
        }
    }

}
//end changes
//
/*
 * *
 * Use to find first day of month

 * return date Y-m-d
 * */
if (!function_exists('summary_lang')) {

    function summary_lang($word) {
        $ci = & get_instance();
        $ci->load->model('language_keyword_model');
        $lang_data = $ci->language_keyword_model->get_language_keyword_by_field_array(array("en"), array($word));
        $session_lang = $ci->session->userdata('language_shortcode');
        if (!empty($lang_data[0][$session_lang])) {
            $data = $lang_data[0][$session_lang];
        } else {
            $data = $lang_data[0]['en'];
        }
        return $data;
    }

}
/*
 * *
 * Use to find ordinalize of int

 * return
 * */
if (!function_exists('ordinalize')) {

    function ordinalize($num) {
        $suff = 'th';
        if (!in_array(($num % 100), array(11, 12, 13))) {
            switch ($num % 10) {
                case 1: $suff = 'st';
                    break;
                case 2: $suff = 'nd';
                    break;
                case 3: $suff = 'rd';
                    break;
            }
            return "{$num}{$suff}";
        }
        return "{$num}{$suff}";
    }

}
/*
 * *
 * Use to find strpositionofstingdeli

 * return
 * */
if (!function_exists('strpositionofstingdeli')) {

    function strpositionofstingdeli($string, $toFind = "^_^", $start = 0) {
        $stringresde = array();
        $str = $string;

        //$stringresde="";
        while (($pos = strpos((trim($str)), $toFind, $start)) !== false) {
            $stringresde[] = $pos;
            $start = $pos + 1; // start searching from next position.
        }
        return $stringresde;
        //return strpos($string,$this->_searchString);
    }

}

/*
 * *
 * Use to find ssubstr

 * return
 * */
if (!function_exists('ssubstr')) {

    function ssubstr($string, $start, $end) {
        if ($end < 0)
            $length = strlen($string) + $end;
        else
            $length = $end - $start;
        return substr($string, $start, $length);
    }

}
/*
 * *
 * Use to get sitemap.xml in root folder

 * return
 * */
if (!function_exists('sitemap_generator')) {

    function sitemap_generator() {
        $ci = & get_instance();
        $ci->load->model('blog_model');
        $ci->load->model('newsletter_model');
        //echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']
        //site_url('newsletter/specific') . "/" . url_title($newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter[$i]['newsletter_id']
        //echo "hi"; die;
        $blogs = $ci->blog_model->get_blog('', '', '', '', '', 'Active', array(), array());
        $mynl_where_field = array("newsletter_relation");
        $mynl_where_value = array("parent");
        $newsletter = $ci->newsletter_model->get_newsletter('', '', '', '', '', 'Active', $mynl_where_field, $mynl_where_value);
        $data['blog'] = $blogs;
        $data['newsletter'] = $newsletter;
        $data['main_content'] = 'sitemap_view';
        header("Content-Type: text/xml;charset=iso-8859-1");
        //echo '<pre>'; print_r($data);
        //die;
        $filename = FCPATH . 'sitemap.xml';
        $xml = $ci->load->view('sitemap_view', $data, TRUE);
        $ci->load->helper('download');
        //force_download($filename, $xml);

        $ci->load->helper('file');
        write_file($filename, utf8_encode($xml));
        return true;
        //write_file($save, $backup);
        //writing to file
        //$ci->load->view('sitemap_view', $data);
        //$ci->load->view("sitemap_view",$data);
    }

}
/* $ci = & get_instance();
  $ci->load->helper('cookie'); */
/* set_cookie (array(
  'name'     => 'Session_Cookie_FB',
  'product_value'  => 'salut',
  'expire'   => '86500',
  'domain'   => NULL,
  'path'     => '/',
  ));
  $cook = get_cookie('Session_Cookie_FB');
  echo'The cookie :<pre>';
  print_r($cook); */
/* echo '</pre>';
  echo '<pre>';print_r($_COOKIE);
  echo '</pre>'; */
//end changes
/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
?>
