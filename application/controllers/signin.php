<?php

class Signin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('email_template_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * * Check if the user is logged in, if he's not, 
     * * send him to the login page
     * * @return void
     * */
    function index() {
        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * * 
     * * @return mixed
     * */

    /**
     * encript the password 
     * @return mixed
     */
    function __encrip_password($password) {
        return md5($password);
    }

    function validate_credentials() {
        if (empty($this->session->userdata['username'])) {
            $this->load->model('Admin_model');

            $username = $this->input->post('username');
            $password = $this->__encrip_password($this->input->post('password'));
            $is_valid = $this->Admin_model->validate($username, $password);
            $stored_user_data = $this->Admin_model->get_user_id($username);

            $stored_userdata = json_decode(json_encode($stored_user_data), true);
            //echo '<pre>'; print_r($stored_userdata);
            $user_id = $stored_userdata[0]['user_id'];
            $type_of_membership = $stored_userdata[0]['type_of_membership'];
            if ($is_valid) {
                $data = array(
                    'username' => $username,
                    'user_id' => $user_id,
                    'type_of_membership' => $type_of_membership,
                    'is_logged_in' => true,
                );
                $this->session->set_userdata($data);
                redirect('home');
            } else { // incorrect username or password
                $data['login_error'] = '<strong>ohh snap!</strong> Wrong Username or password!';
                $data['open_popup'] = 'signin';
                $data['main_content'] = 'home_view';
                $this->load->view('includes/template', $data);
                //$this->load->view('home_view', $data);	
            }
        } else {
            $data['login_error'] = '<strong>ohh snap!</strong> Already Login please logout!';
            $data['open_popup'] = 'signin';
            $data['main_content'] = 'home_view';
            $this->load->view('includes/template', $data);
        }
    }

    function validate_credentials_front() {
        //echo "hiiii";exit;
        if (empty($this->session->userdata['username'])) {
            $this->load->model('Admin_model');

            $username = $this->input->post('username');
            $password = $this->__encrip_password($this->input->post('password'));
            //$email = $this->input->post('email');
//            echo "<pre>";
//            print_r($_POST);
//            exit;
            $is_valid = $this->Admin_model->validate_front($username, $password);
            if ($is_valid) {

                $stored_user_data = $this->Admin_model->get_user_id($username);

                $stored_userdata = json_decode(json_encode($stored_user_data), true);
                //echo '<pre>'; print_r($stored_userdata);
                $user_id = $stored_userdata[0]['user_id'];
                $type_of_membership = $stored_userdata[0]['type_of_membership'];

                $get_lang_a = $this->user_model->get_user_by_id($user_id);
                $get_lang1 = $get_lang_a[0]['language_shortcode'];
                $last_login = $get_lang_a[0]['last_login'];
                $get_lang = !empty($get_lang1) ? $get_lang1 : 'en';

                if ($get_lang_a[0]['last_login'] == '0000-00-00 00:00:00') {
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELCOME_TO_KNEWDOG_FOR) . ' <a href="javascript:void(0)" onclick="submitform(\'gotoaccountsetting\')">' . _clang(CHANGE_PASSWORD) . '</a>.</strong><form id="gotoaccountsetting" action="' . site_url('myknewdog') . '" method="post"><input type="hidden" name="form" value="section_4" /></form>');
                } else {
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELCOME_TO_KNEWDOG) . '</strong>');
                }
                $user_data = array(
                    'last_login' => date("Y-m-d H:i:s"),
                );
                $this->user_model->update_user($user_id, $user_data);
                $data = array(
                    'username' => $username,
                    'user_id' => $user_id,
                    'type_of_membership' => $type_of_membership,
                    'language_shortcode' => $get_lang,
                    'last_login' => $last_login,
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                $redirect_url = $this->session->flashdata('redirect_url');
                //echo $this->session->flashdata('flash_message'); die;
                //echo $this->uri->segment(2); die;
                if (strpos($redirect_url, 'validate_credentials_front') !== false) {
                    //echo $this->uri->segment(2)." ".$redirect_url; die;
                    redirect('home');
                } else {
                    //echo $redirect_url;
                    //echo $this->session->flashdata('flash_message'); die;
                    redirect($redirect_url);
                }
                //redirect('home');
            } else { // incorrect username or password
                $data['login_error'] = '<strong>ohh snap!</strong> Wrong Username or password!';
                $data['open_popup'] = 'signin';
                $data['main_content'] = 'home_view';
                $this->load->view('includes/template', $data);
                //$this->load->view('home_view', $data);	
            }
        } else {
            $data['login_error'] = '<strong>ohh snap!</strong> Already Login please logout!';
            $data['open_popup'] = 'signin';
            $data['main_content'] = 'home_view';
            $this->load->view('includes/template', $data);
        }
    }

    public function mynewsletter() {

        $decodeemail = $this->uri->segment(3);

        $primary_email = base64url_decode($decodeemail);
        $user_data = $this->user_model->get_user_by_filed_2('primary_email', $primary_email);

        $username = $user_data[0]['username'];
        $user_id = $user_data[0]['user_id'];
        $type_of_membership = $user_data[0]['type_of_membership'];
        $get_lang = $user_data[0]['language_shortcode'];
        $last_login = $user_data[0]['last_login'];
        if (empty($get_lang)) {
            $get_lang = 'en';
        }
        $data = array(
            'username' => $username,
            'user_id' => $user_id,
            'type_of_membership' => $type_of_membership,
            'language_shortcode' => $get_lang,
            'last_login' => $last_login,
            'is_logged_in' => true
        );
        echo '<pre>';
        print_r($data);
        $this->session->set_userdata($data);

        redirect("myknewdog");
    }

    public function facebook() {
        $this->load->library('facebook');

        $user = $this->facebook->getUser();
        // echo '<pre>';print_r($user);
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
                $access_token = $this->facebook->getAccessToken();
                //$params = array('next' => base_url('welcome/logout/'), 'access_token' => $access_token);
                //$data['logout_url'] = $this->facebook->getLogoutUrl($params);
                //echo '<pre>'; print_r($data);
            } catch (FacebookApiException $e) {
                $user = null;
            }
            /* $this->session->set_flashdata('flash_class','alert-error');
              $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> You alreay login throw Facebook.');
              redirect(site_url()); */
        } else {

            $this->facebook->destroySession();
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('home/facebook_login'), //$_SERVER['HTTP_REFERER'],//site_url(), 
                'scope' => array("email") // permissions here
            ));
            $login_url = $data['login_url'];
            redirect($data['login_url']);
        }

        //$data = $data['login_url'];
    }

    public function google() {

        $this->load->helper('url');
        $ci = & get_instance();
        $ci->load->config('google');
        $google_client_id = $ci->config->item('google_client_id');
        $google_client_secret = $ci->config->item('google_client_secret');
        $google_redirect_url = $ci->config->item('google_redirect_url'); //path to your script
        $google_developer_key = $ci->config->item('google_developer_key');

        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_Oauth2Service.php';
        //$this->load->library('Google_Oauth2Service');
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

        //If code is empty, redirect user to google authentication page for code.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.
        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            //echo $_SESSION['token'];
            //redirect($google_redirect_url);
            //return;
        }


        if (isset($_SESSION['token'])) {
            $_SESSION['token'];
            $gClient->setAccessToken($_SESSION['token']);
        }


        if ($gClient->getAccessToken()) {
            //For logged in user, get details from google using access token
            $data['guser'] = $google_oauthV2->userinfo->get();
            $data['guser_id'] = $data['guser']['id'];
            $data['guser_name'] = filter_var($data['guser']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $data['gemail'] = filter_var($data['guser']['email'], FILTER_SANITIZE_EMAIL);
            $data['gprofile_url'] = filter_var($data['guser']['link'], FILTER_VALIDATE_URL);
            $data['gprofile_image_url'] = filter_var($data['guser']['picture'], FILTER_VALIDATE_URL);
            $data['gpersonMarkup'] = "$email<div><img alt='profile image' src='$gprofile_image_url?sz=50'></div>";

            $this->session->set_userdata(array('token' => $gClient->getAccessToken()));
            //print_r($data['guser']); die;
            //$_SESSION['token']
        } else {
            //For Guest user, get google login url
            $data['authUrl'] = $gClient->createAuthUrl();
        }

        $data['main_content'] = 'home_view';
        $this->load->view('includes/template', $data);
    }

    function forgot_password() {
        $this->load->helper('email');
        //load email library
        $this->load->library('email');
        $primary_email = $this->input->post('email');
        $password = generate_password();
        //$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->load->model('Admin_model');
        if ($this->form_validation->run()) {
            $is_valid = $this->Admin_model->validate_email_front($primary_email);

            if ($is_valid) {

                $get_admin_detail = get_admin_detail(); //common helper function for admin detail

                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($primary_email);
                $this->email->set_mailtype("html");
//                    $this->email->subject('Your New Password for knewdog!');
                //bhushan changes    
//                $username = $this->input->post('username');
//                $subscription_date = date("Y-m-d");
//                $formated_subscription_date = date("jS F, Y", strtotime($subscription_date));
                $session_lang = $this->session->userdata('language_shortcode');
                $replace = array('{password}');
                $with = array("{$password}");
                $utf = "utf-8";

                $email_template_content = $this->email_template_model->get_email_template_by_id(13);
//                echo "<pre>";print_r($email_template_content);exit;
                if (isset($email_template_content[0]['description_' . $session_lang]) &&
                        !empty($email_template_content[0]['description_' . $session_lang])) {
                    $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                    $template_content = $email_template_content[0]['description_' . $session_lang];
                    $message = str_replace($replace, $with, $template_content);
                    $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $this->email->subject($email_template_content[0]['subject_en']);
                    $template_content = $email_template_content[0]['description_en'];
                    $message = str_replace($replace, $with, $template_content);
                    $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }
                //end changes


                if (!$this->email->send()) {
//                    show_error($this->email->print_debugger());
                    $msgadd = "<strong>Email not send </strong>"; //.$this->email->print_debugger();  
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    if ($redirect == 'home') {
                        redirect('home');
                    } else {
                        redirect('signup');
                    }
                } else {
                    $data_to_store = array(
                        'password' => md5($password),
                    );

                    if ($this->Admin_model->update_password($primary_email, $data_to_store)) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELL_DONE) . '</strong> ' . _clang(WE_SENT_YOU_PASSWORD) . '');
                        redirect('signup');
                        //redirect('kd2a2a0u1g4/user'.'');
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(OH_SNAP) . '</strong> ' . _clang(CHANGE_A_FEW_THINGS_UP) . '');
                        redirect('signup');
                    }
                }
            } else {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Not Match your Email please Put correct email ');
                redirect('signin/forgot_password');

                //$this->load->view('home_view', $data);	
            }
        }
        $data['main_content'] = 'forgot_password_view';
        $this->load->view('includes/template', $data);
    }

}

