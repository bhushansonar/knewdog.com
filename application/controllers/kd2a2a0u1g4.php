<?php

class kd2a2a0u1g4 extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    function index() {
        if ($this->session->userdata('is_logged_in_admin')) {
            redirect('kd2a2a0u1g4/dashboard');
        } else {
            $this->load->view('kd2a2a0u1g4/login');
        }
    }

    /**
     * encript the password 
     * @return mixed
     */
    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * check the username and the password with the database
     * @return void
     */
    function validate_credentials() {

        $this->load->model('Admin_model');

        $username = $this->input->post('username');
        $password = $this->__encrip_password($this->input->post('password'));

        $is_valid = $this->Admin_model->validate($username, $password);
        $stored_user_data = $this->Admin_model->get_user_id($username);

        $stored_userdata = json_decode(json_encode($stored_user_data), true);
        //echo '<pre>'; print_r($stored_userdata);exit;
        $user_id = $stored_userdata[0]['user_id'];
        $type_of_membership = $stored_userdata[0]['type_of_membership'];

        if ($is_valid) {

            $get_lang_a = $this->user_model->get_user_by_id($user_id);
            $last_login = $get_lang_a[0]['last_login'];
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
                'last_login' => $last_login,
                'is_logged_in' => true,
                'is_logged_in_admin' => true
            );
            $this->session->set_userdata($data);
            redirect('kd2a2a0u1g4/dashboard');
        } else { // incorrect username or password
            echo "asdfds";
            exit;
            $data['message_error'] = TRUE;
            $this->load->view('kd2a2a0u1g4/login', $data);
        }
    }

    /**
     * The method just loads the signup view
     * @return void
     */
    function signup() {
        $this->load->view('kd2a2a0u1g4/signup_form');
    }

    /**
     * Create new user and store it in the database
     * @return void
     */
    function create_member() {
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('kd2a2a0u1g4/signup_form');
        } else {
            $this->load->model('Admin_model');

            if ($query = $this->Admin_model->create_member()) {
                $this->load->view('kd2a2a0u1g4/signup_successful');
            } else {
                $this->load->view('kd2a2a0u1g4/signup_form');
            }
        }
    }

    /**
     * Destroy the session, and logout the user.
     * @return void
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('kd2a2a0u1g4');
    }

}

