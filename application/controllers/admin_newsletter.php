<?php

class Admin_newsletter extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/newsletter';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('newsletter_model');
        $this->load->model('user_model');
        $this->load->model('newsletter_category_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->model('newsletter_language_model');
        $this->load->model('subscribe_model');
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

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/newsletter';
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
        $where_value = array('parent');

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
            $data['count_products'] = $this->newsletter_model->count_newsletter($search_string, $order, $where_field, $where_value);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter($search_string, $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter($search_string, '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            } else {
                if ($order) {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter('', $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['newsletter_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_newsletter'] = $this->newsletter_model->count_newsletter('', '', $where_field, $where_value);
            $data['newsletter'] = $this->newsletter_model->get_newsletter('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
//            echo "<pre>";
//            print_r($data['newsletter']);
//            exit;
            $config['total_rows'] = $data['count_newsletter'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        // $data['category'] = $this->newsletter_category_model->get_category('', 'category_id', 'ASC', '','');
        //$data['flash_message'] = FALSE;
        //$this->session->set_userdata('flash_message', 'add');
        //echo '<pre>';print_r($data['newsletter']); die;

        $data['main_content'] = 'kd2a2a0u1g4/newsletter/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function issues() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');
        $id = $this->uri->segment(4);
        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/newsletter/issues/' . $id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['uri_segment'] = 5;

        //limit end
        $page = $this->uri->segment(5);

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
        $get_newsletter_rand_id = $this->newsletter_model->get_newsletter_by_field('newsletter_id', $id);
//        echo "<pre>";
//        print_r($get_newsletter_rand_id);
//        exit;
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
            $data['count_products'] = $this->newsletter_model->count_newsletter($search_string, $order, $where_field, $where_value);
            $config['total_rows'] = $data['count_products'];
            //where cause
            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter($search_string, $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter($search_string, '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            } else {
                if ($order) {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter('', $order, $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                } else {
                    $data['newsletter'] = $this->newsletter_model->get_newsletter('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['newsletter_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_newsletter'] = $this->newsletter_model->count_newsletter('', '', $where_field, $where_value);
            $data['newsletter'] = $this->newsletter_model->get_newsletter('', '', $order_type, $config['per_page'], $limit_end, '', $where_field, $where_value);
//            echo "<pre>";
//            print_r($data['newsletter']);
//            exit;
            $config['total_rows'] = $data['count_newsletter'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
//       echo "<pre>";
//              print_r($config);exit;
        $this->pagination->initialize($config);

        //load the view
        // $data['category'] = $this->newsletter_category_model->get_category('', 'category_id', 'ASC', '','');
        //$data['flash_message'] = FALSE;
        //$this->session->set_userdata('flash_message', 'add');
        //echo '<pre>';print_r($data['newsletter']); die;
        //echo '<pre>'; print_r($data['newsletter']); die;
        $data['get_newsletter_rand_id'] = @$get_newsletter_rand_id[0]['newsletter_rand_id'];
        $data['main_content'] = 'kd2a2a0u1g4/newsletter/issues';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function add() {
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            $this->form_validation->set_rules('newsletter_name', 'Newsletter name', 'required');
            $this->form_validation->set_rules('headline', 'Headline', 'required');
            $this->form_validation->set_rules('newsletter_category_id[]', 'Newsletter Category', 'required|callback_validate_category');
            $this->form_validation->set_message('validate_category', 'Please select Max 3 Category!');

            $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
            $this->form_validation->set_message('validate_keyword', 'Please select Max 20 Keyword!');

            //$this->form_validation->set_rules('newsletter_category_id', 'Category Category', 'required');
            $this->form_validation->set_rules('author_name', 'Author Name', 'required');
            $this->form_validation->set_rules('newsletter_sender_name', 'From Name', 'required');
            //$this->form_validation->set_rules('website_url', 'Website URL', 'required|trim|prep_url|valid_url|xss_clean');
            $this->form_validation->set_rules('blacklist_index', 'blacklist_index', 'required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            if (isset($_POST['adult_content'])) {
                $adult_content = $this->input->post('adult_content');
            } else {
                $adult_content = 'NO';
            }
            if (isset($_POST['blacklist_flag'])) {
                $blacklist_flag = $this->input->post('blacklist_flag');
            } else {
                $blacklist_flag = 'NO';
            }


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
                $sn_id = $this->functions->get_newsletter_lsn_id();
                $data_to_store = array(
                    'newsletter_rand_id' => $newsletter_rand_id,
                    'sn' => $newsletter_rand_id . $sn_id,
                    'newsletter_relation' => 'parent',
                    'newsletter_email' => $this->input->post('newsletter_email'),
                    'newsletter_name' => $this->input->post('newsletter_name'),
                    'headline' => $this->input->post('headline'),
                    'newsletter_category_id' => $newletter_category_ids,
                    'newsletter_sender_name' => $this->input->post('newsletter_sender_name'),
                    'screenshot' => $file_name,
                    'description' => $this->input->post('description'),
                    'unsubscribe_text' => $this->input->post('unsubscribe_text'),
                    'unsubscribe_url' => $this->input->post('unsubscribe_url'),
                    'author_name' => $this->input->post('author_name'),
                    'about_author' => $this->input->post('about_author'),
                    'author_country' => $this->input->post('author_country'),
                    'author_zipcode' => $this->input->post('author_zipcode'),
                    'author_city' => $this->input->post('author_city'),
                    'video' => $video,
                    'website_url' => $this->input->post('website_url'),
                    'email' => $this->input->post('email'),
                    'newsletter_keyword_id' => $newsletter_keyword_ids,
                    'last_updated_date' => date("Y-m-d H:i:s"),
                    'added_date' => date("Y-m-d H:i:s"),
                    'adult_content' => $adult_content,
                    'blacklist_index' => $this->input->post('blacklist_index'),
                    'blacklist_flag' => $blacklist_flag,
                    'language_id' => $this->input->post('language_id'),
                    'frequency' => $this->input->post('frequency'),
                    'status' => $this->input->post('status')
                );
//                echo "<pre>";print_r($data_to_store);exit;
                //if the insert has returned true then we show the flash message
                if ($this->newsletter_model->store_newsletter($data_to_store)) {
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

                    redirect('kd2a2a0u1g4/newsletter/');
                    //redirect('kd2a2a0u1g4/category'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        //load the view
        //redirect('kd2a2a0u1g4/login');

        $data['category'] = $this->newsletter_category_model->get_category('', 'en', 'ASC', '', '', 'Active');
//        echo "<pre>";
//        print_r($data['category']);
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', 'en', 'ASC', '', '', 'Active');
        //$data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');

        $data['language'] = $this->newsletter_language_model->get_language('', '', 'ASC', '', '', 'Active');
//        echo "<pre>";
//        print_r($data['category']);

        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        $data['main_content'] = 'kd2a2a0u1g4/newsletter/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id
        $id = $this->uri->segment(4);
        $url_segment_5 = $this->uri->segment(5);
        if (!empty($url_segment_5)) {
            $data['url_segment_5'] = $this->uri->segment(5);
        }
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if (empty($url_segment_5)) {
                //form validation
                $this->form_validation->set_rules('newsletter_name', 'Newsletter name', 'required');
                $this->form_validation->set_rules('headline', 'Headline', 'required');
                //$this->form_validation->set_rules('newsletter_category_id', 'Category Category', 'required');
                $this->form_validation->set_rules('newsletter_category_id', 'Newsletter Category', 'required|callback_validate_category');
                $this->form_validation->set_message('validate_category', 'Please select Max 3 Category!');

                $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
                $this->form_validation->set_message('validate_keyword', 'Please select Max 20 Category!');
                $this->form_validation->set_rules('author_name', 'Author Name', 'required');
                $this->form_validation->set_rules('newsletter_sender_name', 'From Name', 'required');
                // $this->form_validation->set_rules('website_url', 'Website URL', 'required|trim|prep_url|valid_url|xss_clean');

                $this->form_validation->set_rules('newsletter_category_id', 'Newsletter Category', 'required|callback_validate_category');
                $this->form_validation->set_message('validate_category', 'Please select Max 3 Category!');

                $this->form_validation->set_rules('newsletter_keyword_id', 'Keyword', 'callback_validate_keyword');
                $this->form_validation->set_message('validate_keyword', 'Please select Max 20 Category!');
            } else {
                $this->form_validation->set_rules('description', 'description', 'required');
            }
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
                //$newsletter_keyword_ids = implode(",",$this->input->post('newsletter_keyword_id'));
                $video = implode("@@@", $this->input->post('video'));


                $data1 = $this->functions->do_upload('screenshot');
                if (isset($data1['upload_data'])) {
                    $file_name = $data1['upload_data']['file_name'];
                    @unlink("./uploads/" . $this->input->post('old_screenshot'));
                } else {
                    $file_name = $this->input->post('old_screenshot');
                }
                $sn_id = $this->functions->get_newsletter_lsn_id();
                $newsletter_rand_id = $this->input->post('old_newsletter_rand_id');

                $redirect_url = $this->input->post('redirect_url');
                if (empty($url_segment_5)) {
                    if ($this->input->post('status') == 'Inactive') {
                        $this->subscribe_model->delete_subscribe_with_newsletterid($id);
                    }
                    $data_to_store = array(
                        'sn' => $newsletter_rand_id . $sn_id,
                        'newsletter_name' => $this->input->post('newsletter_name'),
                        'newsletter_email' => $this->input->post('newsletter_email'),
                        'headline' => $this->input->post('headline'),
                        'newsletter_category_id' => $newletter_category_ids,
                        'screenshot' => $file_name,
                        'description' => $this->input->post('description'),
                        'unsubscribe_text' => $this->input->post('unsubscribe_text'),
                        'unsubscribe_url' => $this->input->post('unsubscribe_url'),
                        'author_name' => $this->input->post('author_name'),
                        'about_author' => $this->input->post('about_author'),
                        'author_country' => $this->input->post('author_country'),
                        'author_zipcode' => $this->input->post('author_zipcode'),
                        'author_city' => $this->input->post('author_city'),
                        'video' => $video,
                        'website_url' => $this->input->post('website_url'),
                        'email' => $this->input->post('email'),
                        'newsletter_keyword_id' => $newsletter_keyword_ids,
                        'newsletter_sender_name' => $this->input->post('newsletter_sender_name'),
                        'last_updated_date' => date("Y-m-d H:i:s"),
                        'adult_content' => $this->input->post('adult_content'),
                        'blacklist_index' => $this->input->post('blacklist_index'),
                        'blacklist_flag' => $this->input->post('blacklist_flag'),
                        'language_id' => $this->input->post('language_id'),
                        'frequency' => $this->input->post('frequency'),
                        'status' => $this->input->post('status')
                    );
                } else {
                    $data_to_store = array(
                        'description' => addslashes($this->input->post('description'))
                    );
                }
                //if the insert has returned true then we show the flash message
                if ($this->newsletter_model->update_newsletter($id, $data_to_store) == TRUE) {
                    $this->session->set_userdata('flash_message', 'update');
                    $hidden_url_segment_5 = $this->input->post('url_segment_5');
                    if (!empty($hidden_url_segment_5)) {
                        // echo "->" . $redirect_url;
                        //redirect('kd2a2a0u1g4/newsletter/issues/'.$hidden_url_segment_5);
                        redirect($redirect_url);
                    } else {
                        // echo "->" . $redirect_url;
                        redirect($redirect_url);
                        //redirect('kd2a2a0u1g4/newsletter/');
                    }
                } else {
                    $this->session->set_userdata('flash_message', 'not_updated');
                }
                //redirect('kd2a2a0u1g4/category/update/'.$id.'');
            }//validation run
            /* $this->session->set_userdata('flash_message', 'update');
              redirect('kd2a2a0u1g4/newsletter/'); */
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data

        $data['category'] = $this->newsletter_category_model->get_category('', 'en', 'ASC', '', '', 'Active');
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', 'en', 'ASC', '', '', 'Active');
        $data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '', '', 'Active');
        $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($id);
        $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
        //load the view
        //echo '<pre>'; print_r($data); die;
        $data['main_content'] = 'kd2a2a0u1g4/newsletter/edit';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    public function process() {
        $id = $this->uri->segment(4);
        $parant_id = $this->uri->segment(5);
        $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($id);
//        echo '<pre>';
//        print_r($data['newsletter'][0]["description"]);
//        die;
        // echo "parant->" . $parant_id;
        $unsubscribes = $this->newsletter_model->get_newsletter_by_id($parant_id);
//        echo '<pre>';
//        print_r($unsubscribes);
//        die;
        // echo $data['newsletter'][0]["description"];
        //echo "-----------------------------------------================---------------";
        $display_array = array();
        $display_array = array($unsubscribes[0]['unsubscribe_url'], $unsubscribes[0]['unsubscribe_text']);
//        echo '<pre>';
//        print_r($display_array);
//        echo '</pre>';
        $return_html = remove_unsubscribe_list(strip_slashes($data['newsletter'][0]["description"]), $display_array);
        //echo '<pre>';
        //print_r($return_html);
        // echo $return_html["html"];
        $data_to_store = array(
            'description' => addslashes($return_html["html"])
        );
//        echo print_r($return_html["html"]);
//        die;
        if ($this->newsletter_model->update_newsletter($id, $data_to_store) == TRUE) {

            $this->session->set_userdata('flash_message', 'update');
            redirect('kd2a2a0u1g4/newsletter/update/' . $id . '/' . $parant_id);
        } else {
            $this->session->set_userdata('flash_message', 'not_updated');
            redirect('kd2a2a0u1g4/newsletter/update/' . $id . '/' . $parant_id);
        }
        //die;
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

        $get_newsletter_relation = $this->newsletter_model->get_newsletter_by_field("newsletter_id", $id);
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

            $this->newsletter_model->delete_newsletter_by_field('newsletter_rand_id', $get_newsletter_relation[0]['newsletter_rand_id']);
            $this->subscribe_model->delete_subscribe_with_newsletterid($id);
        } else {
            $this->newsletter_model->delete_newsletter($id);
        }
        $this->session->set_userdata('flash_message', 'delete');

        if (!empty($url_segment_5)) {
            redirect('kd2a2a0u1g4/newsletter/issues/' . $url_segment_5);
        } else {
            redirect('kd2a2a0u1g4/newsletter');
        }
    }

//edit

    public function multidelete() {
        //product id
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        $this->load->model('subscribe_model');
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
            $get_newsletter_relation = $this->newsletter_model->get_newsletter_by_field("newsletter_id", $id);
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

                $this->newsletter_model->delete_newsletter_by_field('newsletter_rand_id', $get_newsletter_relation[0]['newsletter_rand_id']);
                $this->subscribe_model->delete_subscribe_with_newsletterid($id);
            } else {
                //echo "else"; die;
                $this->newsletter_model->delete_newsletter($id);
            }
        }
        $this->session->set_userdata('flash_message', 'multi_delete');
        $this->session->set_userdata('delete_msg_no', count($id_arr));
        if (!empty($url_segment_5)) {
            redirect('kd2a2a0u1g4/newsletter/issues/' . $url_segment_5);
        } else {
            redirect('kd2a2a0u1g4/newsletter');
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
