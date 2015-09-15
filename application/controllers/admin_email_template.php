<?php

class admin_email_template extends CI_Controller {

    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */
//     const VIEW_FOLDER = 'kd2a2a0u1g4/email_template';
    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('site_language_model');
        $this->load->model('email_template_model');
        $this->load->model('comment_model');
        $this->load->model('user_model');

        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/email_template';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session? 
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'DESC';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if (isset($filter_session_data)) {
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_products'] = $this->email_template_model->count_email_template($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['email_template'] = $this->email_template_model->get_email_template($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['email_template'] = $this->email_template_model->get_email_template($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['email_template'] = $this->email_template_model->get_email_template('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['email_template'] = $this->email_template_model->get_email_template('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['blog_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->email_template_model->count_email_template();
            $data['email_template'] = $this->email_template_model->get_email_template('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/email_template/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    /*     * check for validation */

    function array_in_string($string, $array) {

        foreach ($array as $value) {
            $status = stristr($string, $value);
            if (!$status) {
                return false;
            }
        }
        return true;
    }

    function de_variable_check() {
        $id = $this->uri->segment(4);
        if ($id == 1) {
            $data['variable'] = array('{page_url}', '{subscription_date}', '{username}');
        }
        if ($id == 2) {
            $data['variable'] = array('{user_name}', '{user_mail}', '{user_site}', '{user_message}', '{user_subject}');
        }
        if ($id == 3) {
            $data['variable'] = array('{user_name}', '{user_password}');
        }
        if ($id == 4) {
            $data['variable'] = array('{account_type}', '{cancle_username}', '{cancle_amount}', '{user_email}');
        }
        if ($id == 5) {
            $data['variable'] = array('{user}', '{c_admin_account_type}', '{amount}', '{user_email}', '{answer}');
        }
        if ($id == 6) {
            $data['variable'] = array('{blacklist_index}', '{blacklist_flag}', '{sn}');
        }
        if ($id == 7) {
            $data['variable'] = array('{type_of_membership}', '{upgrade_username}');
        }
        if ($id == 8) {
            $data['variable'] = array('{free_cancle_username}');
        }
        if ($id == 9) {
            $data['variable'] = array('{free_admin_cancle_username}', '{free_admin_cancle_user_email}', '{free_admin_cancle_account_type}', '{free_admin_cancle_answer}');
        }
        if ($id == 10) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 11) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 12) {
            $data['variable'] = array('{user_name}');
        }
        if ($id == 13) {
            $data['variable'] = array('{password}');
        }
        if ($id == 15) {
            $data['variable'] = array('{end_term_date}', '{username}', '{account_type}');
        }
        if ($id == 16) {
            $data['variable'] = array('{end_term_msg}', '{username}', '{account_type}');
        }

        $variable_value = $data['variable'];
        $description = trim(strip_tags($this->input->post('description_de')));
        $match = $this->array_in_string($description, $variable_value);
        if ($match || empty($description)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function fr_variable_check() {
        $id = $this->uri->segment(4);
        if ($id == 1) {
            $data['variable'] = array('{page_url}', '{subscription_date}', '{username}');
        }
        if ($id == 2) {
            $data['variable'] = array('{user_name}', '{user_mail}', '{user_site}', '{user_message}', '{user_subject}');
        }
        if ($id == 3) {
            $data['variable'] = array('{user_name}', '{user_password}');
        }
        if ($id == 4) {
            $data['variable'] = array('{account_type}', '{cancle_username}', '{cancle_amount}', '{user_email}');
        }
        if ($id == 5) {
            $data['variable'] = array('{user}', '{c_admin_account_type}', '{amount}', '{user_email}', '{answer}');
        }
        if ($id == 6) {
            $data['variable'] = array('{blacklist_index}', '{blacklist_flag}', '{sn}');
        }
        if ($id == 7) {
            $data['variable'] = array('{type_of_membership}', '{upgrade_username}');
        }
        if ($id == 8) {
            $data['variable'] = array('{free_cancle_username}');
        }
        if ($id == 9) {
            $data['variable'] = array('{free_admin_cancle_username}', '{free_admin_cancle_user_email}', '{free_admin_cancle_account_type}', '{free_admin_cancle_answer}');
        }
        if ($id == 10) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 11) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 12) {
            $data['variable'] = array('{user_name}');
        }
        if ($id == 13) {
            $data['variable'] = array('{password}');
        }
        if ($id == 14) {
            $data['variable'] = array('{username}', '{subscription_date}', '{page_url}');
        }
        if ($id == 15) {
            $data['variable'] = array('{end_term_date}', '{username}', '{account_type}');
        }
        if ($id == 16) {
            $data['variable'] = array('{end_term_msg}', '{username}', '{account_type}');
        }
        $variable_value = $data['variable'];
        $description = trim(strip_tags($this->input->post('description_fr')));
        $match = $this->array_in_string($description, $variable_value);
        if ($match || empty($description)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function en_variable_check() {
        $id = $this->uri->segment(4);
        if ($id == 1) {
            $data['variable'] = array('{page_url}', '{subscription_date}', '{username}');
        }
        if ($id == 2) {
            $data['variable'] = array('{user_name}', '{user_mail}', '{user_site}', '{user_message}', '{user_subject}');
        }
        if ($id == 3) {
            $data['variable'] = array('{user_name}', '{user_password}');
        }
        if ($id == 4) {
            $data['variable'] = array('{account_type}', '{cancle_username}', '{cancle_amount}', '{user_email}');
        }
        if ($id == 5) {
            $data['variable'] = array('{user}', '{c_admin_account_type}', '{amount}', '{user_email}', '{answer}');
        }
        if ($id == 6) {
            $data['variable'] = array('{blacklist_index}', '{blacklist_flag}', '{sn}');
        }
        if ($id == 7) {
            $data['variable'] = array('{type_of_membership}', '{upgrade_username}');
        }
        if ($id == 8) {
            $data['variable'] = array('{free_cancle_username}');
        }
        if ($id == 9) {
            $data['variable'] = array('{free_admin_cancle_username}', '{free_admin_cancle_user_email}', '{free_admin_cancle_account_type}', '{free_admin_cancle_answer}');
        }
        if ($id == 10) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 11) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 12) {
            $data['variable'] = array('{user_name}');
        }
        if ($id == 13) {
            $data['variable'] = array('{password}');
        }
        if ($id == 14) {
            $data['variable'] = array('{username}', '{subscription_date}', '{page_url}');
        }
        if ($id == 15) {
            $data['variable'] = array('{end_term_date}', '{username}', '{account_type}');
        }
        if ($id == 16) {
            $data['variable'] = array('{end_term_msg}', '{username}', '{account_type}');
        }

        $variable_value = $data['variable'];
        $description = trim(strip_tags($this->input->post('description_en')));
        $match = $this->array_in_string($description, $variable_value);
        if ($match) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update() {
        //product id 
        $id = $this->uri->segment(4);
        if ($id == 1) {
            $data['variable'] = array('{page_url}', '{subscription_date}', '{username}');
        }
        if ($id == 2) {
            $data['variable'] = array('{user_name}', '{user_mail}', '{user_site}', '{user_message}', '{user_subject}');
        }
        if ($id == 3) {
            $data['variable'] = array('{user_name}', '{user_password}');
        }
        if ($id == 4) {
            $data['variable'] = array('{account_type}', '{cancle_username}', '{cancle_amount}', '{user_email}');
        }
        if ($id == 5) {
            $data['variable'] = array('{user}', '{c_admin_account_type}', '{amount}', '{user_email}', '{answer}');
        }
        if ($id == 6) {
            $data['variable'] = array('{blacklist_index}', '{blacklist_flag}', '{sn}');
        }
        if ($id == 7) {
            $data['variable'] = array('{type_of_membership}', '{upgrade_username}');
        }
        if ($id == 8) {
            $data['variable'] = array('{free_cancle_username}');
        }
        if ($id == 9) {
            $data['variable'] = array('{free_admin_cancle_username}', '{free_admin_cancle_user_email}', '{free_admin_cancle_account_type}', '{free_admin_cancle_answer}');
        }
        if ($id == 10) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 11) {
            $data['variable'] = array('{random_ads}', '{user_name}');
        }
        if ($id == 12) {
            $data['variable'] = array('{user_name}');
        }
        if ($id == 13) {
            $data['variable'] = array('{password}');
        }
        if ($id == 14) {
            $data['variable'] = array('{username}', '{subscription_date}', '{page_url}');
        }
        if ($id == 15) {
            $data['variable'] = array('{end_term_date}', '{username}', '{account_type}');
        }
        if ($id == 16) {
            $data['variable'] = array('{end_term_msg}', '{username}', '{account_type}');
        }
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {


            $this->form_validation->set_rules('description_en', 'Description English ', 'required|callback_en_variable_check');
            $this->form_validation->set_message('en_variable_check', 'Variable Not Use In %s');

            $this->form_validation->set_rules('description_de', 'Description Deutsch ', 'callback_de_variable_check');
            $this->form_validation->set_message('de_variable_check', 'Variable Not Use In %s');

            $this->form_validation->set_rules('description_fr', 'Description French ', 'callback_fr_variable_check');
            $this->form_validation->set_message('fr_variable_check', 'Variable Not Use In %s');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation

            if ($this->form_validation->run() == TRUE) {
                if ($this->email_template_model->update_email_template($id, $_POST) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $this->session->set_flashdata('flash_message', 'update');

                redirect('kd2a2a0u1g4/email_template');
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code email template wel reload the current data
        //product data 
        $data['site_language'] = $this->site_language_model->get_language('', '', '', '', '', 'Active');
        $data['email_template'] = $this->email_template_model->get_email_template_by_id($id);
        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/email_template/edit';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

}
