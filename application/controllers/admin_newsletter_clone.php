<?php

class Admin_newsletter_clone extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/newsletter_clone';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('newsletter_clone_model');
        $this->load->model('newsletter_model');
        $this->load->model('user_model');
        $this->load->model('newsletter_category_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->model('newsletter_language_model');
        $this->load->helper('url');

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

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/newsletter_clone';
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
        $where_field = array('newsletter_relation');
        $where_value = array('child');

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
            $data['count_products'] = $this->newsletter_clone_model->count_newsletter_clone($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone($search_string, $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone($search_string, '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            } else {
                if ($order) {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['newsletter_clone_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_newsletter_clone'] = $this->newsletter_clone_model->count_newsletter_clone();
            $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
            $config['total_rows'] = $data['count_newsletter_clone'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        // $data['category'] = $this->newsletter_category_model->get_category('', 'category_id', 'ASC', '','');
        //$data['flash_message'] = FALSE;
        //$this->session->set_userdata('flash_message', 'add');
        //echo '<pre>';print_r($data['newsletter_clone']); die; 

        $data['main_content'] = 'kd2a2a0u1g4/newsletter_clone/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function issues() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/newsletter_clone/issues';
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
        $id = $this->uri->segment(4);
        $get_newsletter_rand_id = $this->newsletter_clone_model->get_newsletter_clone_by_field('newsletter_id', $id);
        $where_field = array('newsletter_relation', 'newsletter_rand_id');
        $where_value = array('child', $get_newsletter_rand_id[0]['newsletter_rand_id']);

        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        if ($search_string !== false && $order !== false) {

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
            $data['count_products'] = $this->newsletter_clone_model->count_newsletter_clone($search_string, $order);
            $config['total_rows'] = $data['count_products'];
            //where cause
            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone($search_string, $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone($search_string, '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            } else {
                if ($order) {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['newsletter_clone_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_newsletter_clone'] = $this->newsletter_clone_model->count_newsletter_clone();
            $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
            $config['total_rows'] = $data['count_newsletter_clone'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        // $data['category'] = $this->newsletter_category_model->get_category('', 'category_id', 'ASC', '','');
        //$data['flash_message'] = FALSE;
        //$this->session->set_userdata('flash_message', 'add');
        //echo '<pre>';print_r($data['newsletter_clone']); die; 
        //echo '<pre>'; print_r($data['newsletter_clone']); die;
        $data['get_newsletter_rand_id'] = $get_newsletter_rand_id[0]['newsletter_rand_id'];
        $data['main_content'] = 'kd2a2a0u1g4/newsletter_clone/issues';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function add() {
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            $this->form_validation->set_rules('newsletter_clone_name', 'Newsletter name', 'required');
            $this->form_validation->set_rules('headline', 'Headline', 'required');
            $this->form_validation->set_rules('newsletter_category_id[]', 'Newsletter Category', 'required|callback_validate_category');
            $this->form_validation->set_message('validate_category', 'Please select Max 3 Category!');

            $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
            $this->form_validation->set_message('validate_keyword', 'Please select Max 20 Keyword!');

            //$this->form_validation->set_rules('newsletter_category_id', 'Category Category', 'required');
            $this->form_validation->set_rules('author_name', 'Author Name', 'required');
            $this->form_validation->set_rules('website_url', 'Website URL', 'required|trim|prep_url|valid_url|xss_clean');
            $this->form_validation->set_rules('blacklist_index', 'blacklist_index', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $newletter_category_ids = implode(",", $this->input->post('newsletter_category_id'));
                if (is_array($this->input->post('newsletter_keyword_id'))) {
                    $newsletter_keyword_ids = implode(",", $this->input->post('newsletter_keyword_id'));
                } else {
                    $newsletter_keyword_ids = '';
                }
                /* if(is_array($this->input->post('language_id'))){
                  $language_ids = implode(",",$this->input->post('language_id'));
                  }else{
                  $language_ids = '';
                  } */
                $video = implode("@@@", $this->input->post('video'));
                $data = $this->functions->do_upload('screenshot');
                if (isset($data['upload_data'])) {
                    $file_name = $data['upload_data']['file_name'];
                } else {
                    $file_name = "";
                }
                $newsletter_rand_id = $this->functions->get_newsletter_rand_id();
                $sn_id = $this->functions->get_newsletter_clone_lsn_id();
                $data_to_store = array(
                    'newsletter_rand_id' => $newsletter_rand_id,
                    'sn' => $newsletter_rand_id . $sn_id,
                    'newsletter_relation' => 'parent',
                    'newsletter_email' => $this->input->post('newsletter_email'),
                    'newsletter_clone_name' => $this->input->post('newsletter_clone_name'),
                    'headline' => $this->input->post('headline'),
                    'newsletter_category_id' => $newletter_category_ids,
                    'screenshot' => $file_name,
                    'description' => addslashes($this->input->post('description')),
                    'unsubscribe_text' => $this->input->post('unsubscribe_text'),
                    'unsubscribe_url' => $this->input->post('unsubscribe_url'),
                    'author_name' => $this->input->post('author_name'),
                    'newsletter_sender_name' => $this->input->post('newsletter_sender_name'),
                    'about_author' => addslashes($this->input->post('about_author')),
                    'author_country' => $this->input->post('author_country'),
                    'author_zipcode' => $this->input->post('author_zipcode'),
                    'author_city' => $this->input->post('author_city'),
                    'video' => $video,
                    'website_url' => $this->input->post('website_url'),
                    'email' => $this->input->post('email'),
                    'newsletter_keyword_id' => $newsletter_keyword_ids,
                    'last_updated_date' => date("Y-m-d H:i:s"),
                    'added_date' => date("Y-m-d H:i:s"),
                    'adult_content' => $this->input->post('adult_content'),
                    'blacklist_index' => $this->input->post('blacklist_index'),
                    'blacklist_flag' => $this->input->post('blacklist_flag'),
                    'language_id' => $this->input->post('language_id'),
                    'frequency' => $this->input->post('frequency'),
                    'status' => $this->input->post('status')
                );
                //if the insert has returned true then we show the flash message
                if ($this->newsletter_clone_model->store_newsletter_clone($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    //Generate Newsletter Email Id
                    //last inset id
                    $newsletter_id = $this->db->insert_id();
                    $u_email = $newsletter_rand_id;
                    $u_domain = "knewdog.com";
                    $u_pass = generate_password();
                    $email = strtolower($newsletter_rand_id) . "@knewdog.com";
                    $password = encrypt($u_pass);
                    $cpanel = $this->cpanel_model->get_cpanel('', '', '', '', '', '');

                    $url = 'http://' . $cpanel[0]['username'] . ':' . decrypt($cpanel[0]['password']) . '@' . $cpanel[0]['site_domain'] . ':2082/frontend/' . $cpanel[0]['site_skin'] . '/mail/doaddpop.html?';
                    $url .= 'email=' . $u_email . '&domain=' . $u_domain . '&password=' . $u_pass . '&quota=20';
                    //http://".$cpuser.":".$cppass."@".$domain.":2082/frontend/hostmonster/mail/realdelpop.html?domain=".$domain."&email=".$email

                    /* $url2 = 'http://'.$cpanel[0]['username'].':'.decrypt($cpanel[0]['password']).'@'.$cpanel[0]['site_domain'].':2082/frontend/'.$cpanel[0]['site_skin'].'/mail/realdelpop.html?';
                      $url2 .= 'email=mar1478782n&domain='.$u_domain; */

                    $result = file_get_contents($url);
                    /* $result2 = file_get_contents($url2); */

                    if ($result == FALSE) {
                        $this->session->set_userdata('flash_message1', 'acc_error');
                        //'<div class="updated fade"><h3>account_create_error</h3><p>ERROR: Email Account not created. Please make sure you entered the correct information.</p></div>';
                    } else {
                        $this->session->set_userdata('flash_message1', 'acc_success');
                        $this->session->set_userdata('add_email', $email);
                        //echo '<div class="updated fade"><p>Account created successfully.</p></div>';
                    }
                    $data_newsletter_email_id = array(
                        'newsletter_id' => $newsletter_id,
                        'newsletter_rand_id' => $newsletter_rand_id,
                        'email' => $email,
                        'password' => $password
                    );
                    $this->newsletter_email_model->store_newsletter_email($data_newsletter_email_id);
                    //echo $url; die;
                    //Generate Newsletter Email id End

                    $this->session->set_userdata('flash_message', 'add');

                    redirect('kd2a2a0u1g4/newsletter_clone/');
                    //redirect('kd2a2a0u1g4/category'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        //load the view
        //redirect('kd2a2a0u1g4/login');

        $data['category'] = $this->newsletter_category_model->get_category('', '', 'ASC', '', '', 'Active');
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');
        $data['language'] = $this->newsletter_language_model->get_language('', '', 'ASC', '', '', 'Active');
        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        $data['main_content'] = 'kd2a2a0u1g4/newsletter_clone/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id 
        $id = $this->uri->segment(4);

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation
            /* $this->form_validation->set_rules('newsletter_clone_name', 'Newsletter name', 'required');
              $this->form_validation->set_rules('headline', 'Headline', 'required');
              //$this->form_validation->set_rules('newsletter_category_id', 'Category Category', 'required');
              $this->form_validation->set_rules('newsletter_category_id', 'Newsletter Category', 'required|callback_validate_category');
              $this->form_validation->set_message('validate_category','Please select Max 3 Category!');

              $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
              $this->form_validation->set_message('validate_keyword','Please select Max 20 Category!');
              $this->form_validation->set_rules('author_name', 'Author Name', 'required');
              $this->form_validation->set_rules('website_url', 'Website URL', 'required|trim|prep_url|valid_url|xss_clean');

              $this->form_validation->set_rules('newsletter_category_id', 'Newsletter Category', 'required|callback_validate_category');
              $this->form_validation->set_message('validate_category','Please select Max 3 Category!');

              $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
              $this->form_validation->set_message('validate_keyword','Please select Max 20 Category!'); */
            //$this->form_validation->set_rules('description', 'Description', 'trim|required');
            //$this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                /* $newletter_category_ids = implode(",",$this->input->post('newsletter_category_id'));
                  if(is_array($this->input->post('newsletter_keyword_id'))){
                  $newsletter_keyword_ids = implode(",",$this->input->post('newsletter_keyword_id'));
                  }else{
                  $newsletter_keyword_ids = '';
                  } */
                /* if(is_array($this->input->post('language_id'))){
                  $language_ids = implode(",",$this->input->post('language_id'));
                  }else{
                  $language_ids = '';
                  }
                  //$newsletter_keyword_ids = implode(",",$this->input->post('newsletter_keyword_id'));
                  $video = implode("@@@",$this->input->post('video'));


                  $data1 = $this->functions->do_upload('screenshot');
                  if (isset($data1['upload_data'])) {
                  $file_name = $data1['upload_data']['file_name'];
                  @unlink("./uploads/".$this->input->post('old_screenshot'));
                  }else{
                  $file_name = $this->input->post('old_screenshot');
                  }
                  $sn_id = $this->functions->get_newsletter_clone_lsn_id();
                  $newsletter_rand_id = $this->input->post('old_newsletter_rand_id');

                  $redirect_url = $this->input->post('redirect_url'); */
                $data_to_store = array(
                    'description' => addslashes($this->input->post('description')),
                );
                //if the insert has returned true then we show the flash message
                if ($this->newsletter_clone_model->update_newsletter_clone($id, $data_to_store) == TRUE) {
                    $this->session->set_userdata('flash_message', 'update');
                    $hidden_url_segment_5 = $this->input->post('url_segment_5');
                    //if(!empty($hidden_url_segment_5)){
                    //$redirect_url = $this->session->userdata('redirect_url');
                    redirect(current_url());
                    //redirect($redirect_url);
                    //}else{
                    //redirect($redirect_url);
                    //redirect('kd2a2a0u1g4/newsletter_clone/');
                    //}
                } else {
                    $this->session->set_userdata('flash_message', 'not_updated');
                }
                //redirect('kd2a2a0u1g4/category/update/'.$id.'');
            }//validation run
            /* $this->session->set_userdata('flash_message', 'update');
              redirect('kd2a2a0u1g4/newsletter_clone/'); */
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 

        $data['category'] = $this->newsletter_category_model->get_category('', '', 'ASC', '', '', 'Active');
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');
        $data['language'] = $this->newsletter_language_model->get_language('', '', 'ASC', '', '', 'Active');
        $data['newsletter_clone'] = $this->newsletter_clone_model->get_newsletter_clone_by_id($id);
        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        //load the view
        $url_segment_5 = $this->uri->segment(5);
        if (!empty($url_segment_5)) {
            $data['url_segment_5'] = $this->uri->segment(5);
        }
        //echo '<pre>'; print_r($data); die;
        $data['main_content'] = 'kd2a2a0u1g4/newsletter_clone/edit';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        $id = $this->uri->segment(4);
        $url_segment_5 = $this->uri->segment(5);

        $get_newsletter_relation = $this->newsletter_clone_model->get_newsletter_clone_by_field("newsletter_id", $id);
        //delete emails
        //echo $get_newsletter_relation[0]['newsletter_relation']; die;
        if (@$get_newsletter_relation[0]['newsletter_relation'] == 'parent') {

            $emails = $this->newsletter_email_model->get_newsletter_email_by_newsid($id);
            $l_email = strtolower($emails[0]['newsletter_rand_id']);

            $cpanel = $this->cpanel_model->get_cpanel('', '', '', '', '', '');
            $url2 = 'http://' . $cpanel[0]['username'] . ':' . decrypt($cpanel[0]['password']) . '@' . $cpanel[0]['site_domain'] . ':2082/frontend/' . $cpanel[0]['site_skin'] . '/mail/realdelpop.html?';
            $u_domain = "knewdog.com";
            $url2 .= 'email=' . $l_email . '&domain=' . $u_domain;
            $result2 = file_get_contents($url2);

            $this->newsletter_email_model->delete_newsletter_email_by_newsid($id);
            $this->session->set_userdata('flash_message1', 'mail_delete');
            $this->session->set_userdata('delete_mail', $emails[0]['email']);
            //delete emails end

            $this->newsletter_clone_model->delete_newsletter_clone_by_field('newsletter_rand_id', $get_newsletter_relation[0]['newsletter_rand_id']);
        } else {
            $this->newsletter_clone_model->delete_newsletter_clone($id);
        }
        $this->session->set_userdata('flash_message', 'delete');
        redirect('kd2a2a0u1g4/admin-inbox/');
    }

//edit

    public function process() {
        //product id
        $newsletter_id = $this->uri->segment(4);
        $newsletter_data = $this->newsletter_clone_model->get_newsletter_clone_by_field("newsletter_id", $newsletter_id);
        $parent_newsletter = $this->newsletter_model->get_newsletter_by_field_array(array("newsletter_rand_id", "newsletter_relation"), array($newsletter_data[0]['newsletter_rand_id'], "parent"));
        $unsubscribes = $this->newsletter_model->get_newsletter_by_id($parent_newsletter[0]['newsletter_id']);
        //echo '<pre>'; print_r($unsubscribes); die;
        $display_array = array();
        $display_array = array($unsubscribes[0]['unsubscribe_url'], $unsubscribes[0]['unsubscribe_text']);
        $return_html = remove_unsubscribe_list($newsletter_data[0]['description'], $display_array);
        //echo '<pre>'; print_r($return_html); die;

        if (count($return_html['count']) > 0) {
            $update_data = array('description' => $return_html['html']);
            $this->newsletter_clone_model->update_newsletter_clone($newsletter_id, $update_data);
            $get_clone = $this->newsletter_clone_model->get_newsletter_clone_by_id($newsletter_id);

            $sn_id = $this->functions->get_newsletter_lsn_id();
            $data_to_store = array(
                'newsletter_rand_id' => $get_clone[0]['newsletter_rand_id'],
                'sn' => $get_clone[0]['newsletter_rand_id'] . $sn_id,
                'newsletter_relation' => 'child',
                'newsletter_name' => $get_clone[0]['newsletter_name'],
                'newsletter_email' => $get_clone[0]['email'],
                'headline' => $get_clone[0]['headline'],
                'description' => $return_html['html'], //$body,//$return_html['html'],
                'author_name' => $get_clone[0]['author_name'],
                'newsletter_sender_name' => $get_clone[0]['newsletter_sender_name'],
                'email' => $get_clone[0]['email'],
                'last_updated_date' => date("Y-m-d H:i:s"),
                'added_date' => date("Y-m-d H:i:s"),
            );
            $this->newsletter_model->store_newsletter($data_to_store);
            //$this->newsletter_model->insert_one_row_by_id($newsletter_id);
            $this->newsletter_clone_model->delete_newsletter_clone($newsletter_id);
            $this->session->set_userdata('flash_message', 'add');
            redirect('kd2a2a0u1g4/admin-inbox/');
        } else {

            $this->session->set_userdata('flash_message', 'error');
            redirect('kd2a2a0u1g4/admin-inbox');
        }
    }
	
	public function process_without_check() {
        //product id
        $newsletter_id = $this->uri->segment(4);
        $newsletter_data = $this->newsletter_clone_model->get_newsletter_clone_by_field("newsletter_id", $newsletter_id);
        $parent_newsletter = $this->newsletter_model->get_newsletter_by_field_array(array("newsletter_rand_id", "newsletter_relation"), array($newsletter_data[0]['newsletter_rand_id'], "parent"));
        $unsubscribes = $this->newsletter_model->get_newsletter_by_id($parent_newsletter[0]['newsletter_id']);
        //echo '<pre>'; print_r($unsubscribes); die;
        $display_array = array();
        $display_array = array($unsubscribes[0]['unsubscribe_url'], $unsubscribes[0]['unsubscribe_text']);
        $return_html = remove_unsubscribe_list($newsletter_data[0]['description'], $display_array);
        //echo '<pre>'; print_r($return_html); die;

       // if (count($return_html['count']) > 0) {
            $update_data = array('description' => $return_html['html']);
            $this->newsletter_clone_model->update_newsletter_clone($newsletter_id, $update_data);
            $get_clone = $this->newsletter_clone_model->get_newsletter_clone_by_id($newsletter_id);

            $sn_id = $this->functions->get_newsletter_lsn_id();
            $data_to_store = array(
                'newsletter_rand_id' => $get_clone[0]['newsletter_rand_id'],
                'sn' => $get_clone[0]['newsletter_rand_id'] . $sn_id,
                'newsletter_relation' => 'child',
                'newsletter_name' => $get_clone[0]['newsletter_name'],
                'newsletter_email' => $get_clone[0]['email'],
                'headline' => $get_clone[0]['headline'],
                'description' => $return_html['html'], //$body,//$return_html['html'],
                'author_name' => $get_clone[0]['author_name'],
                'newsletter_sender_name' => $get_clone[0]['newsletter_sender_name'],
                'email' => $get_clone[0]['email'],
                'last_updated_date' => date("Y-m-d H:i:s"),
                'added_date' => date("Y-m-d H:i:s"),
            );
            $this->newsletter_model->store_newsletter($data_to_store);
            //$this->newsletter_model->insert_one_row_by_id($newsletter_id);
            $this->newsletter_clone_model->delete_newsletter_clone($newsletter_id);
            $this->session->set_userdata('flash_message', 'add_withoutcheck');
            redirect('kd2a2a0u1g4/admin-inbox/');
       // } else {

          //  $this->session->set_userdata('flash_message', 'error');
          //  redirect('kd2a2a0u1g4/admin-inbox');
       // }
    }
//edit

    public function multidelete() {
        //product id
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        $id_arr = array();
        for ($i = 0; $i < $_POST['tot_rec']; $i++) {
            if (@$_POST['row_' . $i] != '') {
                $id_arr[] = $_POST['row_' . $i];
            }
        }
        //echo '<pre>'; print_r($id_arr); die; 
        @$url_segment_5 = $this->uri->segment(4);
        for ($a = 0; $a < count($id_arr); $a++) {
            $id = $id_arr[$a];
            $get_newsletter_relation = $this->newsletter_clone_model->get_newsletter_clone_by_field("newsletter_id", $id);
            //echo '<pre>'; print_r($get_newsletter_relation); die;
            //delete emails
            //echo $get_newsletter_relation[0]['newsletter_relation']; die;
            if (@$get_newsletter_relation[0]['newsletter_relation'] == 'parent') {
                //echo "if"; die;
                $emails = $this->newsletter_email_model->get_newsletter_email_by_newsid($id);
                $l_email = strtolower($emails[0]['newsletter_rand_id']);

                $cpanel = $this->cpanel_model->get_cpanel('', '', '', '', '', '');
                $url2 = 'http://' . $cpanel[0]['username'] . ':' . decrypt($cpanel[0]['password']) . '@' . $cpanel[0]['site_domain'] . ':2082/frontend/' . $cpanel[0]['site_skin'] . '/mail/realdelpop.html?';
                $u_domain = "knewdog.com";
                $url2 .= 'email=' . $l_email . '&domain=' . $u_domain;
                $result2 = file_get_contents($url2);

                $this->newsletter_email_model->delete_newsletter_email_by_newsid($id);
                //$this->session->set_userdata('flash_message1','multi_mail_delete');
                //$this->session->set_userdata('delete_mail',$emails[0]['email']);
                //delete emails end

                $this->newsletter_clone_model->delete_newsletter_clone_by_field('newsletter_rand_id', $get_newsletter_relation[0]['newsletter_rand_id']);
            } else {
                //echo "else"; die;
                $this->newsletter_clone_model->delete_newsletter_clone($id);
            }
        }
        $this->session->set_userdata('flash_message', 'multi_delete');
        $this->session->set_userdata('delete_msg_no', count($id_arr));
        if (!empty($url_segment_5)) {
            redirect('kd2a2a0u1g4/newsletter_clone/issues/' . $url_segment_5);
        } else {
            redirect('kd2a2a0u1g4/newsletter_clone');
        }
    }

//edit

    function do_upload($filename) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($filename)) {
            $response = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
        } else {
            $response = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
        }

        return $response;
    }

    function validate_category($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 3) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_keyword($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 20) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}