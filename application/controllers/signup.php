<?php

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('email_template_model');


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
    function create_member() {
        $this->load->library('form_validation');

        // field name, error message, validation rules
        //$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[4]|is_unique[user.username]');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[user.primary_email]');
        $this->form_validation->set_message('is_unique', 'The %s is already taken! Please choose another.');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
        if ($this->input->post('redirect')) {
            $redirect = $this->input->post('redirect');
        } else {
            $redirect = '';
        }
        if ($this->form_validation->run()) {

            $pass = generate_password();
            $email = $this->input->post('email');
            $user_rand_id = $this->functions->get_user_rand_id();
            $data_to_store = array(
                'user_rand_id' => $user_rand_id,
                'username' => $this->input->post('username'),
                'password' => md5($pass),
                'primary_email' => $email,
                'gender' => 'Neutral',
                'type_of_membership' => 'FREE',
                'date_of_registration' => date("Y-m-d H:i:s"),
                'status' => 'Inactive'
            );
            //if the insert has returned true then we show the flash message

            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            if (valid_email($email)) {
                // compose email
                $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                $session_lang = $this->session->userdata('language_shortcode');
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                
                $mail_data['url'] = '<a href="' . site_url() . 'home/confirm/' . base64url_encode($email) . '">www.knewdog.com/confirm</a>';

                //bhushan changes    
                $username = $this->input->post('username');
                $subscription_date = date("Y-m-d");
                $formated_subscription_date = date("jS F, Y", strtotime($subscription_date));
                
                $replace = array('{page_url}', '{subscription_date}', '{username}');
                $with = array("{$mail_data['url']}", "{$formated_subscription_date}", "{$username}");
                $utf = "utf-8";
                $email_template_content = $this->email_template_model->get_email_template_by_id(1);
                if (isset($email_template_content[0]['description_' . $session_lang]) && !empty($email_template_content[0]['description_' . $session_lang])) {
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
//                
//							$message = $this->load->view('mail_templates/signup_mail', $mail_data,true); 
//						  	$this->email->message($message);
                // try send mail ant if not able print debug

                if (!$this->email->send()) {
//                    show_error($this->email->print_debugger());
                    $msgadd = "<strong>" . _clang(EMAIL_NOT_SENT_FOR_REGISTER) . " </strong>"; //.$this->email->print_debugger();  
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    if ($redirect ==
                            'home') {
                        redirect('home');
                    } else {
                        redirect('signup');
                    }
                } else {
                    $store_data = array(
                        'from' => $get_admin_detail['email'],
                        'to' => $email,
                        'subject' => 'Please confirm your account on knewdog!',
                        'date' => date('Y-m-d'),
                        'compare_date' => date('Y-m-d')
                    );
                    $this->user_model->store_reminder_email_data($store_data);
                    if ($this->user_model->store_user($data_to_store)) {

                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELL_DONE) . '</strong> ' . _clang(WE_HAVE_SENT_YOU_A_LINK) . '');
                        if ($redirect ==
                                'home') {
                            redirect('home');
                        } else {
                            redirect('signup');
                        }
                        //redirect('kd2a2a0u1g4/user'.'');
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>' . _clang(OH_SNAP) . '</strong> ' . _clang(CHANGE_A_FEW_THINGS_UP) . '');
                        if ($redirect ==
                                'home') {
                            redirect('home');
                        } else {
                            redirect('signup');
                        }
                    }
                }
            }
        } else {
            if ($redirect ==
                    'home') {
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                redirect('home');
            }
        }

        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    function set_password() {

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
        if ($this->form_validation->run()) {
            $email = base64url_decode($this->input->post('email'));
            $data_to_store = array(
                'password' => md5($this->input->post('password')),
                'account_confirmed' => 'YES',
                'status' => 'Active'
            );
            if ($this->user_model->update_user_by_email($email, $data_to_store)) {
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
    }

}
