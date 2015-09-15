<?php

class Home extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('email_template_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('kd2a2a0u1g4/login');
        }
    }

    function index() {
        $this->load->helper('url');
        $data['main_content'] = 'home_view';
        //echo print_r($this->session->flashdata()); die;
        $this->load->view('includes/template', $data);
    }

    function confirm() {
        $email_encode =
                $this->uri->segment(3);


        if (!empty($email_encode)) {
            $email =
                    base64url_decode($email_encode);
            $pass =
                    generate_password();

            $data_to_store =
                    array(
                        'password' => md5($pass),
                        'account_confirmed' => 'YES',
                        'status' => 'Active'
            );
            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            if (valid_email($email)) {
                // compose email
                $get_admin_detail =
                        get_admin_detail(); //common helper function for admin detail
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                /* $message = '<style>p{margin-bottom:2px;}</style>
                  <p>Your Password : '.$pass.'</p>
                  <p>Thanks,<br/>KnewDog Team.</p>'; */
                $users =
                        $this->user_model->get_user_by_filed('primary_email', $email);
                $mail_data['password'] =
                        $pass;
                $mail_data['username'] = $users[0]['username'];

                //bhushan changes
                $session_lang =
                        $this->session->userdata('language_shortcode');
                $replace =
                        array(
                            '{user_name}',
                            '{user_password}');
                $with =
                        array(
                            "{$mail_data['username']}",
                            "{$mail_data['password']}");

                $email_template_content = $this->email_template_model->get_email_template_by_id(3);
                $utf = "utf-8";
                if (isset($email_template_content[0]['description_' . $session_lang]) && !empty($email_template_content[0]['description_' . $session_lang])) {
                    $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                    $password_content = $email_template_content[0]['description_' . $session_lang];
                    $message = str_replace($replace, $with, $password_content);
                    $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $this->email->subject($email_template_content[0]['subject_en']);
                    $password_content =
                            $email_template_content[0]['description_en'];
                    $message =
                            str_replace($replace, $with, $password_content);
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }
//end changes
//							$message = $this->load->view('mail_templates/password_mail', $mail_data,true);
//						  	$this->email->message($message);
                // try send mail ant if not able print debug
                if (!$this->email->send()) {
                    $msgadd =
                            "<strong>" . _clang(EMAIL_NOT_SENT) . " </strong>"; //.$this->email->print_debugger();
                    $data['flash_message'] =
                            TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('signup');
                } else {
                    $this->user_model->delete_reminder_email_data($email);
                    if ($this->user_model->update_user_by_email($email, $data_to_store)) {
                        $data['flash_message'] =
                                TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(THANK_YOU_FOR_CONFORMING) . '</strong>');
                        redirect('home');
                        //redirect('kd2a2a0u1g4/user'.'');
                    } else {
                        $data['flash_message'] =
                                TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(OH_SNAP) . ' ' . _clang(CHANGE_A_FEW_THINGS_UP) . '</strong>');
                        redirect('signup');
                    }
                }
            }
        }
        $data['main_content'] = 'reset_password_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * encript the password
     * @return mixed
     */
    public function facebook_login() {
        $data['main_content'] =
                'home_view';
        //facebook add user and session entry process end
        $this->load->library('facebook');
        $user =
                $this->facebook->getUser();
        if (!empty($user)) {
            //echo '<pre>';print_r($user);
            $data['user_profile'] =
                    $this->facebook->api('/me');
            //echo print_r($data['user_profile']);
            $access_token =
                    $this->facebook->getAccessToken();
            $params =
                    array(
                        'next' => base_url('welcome/logout/'),
                        'access_token' => $access_token);
            $data['logout_url'] =
                    $this->facebook->getLogoutUrl($params);
            //echo '<pre>'; print_r($data);
            $get_users =
                    $this->user_model->get_user_by_filed('fb_id', $data['user_profile']['id']);
            //echo '<pre>';print_r($get_users);
            //$mail_data['username'] = $users[0]['fb_id'];
            $user_rand_id = $this->functions->get_user_rand_id();
            if (count($get_users) == 0) {
                $data_to_store =
                        array(
                            'user_rand_id' => $user_rand_id,
                            'firstname' => $data['user_profile']['first_name'], //$this->input->post('firstname'),
                            'fb_id' => $data['user_profile']['id'],
                            'lastname' => $data['user_profile']['last_name'], //$this->input->post('lastname'),
                            'username' => $data['user_profile']['username'], //$this->input->post('username'),
                            'password' => '', //$this->__encrip_password($this->input->post('password')),
                            'primary_email' => $data['user_profile']['email'],
                            'gender' => $data['user_profile']['gender'],
                            'avatar' => '', //$file_name,
                            'town' => '', //$this->input->post('town'),
                            'type_of_membership' => 'FREE', //$this->input->post('type_of_membership'),
                            'date_of_registration' => date("Y-m-d H:i:s"),
                            'last_login' => date("Y-m-d H:i:s"),
                            'zip_code' => '', //$this->input->post('zip_code'),
                            'country_code' => '', //$this->input->post('country_code'),
                            'user_interests' => '', //$this->input->post('user_interests'),
                            'additional_email1' => '', //$this->input->post('additional_email1'),
                            'additional_email2' => '', //$this->input->post('additional_email2'),
                            'no_ads' => '', //$this->input->post('no_ads'),
                            'adult_content' => '', //$this->input->post('adult_content'),
                            'privacy_settings' => '', //$this->input->post('privacy_settings'),
                            'primary_email_2' => '', //$this->input->post('primary_email_2'),
                            'i_firstname' => '', //$this->input->post('i_firstname'),
                            'i_lastname' => '', //$this->input->post('i_lastname'),
                            'i_company_name' => '', //$this->input->post('i_company_name'),
                            'i_town' => '', //$this->input->post('i_town'),
                            'i_zip_code' => '', //$this->input->post('i_zip_code'),
                            'i_country' => '', //$this->input->post('i_country'),
                            'account_confirmed' => 'YES',
                            'status' => 'Active', //$this->input->post('status')
                );
                $this->user_model->store_user($data_to_store);
            } else {
                $data_to_store =
                        array(
                            'firstname' => $data['user_profile']['first_name'], //$this->input->post('firstname'),
                            'lastname' => $data['user_profile']['last_name'], //$this->input->post('lastname'),
                            'username' => $data['user_profile']['username'], //$this->input->post('username'),
                            'primary_email' => $data['user_profile']['email'],
                            'gender' => $data['user_profile']['gender'],
                            'last_login' => date("Y-m-d H:i:s"),
                );
                $this->user_model->update_user_by_field('fb_id', $get_users[0]['fb_id'], $data_to_store);
            }
            $session =
                    array(
                        'username' => $get_users[0]['username'],
                        'user_id' => $get_users[0]['user_id'],
                        'type_of_membership' => $get_users[0]['type_of_membership'],
                        'is_logged_in' => true
            );
            $this->session->set_userdata($session);
            //facebook add user and session entry process end
            //redirect(site_url());
            $this->load->view('includes/template', $data);
        }

        $this->load->view('includes/template', $data);
    }

    public function logout() {
        //check facebook login for logout
        $url =
                $this->session->flashdata('redirect_url');
        $this->load->helper('url');
        $this->load->library('facebook');
        //setcookie('fbs_'.$this->facebook->getAppId(), '', time()-100, '/', site_url());
        //echo '<pre>';print_r($this->session->userdata);die;
        $reuired_sessiondata =
                array(
                    'session_id' => $this->session->userdata('session_id'),
                    'ip_address' => $this->session->userdata('ip_address'),
                    'user_agent' => $this->session->userdata('user_agent'),
                    'last_activity' => $this->session->userdata('last_activity'),
                    'language_shortcode' => $this->session->userdata('language_shortcode'),
        );
        $this->facebook->destroySession();
        $array_items =
                array(
                    'username' => '',
                    'user_id' => '',
                    'type_of_membership' => '',
                    'is_logged_in' => false,
                    'is_logged_in_admin' => false);
        $this->session->unset_userdata($array_items);
        //$this->session->sess_destroy();
        //set session required
        $this->session->set_userdata($reuired_sessiondata);
        $this->session->set_flashdata('flash_message', '<strong>' . _clang(YOU_ARE_NOW_LOGED_OUT) . '</strong>');
        $this->session->set_flashdata('flash_class', 'alert-success');
        //echo $this->session->flashdata('flash_message'); die;
        redirect($url);
    }

//    public function success() {
//        $this->load->model("invoice_model");
//        $this->load->helper('email');
//        //load email library
//		/*tx] => 7UV16282ML198404Y
//    [st] => Completed
//    [amt] => 0.12
//    [cc] => USD
//    [cm] =>
//    [item_number] => 25456*/
//        $this->load->library('email');
//			$tx = $_GET['tx'];
//			$item_number = $_GET['item_number'];
//			$st = $_GET['st'];
//
//
//
//        $id = $item_number;
//        $get_primary_email = $this->invoice_model->getPrimaryEmail($id);
//        $usermail = $get_primary_email[0]['email'];
//        $payment_date =date('Y-m-d H:i:s');
//
//        $data = array(
//                    "status" => $st,
//                    "payment_date" => $payment_date,
//                    "txn_id" => $tx,
//        		);
//
//		//new logic
//			if($st != 'Completed')
//			{
//				$this->session->set_flashdata('flash_class', 'alert-error');
//            	$this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Your Payment is not completed!');
//            	redirect("home");
//			}
//        if ($this->invoice_model->update_invoice_by_item_number($id, $data) ==
//                true) {
//            $get_payment_type =
//                    $this->invoice_model->get_invoice_by_field(array(
//                "item_number"), array(
//                $id));
//            $getmemebership_type = get_gopremium_price($get_payment_type[0]['payment_type']);
//            $this->user_model->update_user($get_payment_type[0]['user_id'], array(
//                "type_of_membership" => $getmemebership_type['type_of_membership']));
//            if ($this->session->userdata('is_logged_in')) {
//                $this->session->unset_userdata(array(
//                    'type_of_membership' => '',
//                ));
//                $session =
//                        array(
//                            'type_of_membership' => $getmemebership_type['type_of_membership'],
//                );
//                //bhushan changes
//                if (valid_email($usermail)) {
//
//                    // compose email
//                    $get_admin_detail = get_admin_detail(); //common helper function for admin detail
//                    $this->email->from($get_admin_detail['email']);
//                    $this->email->to($usermail);
//                    $this->email->set_mailtype("html");
//                    $this->email->subject('Account upgrade confirmation');
//
//                    $session_lang = $this->session->userdata('language_shortcode');
//                    $type_membership = get_type_of_membership_txt($session['type_of_membership']);
//                    $user_name = $get_primary_email[0]['first_name'];//$_POST['first_name'];
//                    $replace = array('{upgrade_username}', '{type_of_membership}');
//                    $with = array("{$user_name}", "{$type_membership}");
//                    $email_template_content = $this->email_template_model->get_email_template_by_id(7);
//                    if (isset($email_template_content[0]['description_' . $session_lang]) &&
//                            !empty($email_template_content[0]['description_' . $session_lang])) {
//                        $template_content = $email_template_content[0]['description_' . $session_lang];
//                        $message = str_replace($replace, $with, $template_content);
//                        $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                        $this->email->message($content);
//                    } else {
//                        $template_content = $email_template_content[0]['description_en'];
//                        $message = str_replace($replace, $with, $template_content);
//                        $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
//                        $this->email->message($content);
//                    }
//
//                    //echo "<pre>";print_r($session['type_of_membership']);
//                    if (!$this->email->send()) {
////                    show_error($this->email->print_debugger());
//                        $msgadd = "<strong>" . _clang(EMAIL_NOT_SENT) . " </strong>"; //.$this->email->print_debugger();
//                        $data['flash_message'] = TRUE;
//                        $this->session->set_flashdata('flash_class', 'alert-error');
//                        $this->session->set_flashdata('flash_message', $msgadd);
//                        redirect("home");
//                    }
//
//                    $this->session->set_userdata($session);
//                } else {
//                    if ($redirect == 'home') {
//                        $this->session->set_flashdata('validation_error_messages', validation_errors());
//                        redirect('home');
//                    }
//                }
////end changes
//            }
//
//            $this->session->set_flashdata('flash_class', 'alert-success');
//            $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELL_DONE) . '</strong> ' . _clang(YOUR_PAYMENT_COMPLETE) . '');
//            redirect("home");
//        }
//    }
    public function success() {
        $this->load->model("invoice_model");
        $this->load->helper('email');
        //load email library
        $this->load->library('email');
//        echo '<pre>'; print_r($_REQUEST); die;
        $id = $_POST['item_number'];
        $get_primary_email = $this->invoice_model->getPrimaryEmail($id);
        $usermail = $get_primary_email[0]['email'];
        $payment_date =
                date('Y-m-d H:i:s', strtotime($_POST['payment_date']));

        $data =
                array(
                    "status" => $_POST['payment_status'],
                    "payment_date" => $payment_date,
                    "txn_id" => $_POST["txn_id"],
        );


        if ($this->invoice_model->update_invoice_by_item_number($id, $data) == true) {
            $get_payment_type =
                    $this->invoice_model->get_invoice_by_field(array(
                "item_number"), array(
                $id));
            $getmemebership_type =
                    get_gopremium_price($get_payment_type[0]['payment_type']);
            $this->user_model->update_user($get_payment_type[0]['user_id'], array(
                "type_of_membership" => $getmemebership_type['type_of_membership']));
            if ($this->session->userdata('is_logged_in')) {
                $this->session->unset_userdata(array(
                    'type_of_membership' => '',
                ));
                $session =
                        array(
                            'type_of_membership' => $getmemebership_type['type_of_membership'],
                );
                //bhushan changes
                if (valid_email($usermail)) {

                    // compose email
                    $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                    $this->email->from($get_admin_detail['email']);
                    $this->email->to($usermail);
                    $this->email->set_mailtype("html");
                    $session_lang = $this->session->userdata('language_shortcode');
                    $type_membership = get_type_of_membership_txt($session['type_of_membership']);
                    $user_name = $_POST['first_name'];
                    $replace = array('{upgrade_username}', '{type_of_membership}');
                    $with = array("{$user_name}", "{$type_membership}");
                    $email_template_content = $this->email_template_model->get_email_template_by_id(7);
                    if (isset($email_template_content[0]['description_' . $session_lang]) &&
                            !empty($email_template_content[0]['description_' . $session_lang])) {
                        $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                        $template_content = $email_template_content[0]['description_' . $session_lang];
                        $message = str_replace($replace, $with, $template_content);
                        $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    } else {
                        $this->email->subject($email_template_content[0]['subject_en']);
                        $template_content = $email_template_content[0]['description_en'];
                        $message = str_replace($replace, $with, $template_content);
                        $content = "<html><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    }

                    //echo "<pre>";print_r($session['type_of_membership']);
                    if (!$this->email->send()) {
//                    show_error($this->email->print_debugger());
                        $msgadd = "<strong>" . _clang(EMAIL_NOT_SENT) . " </strong>"; //.$this->email->print_debugger();
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', $msgadd);
                        redirect("home");
                    }

                    $this->session->set_userdata($session);
                } else {
                    if ($redirect == 'home') {
                        $this->session->set_flashdata('validation_error_messages', validation_errors());
                        redirect('home');
                    }
                }
//end changes
            }
            $this->session->set_flashdata('flash_class', 'alert-success');
            $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELL_DONE) . '</strong> ' . _clang(YOUR_PAYMENT_COMPLETE) . '');
            redirect("home");
        }
    }

    public function cancel() {
        $this->session->set_flashdata('flash_class', 'alert-error');
        $this->session->set_flashdata('flash_message', '<strong>' . _clang(OH_SNAP) . '</strong> ' . _clang(YOUR_PAYMENT_HAS) . '');
        redirect("home");
    }

}
