<?php

class Myknewdog extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER =
            'myknewdog';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('newsletter_model');
        $this->load->model('newsletter_category_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->model('newsletter_language_model');
        $this->load->model('user_model');
        $this->load->model('subscribe_model');
        $this->load->model('schedule_model');
        $this->load->helper('url');
        $this->load->model('site_language_model');
        $this->load->model('additional_email_model');
        $this->load->model("invoice_model");
        $this->load->model("email_template_model");
        $this->load->model('time_zone_model');

        if (!$this->session->userdata('is_logged_in')) {
            $this->session->set_flashdata('flash_message', '' . _clang(OPPS_YOU_ARE_NOW_LOGGED_OUT) . '');
            $this->session->set_flashdata('flash_class', 'alert-error');
            redirect('home');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view

        $user_id =
                $this->session->userdata('user_id');
        //my newsletter ******************************************************************
        $mynl_search_string =
                $this->input->post('mynl_search_string');
        $mynl_order =
                $this->input->post('mynl_order');
        $mynl_mynewsletter =
                $this->input->post('mynl_mynewsletter');
        $mynl_language_id =
                $this->input->post('mynl_language_id');
        $mynl_newsletter_category =
                $this->input->post('mynl_newsletter_category');
        $mynl_rating_id =
                $this->input->post('mynl_rating_id');
        $mynl_author_country =
                $this->input->post('mynl_author_country');
        $mynl_author_zipcode =
                $this->input->post('mynl_author_zipcode');



        if ($mynl_order ==
                'newsletter_id') {
            $mynl_order_type =
                    'DESC';
        } else {
            $mynl_order_type =
                    'ASC';
        }
        //$order_type = $this->input->post('order_type'); 
        //pagination settings
        //My Newsletter ********************************************
        //pagination settings
        $mynl_config =
                array();
        $mynl_config['per_page'] =
                10;
        $mynl_config["uri_segment"] =
                2;
        $mynl_config['base_url'] =
                base_url() . 'mynewdog';
        $mynl_config['use_page_numbers'] =
                TRUE;
        $mynl_config['num_links'] =
                20;
        $mynl_config['full_tag_open'] =
                '<ul>';
        $mynl_config['full_tag_close'] =
                '</ul>';
        $mynl_config['num_tag_open'] =
                '<li>';
        $mynl_config['num_tag_close'] =
                '</li>';
        $mynl_config['cur_tag_open'] =
                '<li class="active"><a>';
        $mynl_config['cur_tag_close'] =
                '</a></li>';
        $mynl_page =
                $this->uri->segment(2);
        if ($this->uri->segment(2) ||
                $this->input->post('form') ==
                'section_2') {
            $data['mynl_tab'] =
                    'tab_2';
            //$this->session->set_flashdata('flash_mynl_tab', 'tab_2');
        } else if ($this->input->post('form') ==
                'section_3') {
            $data['mynl_tab'] =
                    'tab_3';
        } else if ($this->input->post('form') ==
                'section_4') {
            $data['mynl_tab'] =
                    'tab_4';
        }

        //echo "->".$this->session->flashdata("flash_mynl_tab");
        //limit end
        //$mynl_page = $this->uri->segment(2);
        //	echo "<br>";
        //math to get the initial record to be select in the database
        $mynl_limit_end =
                ($mynl_page *
                $mynl_config['per_page']) -
                $mynl_config['per_page'];
        if ($mynl_limit_end <
                0) {
            $mynl_limit_end =
                    0;
        }

        //if order type was changed
        if ($mynl_order_type) {
            $mynl_filter_session_data['mynl_order_type'] =
                    $mynl_order_type;
        } else {
            //we have something stored in the session? 
            //if($this->session->userdata('order_type')){
            //  $order_type = $this->session->userdata('order_type');    
            //}else{
            //if we have nothing inside session, so it's the default "Asc"
            //  $order_type = 'DESC';    
            // }
        }
        //make the data type var avaible to our view
        $data['mynl_order_type_selected'] =
                $mynl_order_type;

        if ($user_id) {
            $sub_wherefield =
                    array(
                        's_user_id');
            $sub_wherevalue =
                    array(
                        $user_id);
            $subscribe_by_user_id =
                    $this->subscribe_model->get_subscribe('', '', '', '', '', $sub_wherefield, $sub_wherevalue);

            $subscribe_newsletter_ids =
                    array();
            for ($s =
            0; $s <
                    count($subscribe_by_user_id); $s++) {
                $subscribe_newsletter_ids[] =
                        $subscribe_by_user_id[$s]['s_newsletter_id'];
            }
            //echo '<pre>';print_r($subscribe_newsletter_ids);
            //echo $subscribe_newsletter_id = implode(",",$subscribe_newsletter_ids);die;
            $mynl_where_field =
                    array();
            $mynl_where_value =
                    array();
            if (count($subscribe_newsletter_ids) >
                    0) {
                $mynl_where_in_field =
                        array(
                            'newsletter_id');
                $mynl_where_in_value =
                        array(
                            $subscribe_newsletter_ids);
            } else {
                $mynl_where_in_field =
                        array(
                            'newsletter_id');
                $mynl_where_in_value =
                        array(
                            0);
            }
        } else {
            $mynl_where_field =
                    array();
            $mynl_where_value =
                    array();
            $mynl_where_in_field =
                    array();
            $mynl_where_in_value =
                    array();
        }
        /*         * ******************************************************* */
        $where_field =
                array();
        $where_value =
                array();

        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        //MY newsletter ******************************************************************
        if ($mynl_search_string !==
                false &&
                $mynl_order !==
                false ||
                $this->uri->segment(2) ==
                true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($mynl_search_string) {
                $mynl_filter_session_data['mynl_search_string_selected'] =
                        $mynl_search_string;
            } else {
                //$mynl_search_string = $this->session->userdata('mynl_search_string_selected');
            }
            $data['mynl_search_string_selected'] =
                    $mynl_search_string;

            if ($mynl_order) {
                $mynl_filter_session_data['mynl_order'] =
                        $mynl_order;
            } else {
                $mynl_order =
                        $this->session->userdata('mynl_order');
            }

            $data['mynl_order'] =
                    $mynl_order;
            $data['mynl_selected_language_id'] =
                    $mynl_language_id;
            $data['mynl_selected_newsletter_category'] =
                    $mynl_newsletter_category;
            $data['mynl_selected_newsletter_rating_id'] =
                    $mynl_rating_id;
            $data['mynl_selected_author_country'] =
                    $mynl_author_country;
            $data['mynl_selected_author_zipcode'] =
                    $mynl_author_zipcode;

            //save session data into the session
            if (isset($mynl_filter_session_data)) {
                $this->session->set_userdata($mynl_filter_session_data);
            }

            //fetch sql data into arrays
            $data['mynl_count_products'] =
                    $this->newsletter_model->count_newsletter_front($mynl_search_string, $mynl_order, $mynl_language_id, $mynl_newsletter_category, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
            $mynl_config['total_rows'] =
                    $data['mynl_count_products'];
            ;
            //fetch sql data into arrays
            if ($mynl_search_string) {
                if ($mynl_order) {
                    $data['mynl_newsletter'] =
                            $this->newsletter_model->get_newsletter_front($mynl_search_string, $mynl_order, $mynl_order_type, $mynl_config['per_page'], $mynl_limit_end, 'Active', $mynl_where_field, $mynl_where_value, $mynl_language_id, $mynl_newsletter_category, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
                } else {
                    $data['mynl_newsletter'] =
                            $this->newsletter_model->get_newsletter_front($mynl_search_string, '', $mynl_order_type, $mynl_config['per_page'], $mynl_limit_end, 'Active', $mynl_where_field, $mynl_where_value, $mynl_language_id, $mynl_newsletter_category, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
                }
            } else {
                if ($mynl_order) {
                    $data['mynl_newsletter'] =
                            $this->newsletter_model->get_newsletter_front('', $mynl_order, $mynl_order_type, $mynl_config['per_page'], $mynl_limit_end, 'Active', $mynl_where_field, $mynl_where_value, $mynl_language_id, $mynl_newsletter_category, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
                } else {
                    $data['mynl_newsletter'] =
                            $this->newsletter_model->get_newsletter_front('', '', $mynl_order_type, $mynl_config['per_page'], $mynl_limit_end, 'Active', $mynl_where_field, $mynl_where_value, $mynl_language_id, $mynl_newsletter_category, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
                }
            }
        } else {

            //clean filter data inside section
            $mynl_filter_session_data['mynl_newsletter_selected'] =
                    null;
            $mynl_filter_session_data['mynl_search_string_selected'] =
                    null;
            $mynl_filter_session_data['mynl_order'] =
                    null;
            $mynl_filter_session_data['mynl_order_type'] =
                    null;
            //$filter_session_data['selected_language_id'] = null;
            $this->session->set_userdata($mynl_filter_session_data);

            //pre selected options
            $data['mynl_search_string_selected'] =
                    '';
            $data['mynl_order'] =
                    'id';
            $data['mynl_selected_language_id'] =
                    null;
            $data['mynl_selected_newsletter_category'] =
                    null;
            $data['mynl_selected_author_country'] =
                    null;
            $data['mynl_order'] =
                    null;
            $data['mynl_selected_language_id'] =
                    null;
            $data['mynl_selected_newsletter_category_id'] =
                    null;
            $data['mynl_selected_newsletter_rating_id'] =
                    null;
            $data['mynl_selected_author_country'] =
                    null;
            $data['mynl_selected_author_zipcode'] =
                    null;

            //fetch sql data into arrays
            $data['mynl_count_newsletter'] =
                    $this->newsletter_model->count_newsletter_front('', '', '', '', '', '', '', $mynl_where_in_field, $mynl_where_in_value);
            @$data['mynl_newsletter'] =
                    $this->newsletter_model->get_newsletter_front('', '', $mynl_order_type, $mynl_config['per_page'], $mynl_limit_end, 'Active', $mynl_where_field, $mynl_where_value, $mynl_language_id, $mynl_newsletter_category_id, $mynl_rating_id, $mynl_author_country, $mynl_author_zipcode, $mynl_where_in_field, $mynl_where_in_value);
            $mynl_config['total_rows'] =
                    $data['mynl_count_newsletter'];
            //echo '<pre>';print_r($data['mynl_newsletter']); die;
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        //echo '<pre>'; print_r($mynl_config);
        $this->pagination->initialize($mynl_config);
        $data['mynl_link'] =
                $this->pagination->create_links();

        //my newsletter **************************************
        $data['mynl_total_rows'] =
                $mynl_config['total_rows'];
        $data['mynl_limit_end'] =
                $mynl_limit_end;
        $data['mynl_limit_start'] =
                $mynl_config['per_page'];
        $data['mynl_page'] =
                $mynl_page;

        $data['category'] =
                $this->newsletter_category_model->get_category('', '', 'ASC', '', '', 'Active');
        //$data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '','','Active');
        $data['language'] =
                $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '', '', 'Active');
        $data['countries'] =
                $this->user_model->get_countries('country_name', 'ASC');

        //Users
        $data['keyword'] =
                $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');
        $data['site_language'] =
                $this->site_language_model->get_language('', '', '', '', '', 'Active', '');
        $data['user'] =
                $this->user_model->get_user_by_id($user_id);
        $where_field_schedule =
                array(
                    'sd_user_id');
        $where_value_schedule =
                array(
                    $user_id);
        $data['additional_email'] =
                $this->additional_email_model->get_additional_email_by_field(array(
            "user_id"), array(
            $user_id));
        $data['schedule'] =
                $this->schedule_model->get_schedule('', 'schedule_id', 'ASC', '', '', $where_field_schedule, $where_value_schedule);
        //if($this->input->post('schedule_id')){
        //$data['edit_schedule'] = $this->schedule_model->get_schedule_by_id($this->input->post('schedule_id'));
        //}else{
        //$data['edit_schedule'] = '';
        //}
        $data['time_zone'] = $this->time_zone_model->get_time_zone('', '', '', '', '', '', array(), array());
        $data['main_content'] =
                'myknewdog_view';
        $this->load->view('includes/template', $data);
    }

//index

    public function edit_profile() {
        //product id 
        $id = $this->session->userdata("user_id");
        //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') ===
                'POST') {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');
            //$this->form_validation->set_rules('en', 'Keyword for English', 'required');
            // $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            //if ($this->form_validation->run())
            // {

            /* $data_to_store = array(
              'keyword_name' => $this->input->post('keyword_name'),
              'status' => $this->input->post('status'),
              ); */
            //if the insert has returned true then we show the flash message
            $array =
                    array();
            $array =
                    $_POST;
            foreach ($array as $k => $v) {
               // echo $k; die;
                if (in_array($k, array(
                            'submit'))) {
                    unset($array[$k]);
                }
                if (is_array($v)) {
                    $array[$k] =
                            implode(",", $v);
                }
                if (in_array($k, array(
                            'language_id'))) {

                    $user_d =
                            $this->user_model->get_user_by_id($id);
                    if (!empty($user_d[0][$k])) {
                        $dat =
                                explode(",", $user_d[0][$k]);
                        array_push($dat, $array[$k]);
                        $language_ids =
                                implode(",", $dat);
                        //echo '<pre>';print_r($dat); 
                    } else {
                        $language_ids =
                                $array[$k];
                    }
                    unset($array['language_id']);
                    $array['language_id'] =
                            $language_ids;
                    //echo '<pre>'; print_r($array['language_id']);die;
                }
                if (in_array($k, array(
                            'user_interests'))) {
                    $user_d =
                            $this->user_model->get_user_by_id($id);
                    if (!empty($user_d[0][$k])) {
                        $dat =
                                explode(",", $user_d[0][$k]);
                        //print_r($dat);
                        array_push($dat, $array[$k]);
                        $language_ids =
                                implode(",", $dat);
                    } else {
                        $language_ids =
                                $array[$k];
                    }


                    //echo '<pre>';print_r($dat); 

                    unset($array['user_interests']);
                    $array['user_interests'] =
                            $language_ids;
                    //echo '<pre>'; print_r($array['user_interests']);die;
                }
            }
            if (@$this->user_model->update_user($id, $array) ==
                    TRUE) {
                $this->session->set_flashdata('flash_message', '' . _clang(MY_PROFILE_UPDATED_WITH) . '');
                $this->session->set_flashdata('flash_class', 'alert-success');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
            } else {
                $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
            }
            redirect('myknewdog');
            //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');
            //}//validation run
        }


        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 

        /* $data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
          $data['keyword'] = $this->newsletter_keyword_model->get_keyword_by_id($id);
          //load the view
          $data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/edit';
          $this->load->view('kd2a2a0u1g4/includes/template', $data); */
    }

//update

    public function edit_additional_email() {
        //product id 
        $user_id =
                $this->session->userdata("user_id");
        $type_of_membership =
                $this->session->userdata("type_of_membership");
        $additional_email_id =
                $this->input->post("additional_email_id");
        //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') ===
                'POST') {
            $mode =
                    $this->input->post('mode');
            //form validation
            if ($mode ==
                    'Update') {

                $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|edit_unique[additional_email.email.' . $additional_email_id . ']');
            } else {
                $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[additional_email.email]|count_content[additional_email.user_id.' . $user_id . '.3]');
            }
            //$this->form_validation->set_rules('en', 'Keyword for English', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                /* $data_to_store = array(
                  'keyword_name' => $this->input->post('keyword_name'),
                  'status' => $this->input->post('status'),
                  ); */
                //if the insert has returned true then we show the flash message
                //echo $this->input->post('email'); die;
                $array =
                        array(
                            "email" => $this->input->post('email'),
                            "user_id" => $user_id
                );

                if ($mode ==
                        'Update') {
                    if ($this->additional_email_model->update_additional_email($additional_email_id, $array) ==
                            TRUE &&
                            $type_of_membership !=
                            'FREE') {
                        $this->session->set_flashdata('flash_message', '' . _clang(MY_PROFILE_UPDATED_WITH) . '');
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
                    } else {
                        $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
                    }
                } else {
                    if (@$this->additional_email_model->store_additional_email($array) ==
                            TRUE &&
                            $type_of_membership !=
                            'FREE') {
                        $this->session->set_flashdata('flash_message', '' . _clang(ADDITIONAL_EMAIL_ADDED_WITH) . '');
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
                    } else {
                        $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
                    }
                }
                redirect('myknewdog');
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');
            } else {
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                $this->session->set_flashdata('flash_mynl_tab', 'tab_1');
                redirect('myknewdog');
            }//validation run
        }


        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 

        /* $data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
          $data['keyword'] = $this->newsletter_keyword_model->get_keyword_by_id($id);
          //load the view
          $data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/edit';
          $this->load->view('kd2a2a0u1g4/includes/template', $data); */
    }

//update

    public function edit_account_settings() {
        //product id 
        $id =
                $this->session->userdata("user_id");
        //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') ===
                'POST') {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');

            $this->form_validation->set_rules('submit', '', 'required');
            if (isset($_POST['password'])) {

                $this->form_validation->set_rules('old_password', 'Old Password', "trim|required|password_matches[" . $id . "]");
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
                $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                /* $data_to_store = array(
                  'keyword_name' => $this->input->post('keyword_name'),
                  'status' => $this->input->post('status'),
                  ); */
                //if the insert has returned true then we show the flash message

                $array =
                        array();
                $array =
                        $_POST;
                foreach ($array as $k => $v) {
                    if (in_array($k, array(
                                'old_password',
                                'password2',
                                'submit'))) {
                        unset($array[$k]);
                    }
                    if (is_array($v)) {
                        $array[$k] =
                                implode(",", $v);
                    }
                    if ($k ==
                            'password') {
                        $array[$k] =
                                md5($v);
                    }
                }
                //print_r($array); die;
                if (@$this->user_model->update_user($id, $array) ==
                        TRUE) {
                    $get_lang_a =
                            $this->user_model->get_user_by_id($id);
                    $get_lang1 =
                            $get_lang_a[0]['language_shortcode'];
                    $get_lang =
                            !empty($get_lang1) ? $get_lang1 : 'en';

                    $data =
                            array(
                                'language_shortcode' => $get_lang,
                    );
                    $this->session->set_userdata($data);

                    $this->session->set_flashdata('flash_message', '' . _clang(ACCOUNT_SETTINGS_UPDATED) . '');
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                } else {
                    $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                }
                redirect('myknewdog');
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');
            } else {
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                redirect('myknewdog');
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 
    }

//update

    function schedule() {
        $user_id = $this->session->userdata("user_id");
        if ($this->input->server('REQUEST_METHOD') ===
                'POST') {

            //form validation
            //echo $this->session->userdata("type_of_membership");
            //$this->form_validation->set_rules('time_zone',
            //'Time zone',
            //'required');
            $this->form_validation->set_rules('sending_to_email', 'Sending to email', 'trim|valid_email');

            $this->form_validation->set_rules('sending', 'Sending', 'trim|required');
            $this->form_validation->set_rules('every', 'every', 'trim|required');
            if ($this->input->post('sending') ==
                    'Weekly') {
                $this->form_validation->set_rules('weeks_on[]', 'Weeks on checkbox', 'trim|required');
            }
            if ($this->input->post('sending') ==
                    'Monthly') {
                $this->form_validation->set_rules('every', 'every', 'trim|required');
               $this->form_validation->set_rules('weeks_on[]',
                 'Weeks on checkbox',
                 'trim|required');
            }

            $this->form_validation->set_rules('ends', 'Ends', 'trim|required');
            if ($this->input->post('ends') ==
                    'after') {
                $this->form_validation->set_rules('ends_after', 'After occurrences', 'trim|required');
            }
            if ($this->input->post('ends') ==
                    'on') {
                $this->form_validation->set_rules('ends_on', 'On Date', 'trim|required');
            }

            if ($this->session->userdata("type_of_membership") ==
                    "PRE1") {
                $this->form_validation->set_rules('sending', 'schedule', 'trim|required|count_schedule[' . $user_id . '.10]');
            }

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                $array =
                        array();
                $array =
                        $_POST;

                foreach ($array as $k => $v) {
                    if (in_array($k, array('form', 'time_zone'))) {

                        unset($array[$k]);
                    }
                    if (is_array($v)) {
                        $array[$k] =
                                implode(",", $v);
                    }
                }

                //echo '<pre>'; print_r($array); die;
                if ($this->schedule_model->store_schedule($array)) {
                    //$data = array("time_zone" => $this->input->post('time_zone'));
                    //$this->user_model->update_user($user_id, $data);
                    //$this->time_zone->store_time_zone("");
                    $this->session->set_flashdata('flash_message', '' . _clang(YOUR_NEW_SCHEDULE_ADDED) . '');
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                } else {
                    $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                }

                redirect('myknewdog');
            } else {
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                redirect('myknewdog');
            }
        }
    }

    function schedule_edit() {
        $schedule_id =
                $this->input->post("schedule_id");

        if ($this->input->server('REQUEST_METHOD') ===
                'POST') {

            //form validation
            $this->form_validation->set_rules('sending_to_email', 'Sending to email', 'trim|valid_email');

            $this->form_validation->set_rules('sending', 'Sending', 'trim|required');
            if ($this->input->post('sending') ==
                    'Weekly') {
                $this->form_validation->set_rules('weeks_on[]', 'Weeks on checkbox', 'trim|required');
            }
            if ($this->input->post('sending') ==
                    'Monthly') {
                $this->form_validation->set_rules('every', 'every', 'trim|required|callback_check_min_max[1,4]');
                /*    $this->form_validation->set_rules('weeks_on[]',
                  'Weeks on checkbox',
                  'trim|required'); */
            }

            $this->form_validation->set_rules('ends', 'Ends', 'trim|required');
            if ($this->input->post('ends') ==
                    'after') {
                $this->form_validation->set_rules('ends_after', 'After occurrences', 'trim|required');
            }
            if ($this->input->post('ends') ==
                    'on') {
                $this->form_validation->set_rules('ends_on', 'Ends on', 'trim|required');
            }

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                $array =
                        array();
                /* $array = $_POST;

                  foreach($array as $k=>$v){
                  if (in_array($k,array('form','schedule_id')))
                  {

                  unset($array[$k]);

                  }
                  if(is_array($v)){
                  $array[$k] = implode(",",$v);
                  }

                  } */
                if (is_array($this->input->post('weeks_on'))) {
                    $weeks_on =
                            implode(",", $this->input->post('weeks_on'));
                } else {
                    $weeks_on = "";
                }
                $ends =
                        $this->input->post('ends');
                if ($ends ==
                        'Never') {
                    $end_after =
                            '';
                    $ends_on =
                            '';
                } elseif ($ends ==
                        "after") {
                    $end_after =
                            $this->input->post('ends_after');
                    $ends_on =
                            ''; //$this->input->post('ends_on');
                } else if ($ends ==
                        "on") {
                    $end_after =
                            ''; // $this->input->post('ends_after');
                    $ends_on =
                            $this->input->post('ends_on');
                }
                //echo '<pre>'; print_r($array); die;
                $array =
                        array(
                            'sd_user_id' => $this->input->post('sd_user_id'),
                            'sending_to_email' => $this->input->post('sending_to_email'),
                            'sending' => $this->input->post('sending'),
                            'every' => $this->input->post('every'),
                            'weeks_on' => $weeks_on,
                            'at' => $this->input->post('at'),
                            'ends' => $this->input->post('ends'),
                            'ends_after' => $end_after,
                            'ends_on' => $ends_on
                );
                if ($this->schedule_model->update_schedule($schedule_id, $array)) {
                    $this->session->set_flashdata('flash_message', '' . _clang(YOUR_SCHEDULE_UPDATED) . '');
                    $this->session->set_flashdata('flash_class', 'alert-success');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                } else {
                    $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                }

                redirect('myknewdog');
            } else {
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                $this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                redirect('myknewdog');
            }
        }
    }

    function invoicelist() {
        $user_id =
                $this->session->userdata("user_id");



        $field =
                array(
                    "user_id");
        $value =
                array(
                    $user_id);

        $get_invoice =
                $this->invoice_model->get_invoice_by_field($field, $value);
        $data['invoice'] =
                $get_invoice;
        $data['main_content'] =
                'invoicelist_view';
        $this->load->view('includes/template', $data);
    }

    function invoicepdf() {
        //$user_id = $this->session->userdata("user_id");
        $invoice_id =
                $this->uri->segment(3);
        //require_once("dompdf/dompdf_config.inc.php");
        $this->load->model("invoice_model");

        $field =
                array(
                    "invoice_id");
        $value =
                array(
                    $invoice_id);

        $get_invoice =
                $this->invoice_model->get_invoice_by_field($field, $value);
        $data['invoice'] =
                $get_invoice;
        //$data['main_content'] = 'invoicelist_view';
        $get_html =
                $this->load->view('mail_templates/invoice_template.php', $data, true);
        echo $get_html;
        /* $dompdf = new DOMPDF();
          $dompdf->set_base_path(site_url('assets/css/invoice_pdf.css'));
          $dompdf->load_html($get_html);
          $dompdf->set_paper("8.5x11", "portrait");
          $dompdf->render();
          // The next call will store the entire PDF as a string in $pdf
          $pdf = $dompdf->output();
          $dompdf->stream('invoice'.$get_invoice[0]["item_number"].'.pdf',array('Attachment'=>0)); */
        // You can now write $pdf to disk, store it in a database or stream it
        // to the client.
        //$dompdf->stream("infopdf.pdf");
        //$pdfname = "infopdf_".rand().".pdf";
        //$filename="images/pdffiles/".$pdfname;
        //file_put_contents($filename, $pdf);
    }

    function upload_avtar() {
        $user_id =
                $this->session->userdata("user_id");
//print_r($_FILES); die;
        $status =
                "";
        $msg =
                "";
        $return =
                "";
        $file_element_name =
                'imagefile';

        //if (empty($_POST['title']))
        //{
        //  $status = "error";
        //$msg = "Please enter a title";
        //}

        if ($status !=
                "error") {
            /* $config['upload_path'] = './uploads/avatar';
              $config['allowed_types'] = 'gif|jpg|png|jpeg';
              $config['max_size'] = 1024 * 8;
              $config['encrypt_name'] = TRUE; */

            $config['upload_path'] =
                    './uploads/avatar';
            $config['allowed_types'] =
                    'gif|jpg|png';
            $config['max_size'] =
                    '2048';

            $config['overwrite'] =
                    FALSE;
            $config['encrypt_name'] =
                    TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config);

            $data =
                    $this->functions->do_upload($file_element_name, './uploads/avatar/');
            //if (isset($data['upload_data'])) 
            $user_avatar =
                    $this->user_model->get_user_by_id($user_id);
            if (isset($data['error'])) {
                $status =
                        'error';
                $msg =
                        $this->upload->display_errors('', '');
                $return =
                        array(
                            "status" => $status,
                            "url" => $user_avatar[0]['avatar']);
            } else {
                // $data = $this->upload->data();

                $user_data =
                        array(
                            "avatar" => $data['upload_data']['file_name']);

                $file_id =
                        $this->user_model->update_user($user_id, $user_data);

                if (!empty($file_id)) {
                    $status =
                            "success";
                    $msg =
                            "File successfully uploaded";
                    @unlink("./uploads/avatar/" . $user_avatar[0]['avatar']);
                    $return =
                            $return =
                            array(
                                "status" => $status,
                                "url" => $data['upload_data']['file_name']);
                } else {
                    $status =
                            "error";
                    //unset($data['upload_data']['file_name']);

                    $msg =
                            "Something went wrong when saving the file, please try again.";
                }
            }
            //@unlink($_FILES[$file_element_name]);
        }

        echo json_encode($return);
    }

    function remove_avatar() {
        
    }

    function upload_crop_avatar() {

        // Note: GD library is required for this function
        $user_id =
                $this->session->userdata("user_id");
        if ($_SERVER['REQUEST_METHOD'] ==
                'POST') {
            $iWidth =
                    $_POST['w'];
            $iHeight =
                    $_POST['h']; // desired image result dimensions
            $iJpgQuality =
                    90;
            //echo '<pre>'; print_r($_FILES); die;
            $file_element_name =
                    'image_file';

            if ($_FILES) {

                // if no errors and size less than 250kb
                //&& $_FILES['image_file']['size'] < 250 * 1024
                if (!$_FILES['image_file']['error']) {
                    if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                        //$imagename = md5(time().rand());
                        //$data = $this->functions->do_upload($file_element_name,'./uploads/avatar/');
                        //echo '<pre>';	print_r($data); die;
                        /* if(isset($data['error']))
                          {
                          $this->session->set_flashdata('flash_message', '<strong>oops! something went wrong!</strong>');
                          $this->session->set_flashdata('flash_class', 'alert-error');
                          //$this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                          redirect('myknewdog');
                          }else{ */
                        //$imagename = $data['upload_data']['file_name'];
                        // new unique filename
                        //$sTempFileName = './upload/avatar/' . $imagename;
                        //$imagename = $data['upload_data']['raw_name'];
                        //$sTempFileName = realpath(APPPATH.'../uploads/avatar/'. $imagename);

                        $imgname =
                                md5(time() . rand());
                        $sTempFileName =
                                FCPATH . "uploads/avatar/" . $imgname;
                        //$sTempFileName('.uploads/avatar/');
                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
                        //echo "file->".$imagename." ";
                        //echo $sTempFileName = "../../uploads/avatar/".$data['upload_data']['file_name'];//.$data['upload_data']['raw_name'];
                        // change file permission to 644
                        //$user_data = array("avatar" => $data['upload_data']['file_name']);
                        //$file_id = $this->user_model->update_user($user_id,$user_data);
                        @chmod($sTempFileName, 0644);

                        if (file_exists($sTempFileName) &&
                                filesize($sTempFileName) >
                                0) {

                            $aSize =
                                    getimagesize($sTempFileName); // try to obtain image info
                            if (!$aSize) {
                                @unlink($sTempFileName);
                                return;
                            }

                            // check for image type
                            switch ($aSize[2]) {
                                case IMAGETYPE_JPEG:
                                    $sExt =
                                            '.jpg';

                                    // create a new image from file
                                    $vImg =
                                            @imagecreatefromjpeg($sTempFileName);
                                    break;
                                case IMAGETYPE_PNG:
                                    $sExt =
                                            '.png';

                                    // create a new image from file
                                    $vImg =
                                            @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }

                            // create a new true color image
                            $vDstImg =
                                    @imagecreatetruecolor($iWidth, $iHeight);

                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);

                            // define a result image filename
                            //echo "file->". $sTempFileName;
                            //echo "<br/>ext->".$sExt; die;
                            $sResultFileName =
                                    $sTempFileName . $sExt;

                            // output image to file
                            imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                            @unlink($sTempFileName);
                            @unlink(FCPATH . "uploads/avatar/" . $_POST['old_avatar']);
                            $user_data =
                                    array(
                                        "avatar" => $imgname . $sExt);
                            $file_id =
                                    $this->user_model->update_user($user_id, $user_data);

                            // echo $sResultFileName; die;
                            $this->session->set_flashdata('flash_message', '' . _clang(YOUR_AVATAR_UPLOADED_WITH) . '');
                            $this->session->set_flashdata('flash_class', 'alert-success');
                            //$this->session->set_flashdata('flash_mynl_tab', 'tab_3');
                            redirect('myknewdog');
                        }
                        //}
                    }
                }
            }
        }
    }

    function cancle_account() {
        $redirect_to_home = FALSE;
        $user_id =
                $this->session->userdata("user_id");
        $type_of_membership =
                $this->session->userdata("type_of_membership");
        $answer =
                $this->input->post('ans');
        if ($answer ==
                'tell_us') {
            $answer =
                    $this->input->post('tell_us');
        }
        $user_data =
                $this->user_model->get_user_by_id($user_id);

        $user_data =
                $this->user_model->get_user_by_id($user_id);

        if ($type_of_membership =='FREE') {

            //Delete user
            $this->user_model->delete_user($user_id);

            //$this->session->set_flashdata('flash_mynl_tab', 'tab_4');
            //Delete all schedule
            $this->schedule_model->delete_schedule_with_userid($user_id);

            //delete all subscribe 
            $this->subscribe_model->delete_subscribe_with_userid($user_id);

            //delete Newsletter review with process
            $get_newsletter_ids =
                    $this->newsletter_model->get_newsletter_review('', '', '', '', '', '', array("join_user_id"), array($user_id), '');

            $this->newsletter_model->delete_newsletter_review_with_userid($user_id);
            for ($i = 0; $i < count($get_newsletter_ids); $i++) {
                $avg_rate = get_average_rate($get_newsletter_ids[$i]['join_newsletter_id']);
                $rate = array("ratings" => $avg_rate["avg_round"]);
                //add average rate
                $this->newsletter_model->update_newsletter($get_newsletter_ids[$i]['join_newsletter_id'], $rate);
            }

            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            //First mail to user
            $user_email = $user_data[0]['primary_email'];

            $get_admin_detail = get_admin_detail();
            if (valid_email($user_email)) {
                // compose email
                //common helper function for admin detail
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($user_email);
                $this->email->set_mailtype("html");
                $this->email->subject('Your Free Account has been cancled from knewdog!');

                $free_cancle_username = $user_data[0]['username'];

                //bhushan changes    
                $session_lang =
                        $this->session->userdata('language_shortcode');
                $replace = array('{free_cancle_username}');
                $with = array("{$free_cancle_username}");
                $email_template_content_free_account =
                        $this->email_template_model->get_email_template_by_id(8);
                if (isset($email_template_content_free_account[0]['description_' . $session_lang]) &&
                        !empty($email_template_content_free_account[0]['description_' . $session_lang])) {
                    $cancellation_email_content_for_free =
                            $email_template_content_free_account[0]['description_' . $session_lang];
                    $message =
                            str_replace($replace, $with, $cancellation_email_content_for_free);
                    $utf = "utf-8";
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $cancellation_email_content_for_free =
                            $email_template_content_free_account[0]['description_en'];
                    $message =
                            str_replace($replace, $with, $cancellation_email_content_for_free);
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }

                //end changes
//							$message = $this->load->view('mail_templates/cancle_account_mail', $mail_data,true); 
//						  	$this->email->message($message);  
                // try send mail ant if not able print debug
                $this->email->send();
            }
            $admin_email = $get_admin_detail['email'];
            if (valid_email($admin_email)) {
                // compose email
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($admin_email);
                $this->email->set_mailtype("html");
                $this->email->subject('One Account has been cancled from knewdog!');

                $mail_data['free_admin_cancle_account_type'] = get_type_of_membership_txt($type_of_membership);
                $mail_data['free_admin_cancle_answer'] = $answer;
                $mail_data['free_admin_cancle_user_email'] = $user_email;
                $mail_data['free_admin_cancle_username'] = $user_data[0]['username'];

                //bhushan changes    
                $session_lang =
                        $this->session->userdata('language_shortcode');
                $replace =
                        array(
                            '{free_admin_cancle_account_type}',
                            '{free_admin_cancle_answer}',
                            '{free_admin_cancle_username}',
                            '{free_admin_cancle_user_email}');
                $with =
                        array(
                            "{$mail_data['free_admin_cancle_account_type']}",
                            "{$mail_data['free_admin_cancle_answer']}",
                            "{$mail_data['free_admin_cancle_username']}",
                            "{$mail_data['free_admin_cancle_user_email']}"
                );

                $email_template_content_cancle_admin = $this->email_template_model->get_email_template_by_id(9);

                if (isset($email_template_content_cancle_admin[0]['description_' . $session_lang]) &&
                        !empty($email_template_content_cancle_admin[0]['description_' . $session_lang])) {
                    $cancle_mail_free_account_admin = $email_template_content_cancle_admin[0]['description_' . $session_lang];
                    $message =
                            str_replace($replace, $with, $cancle_mail_free_account_admin);
                    $utf = "utf-8";
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $cancle_mail_free_account_admin =
                            $email_template_content_cancle_admin[0]['description_en'];
                    $message =
                            str_replace($replace, $with, $cancle_mail_free_account_admin);
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }
//end changes
                // try send mail ant if not able print debug
                $this->email->send();
            }


            //Delete additional email
            $this->additional_email_model->delete_additional_email_by_userid($user_id);

            //Delete Invoice
            //$this->invoice_model->delete_invoice_by_userid($user_id);
            //Loged out
            if ($this->session->userdata('is_logged_in')) {
                $reuired_sessiondata =
                        array(
                            'session_id' => $this->session->userdata('session_id'),
                            'ip_address' => $this->session->userdata('ip_address'),
                            'user_agent' => $this->session->userdata('user_agent'),
                            'last_activity' => $this->session->userdata('last_activity'),
                            'language_shortcode' => $this->session->userdata('language_shortcode'),
                );

                $array_items =
                        array(
                            'username' => '',
                            'user_id' => '',
                            'type_of_membership' => '',
                            'is_logged_in' => false);
                $this->session->unset_userdata($array_items);
                //$this->session->sess_destroy();
                //set session required
                $this->session->set_userdata($reuired_sessiondata);
                $this->session->set_flashdata('flash_message', '<strong>' . _clang(WELL_DONE_YOUR_PROFILE) . '</strong>');
                $this->session->set_flashdata('flash_class', 'alert-success');
                $redirect_to_home = true;
// redirect('home');
            }
        } else if ($type_of_membership ==
                'PRE1') {
            $array =
                    array(
                        "type_of_membership" => 'FREE',
            );
            if (@$this->user_model->update_user($user_id, $array) ==
                    TRUE) {
                $this->session->set_flashdata('flash_message', '<strong>' . _clang(YOUR_PROFILE_RESET_TO) . '</strong>');
                $this->session->set_flashdata('flash_class', 'alert-success');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                //Delete all schedule
                //$this->schedule_model->delete_schedule_with_userid($user_id);
                //delete all subscribe
                //$this->subscribe_model->delete_subscribe_with_userid($user_id);
                //Moved to free user
                if ($this->session->userdata('is_logged_in')) {
                    $this->session->unset_userdata(array(
                        'type_of_membership' => '',
                    ));
                    $session =
                            array(
                                'type_of_membership' => 'FREE',
                    );
                    //$this->session->set_userdata($session);
                }
            } else {
                $this->session->set_flashdata('flash_message', '<strong>' . _clang(OOPS_SOMETHING_WENT_WRONG) . '</strong>');
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
            }
        } else if ($type_of_membership ==
                'PRE2') {

            $array =
                    array(
                        "type_of_membership" => 'FREE',
            );
            if (@$this->user_model->update_user($user_id, $array) ==
                    TRUE) {
                $this->session->set_flashdata('flash_message', '<strong>' . _clang(YOUR_PROFILE_RESET_TO) . '</strong>');
                $this->session->set_flashdata('flash_class', 'alert-success');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
                //Delete all schedule
                //$this->schedule_model->delete_schedule_with_userid($user_id);
                //delete all subscribe
                //$this->subscribe_model->delete_subscribe_with_userid($user_id);
                //Moved to free user
                if ($this->session->userdata('is_logged_in')) {
                    $this->session->unset_userdata(array(
                        'type_of_membership' => '',
                    ));
                    $session =
                            array(
                                'type_of_membership' => 'FREE',
                    );
                    $this->session->set_userdata($session);
                }
            } else {
                $this->session->set_flashdata('flash_message', '<strong>' . _clang(OOPS_SOMETHING_WENT_WRONG) . '</strong>');
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_mynl_tab', 'tab_4');
            }
        }

        //Sending mail
        if ($type_of_membership != 'FREE') {
            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            //First mail to user
            $email = $user_data[0]['primary_email'];


            if (valid_email($email)) {
                // compose email
//                $get_admin_detail =
//                        get_admin_detail(); //common helper function for admin detail
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                $this->email->subject('Your Account has been cancled from knewdog!');
                /* $message = '<style>p{margin-bottom:2px;}</style>
                  <p>Your Password : '.$pass.'</p>
                  <p>Thanks,<br/>KnewDog Team.</p>'; */

                $invoice_data =
                        $this->invoice_model->get_invoice_custome_query("select * from invoice where user_id = '" . $user_id . "' and payment_type like '" . $type_of_membership . "%' and date_to > curdate()");

                $end_of_subscription =
                        $invoice_data[0]["date_to"];
                $start_of_subsription =
                        $invoice_data[0]["date_from"];
                $invoice_amount =
                        ($invoice_data[0]['amount'] *
                        $invoice_data[0]['quantity']);
                $mail_data['cancle_amount'] =
                        round(return_calculation($end_of_subscription, $start_of_subsription, $invoice_amount), 2);

                $mail_data['account_type'] =
                        get_type_of_membership_txt($type_of_membership);
                $mail_data['cancle_username'] = $user_data[0]['username'];

                //bhushan changes    
                $session_lang =
                        $this->session->userdata('language_shortcode');
                $replace = array('{account_type}', '{cancle_username}', '{cancle_amount}');
                $with = array("{$mail_data['account_type']}", "{$mail_data['cancle_username']}", "{$mail_data['cancle_amount']}");
                $email_template_content =
                        $this->email_template_model->get_email_template_by_id(4);
                if (isset($email_template_content[0]['description_' . $session_lang]) &&
                        !empty($email_template_content[0]['description_' . $session_lang])) {
                    $cancellation_email_content =
                            $email_template_content[0]['description_' . $session_lang];
                    $message =
                            str_replace($replace, $with, $cancellation_email_content);
                    $utf = "utf-8";
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $cancellation_email_content =
                            $email_template_content[0]['description_en'];
                    $message =
                            str_replace($replace, $with, $cancellation_email_content);
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }

                //end changes
//							$message = $this->load->view('mail_templates/cancle_account_mail', $mail_data,true); 
//						  	$this->email->message($message);  
                // try send mail ant if not able print debug
                $this->email->send();
            }


            //second mail to admin
            $get_admin_detail =
                    get_admin_detail(); //common helper function for admin detail
            $email =
                    $get_admin_detail['email'];
            if (valid_email($email)) {
                // compose email
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                $this->email->subject('One Account has been cancled from knewdog!');

                $mail_data['account_type'] =
                        get_type_of_membership_txt($type_of_membership);
                $mail_data['answer'] =
                        $answer;
                $mail_data['user'] =
                        $user_data[0]['username'];
                $mail_data['user_email'] =
                        $user_data[0]['primary_email'];
                //$type_of_membership = $user_data[0]['type_of_membership'];
                //echo "select * from invoice where user_id = '".$user_id."' and payment_type like '".$type_of_membership."%' and date_to > curdate()";
                $invoice_data =
                        $this->invoice_model->get_invoice_custome_query("select * from invoice where user_id = '" . $user_id . "' and payment_type like '" . $type_of_membership . "%' and date_to > curdate()");

                $end_of_subscription =
                        $invoice_data[0]["date_to"];
                $start_of_subsription =
                        $invoice_data[0]["date_from"];
                $invoice_amount =
                        ($invoice_data[0]['amount'] *
                        $invoice_data[0]['quantity']);
                $mail_data['amount'] =
                        round(return_calculation($end_of_subscription, $start_of_subsription, $invoice_amount), 2);


                //bhushan changes    
                $session_lang =
                        $this->session->userdata('language_shortcode');
                $replace =
                        array(
                            '{c_admin_account_type}',
                            '{answer}',
                            '{user}',
                            '{user_email}',
                            '{amount}');
                $with =
                        array(
                            "{$mail_data['account_type']}",
                            "{$mail_data['answer']}",
                            "{$mail_data['user']}",
                            "{$mail_data['user_email']}",
                            "{$mail_data['amount']}");

                $email_template_content =
                        $this->email_template_model->get_email_template_by_id(5);

                if (isset($email_template_content[0]['description_' . $session_lang]) &&
                        !empty($email_template_content[0]['description_' . $session_lang])) {
                    $cancle_mail_account_admin =
                            $email_template_content[0]['description_' . $session_lang];
                    $message =
                            str_replace($replace, $with, $cancle_mail_account_admin);
                    $utf = "utf-8";
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                } else {
                    $cancle_mail_account_admin =
                            $email_template_content[0]['description_en'];
                    $message =
                            str_replace($replace, $with, $cancle_mail_account_admin);
                    $content =
                            "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                    $this->email->message($content);
                }
//end changes
                //echo '<pre>'; print_r($invoice_data);
                //echo print_r($mail_data);
                //die;
//							$message = $this->load->view('mail_templates/cancle_account_mail_admin', $mail_data,true); 
//						  	$this->email->message($message);  
                // try send mail ant if not able print debug
                $this->email->send();
            }
        }

        //sending mail end
        if ($redirect_to_home == TRUE) {
            redirect('home');
        } else {
            redirect('myknewdog');
        }
    }

    function do_upload($filename) {
        $config['upload_path'] =
                './uploads/';
        $config['allowed_types'] =
                'gif|jpg|png';
        $config['max_size'] =
                '2048';
        $config['max_width'] =
                '0';
        $config['max_height'] =
                '0';
        $config['overwrite'] =
                FALSE;
        $config['encrypt_name'] =
                TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($filename)) {
            $response =
                    array(
                        'error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
        } else {
            $response =
                    array(
                        'upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
        }

        return $response;
    }
	
    function validate_category($str) {
        $array_value =
                $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <=
                3) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_keyword($str) {
        $array_value =
                $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <=
                20) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
