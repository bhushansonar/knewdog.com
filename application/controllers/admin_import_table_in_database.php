<?php

class admin_import_table_in_database extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/admin_import_table_in_database';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();


        $this->load->model('newsletter_keyword_model');
        $this->load->helper('url');
        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('kd2a2a0u1g4/login');
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/admin_import_table_in_database/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    public function add() {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation
            //$this->form_validation->set_rules('firstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[4]|is_unique[user.username]');
//            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
//            $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
//            $this->form_validation->set_rules('primary_email', 'primary E-mail', 'trim|required|valid_email|is_unique[user.primary_email]');
//            $this->form_validation->set_rules('type_of_membership', 'Type of membership', 'trim|required');
//
//            $this->form_validation->set_rules('user_interests', 'User interest', 'callback_validate_user_interests');
//            $this->form_validation->set_message('validate_keyword', 'Please select Max 10 User interest!');
//
//            $this->form_validation->set_rules('additional_email1', 'Additional E-mail 1', 'trim|valid_email');
//            $this->form_validation->set_rules('additional_email2', 'Additional E-mail 2', 'trim|valid_email');
            //$this->form_validation->set_rules('primary_email_2', 'Primary E-mail 2', 'trim|valid_email');


            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {


                if ($_FILES['excelFile']['name'] != "") {
                    $fileName = uploadFile($_FILES['excelFile'], array(".xls", ".xlsx"), "excel_file");
                    $data = new Spreadsheet_Excel_Reader();
                    $data->read('excel_file/' . $fileName);
                    for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
                        $firstname = $data->sheets[0]['cells'][$i][1];
                        $lastname = $data->sheets[0]['cells'][$i][2];
                        $mobile = $data->sheets[0]['cells'][$i][3];
                        $city = $data->sheets[0]['cells'][$i][4];
                        $query = "INSERT INTO StudentData(FirstName,LastName,MobileNo,City)
                        VALUES('" . $firstname . "','" . $lastname . "','" . $mobile . "','" . $city . "')";
                        mysql_query($query);
                    }
                }


                $data = $this->functions->do_upload('avatar', './uploads/avatar/');
                if (isset($data['upload_data'])) {
                    $file_name = $data['upload_data']['file_name'];
                } else {
                    $file_name = "";
                }
                if (is_array($this->input->post('user_interests'))) {
                    $user_interests = implode(",", $this->input->post('user_interests'));
                } else {
                    $user_interests = '';
                }
                if (is_array($this->input->post('language_id'))) {
                    $language_ids = implode(",", $this->input->post('language_id'));
                } else {
                    $language_ids = '';
                }
                $user_rand_id = $this->functions->get_user_rand_id();
                $data_to_store = array(
                    'user_rand_id' => $user_rand_id,
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->input->post('username'),
                    'password' => $this->__encrip_password($this->input->post('password')),
                    'primary_email' => $this->input->post('primary_email'),
                    'gender' => $this->input->post('gender'),
                    'avatar' => $file_name,
                    'language_interface' => $this->input->post('language_interface'),
                    'language_id' => $language_ids, //$this->input->post('language_id'),
                    'town' => $this->input->post('town'),
                    'type_of_membership' => $this->input->post('type_of_membership'),
                    'date_of_registration' => date("Y-m-d H:i:s"),
                    'last_login' => date("Y-m-d H:i:s"),
                    'zip_code' => $this->input->post('zip_code'),
                    'country' => $this->input->post('country'),
                    'user_interests' => $user_interests,
                    'additional_email1' => $this->input->post('additional_email1'),
                    'additional_email2' => $this->input->post('additional_email2'),
                    'no_ads' => $this->input->post('no_ads'),
                    'adult_content' => $this->input->post('adult_content'),
                    'privacy_settings' => $this->input->post('privacy_settings'),
                    //'primary_email_2' => $this->input->post('primary_email_2'),
                    'i_firstname' => $this->input->post('i_firstname'),
                    'i_lastname' => $this->input->post('i_lastname'),
                    'i_company_name' => $this->input->post('i_company_name'),
                    'i_street' => $this->input->post('i_street'),
                    'i_town' => $this->input->post('i_town'),
                    'i_zip_code' => $this->input->post('i_zip_code'),
                    'i_country' => $this->input->post('i_country'),
                    'account_confirmed' => 'YES',
                    'status' => $this->input->post('status')
                );
                //if the insert has returned true then we show the flash message
                if ($this->user_model->store_user($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('kd2a2a0u1g4/user/');
                    //redirect('kd2a2a0u1g4/user'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');
        $data['site_language'] = $this->site_language_model->get_language('', '', '', '', '', 'Active', '');
        $data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '', '', 'Active', '');
        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        $data['main_content'] = 'kd2a2a0u1g4/user/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

}