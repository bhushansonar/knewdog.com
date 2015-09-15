<?php

class Blog extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'blog';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('blog_model');
        $this->load->model('comment_model');
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('recaptcha');
        if (!$this->session->userdata('is_logged_in')) {
            //redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $user_id = $this->session->userdata('user_id');


        //$order_type = $this->input->post('order_type');
        //pagination settings
        $config['per_page'] = 20;
        $config["uri_segment"] = 2;
        $config['base_url'] = base_url() . 'blog';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $page = ($this->uri->segment(2, 0)) ? $this->uri->segment(2, 0) : 0;

        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if (!empty($order_type)) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            $order_type = 'DESC';
        }
        $order = "published_date";
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;
        $search_string = '';
        $where_field = array("schedule_status");
        $where_value = array("Active");

        //My Newsletter ********************************************
        //pagination settings
        //if order type was changed
        //filtered && || paginated
        if ($this->uri->segment(2) == true) {

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
            $data['count_blog'] = $this->blog_model->count_blog($search_string, $order, 'Active', $where_field, $where_value);
            $config['total_rows'] = $data['count_blog'];
            ;
            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['blog'] = $this->blog_model->get_blog($search_string, $order, $order_type, $config['per_page'], $limit_end, 'Active', $where_field, $where_value);
                } else {
                    $data['blog'] = $this->blog_model->get_blog($search_string, '', $order_type, $config['per_page'], $limit_end, 'Active', $where_field, $where_value);
                }
            } else {
                if ($order) {
                    $data['blog'] = $this->blog_model->get_blog('', $order, $order_type, $config['per_page'], $limit_end, 'Active', $where_field, $where_value);
                } else {
                    $data['blog'] = $this->blog_model->get_blog('', '', $order_type, $config['per_page'], $limit_end, 'Active', $where_field, $where_value);
                }
            }
        } else {

            //clean filter data inside section

            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            //$filter_session_data['selected_language_id'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['order'] = null;


            //fetch sql data into arrays

            $data['blog'] = $this->blog_model->get_blog('', '', $order_type, $config['per_page'], $limit_end, 'Active', $where_field, $where_value);
            $data['count_blog'] = $this->blog_model->count_blog($search_string, $order, 'Active', $where_field, $where_value);
            $config['total_rows'] = $data['count_blog'];
        }//!isset($search_string) && !isset($order)
        //MY newsletter ******************************************************************

        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['main_content'] = 'blog_view';
        $this->load->view('includes/template', $data);
    }

//index

    function specific() {

        $id = $this->uri->segment(4);
        $tit = $this->uri->segment(3);

        $config['per_page'] = 10;
        $config["uri_segment"] = 5;
        $config['base_url'] = base_url() . 'blog/specific/' . $tit . "/" . $id;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        //$page = ($this->uri->segment(5));
        $page = ($this->uri->segment(5, 0)) ? $this->uri->segment(5, 0) : 0;
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }
        $data['count_comment'] = $this->comment_model->count_comment('', '', $id);
        $config['total_rows'] = $data['count_comment'];

        $data['blog'] = $this->blog_model->get_blog_by_id($id);


        $data['all_comment'] = $this->comment_model->get_comment('', 'comment_id', 'DESC', $config['per_page'], $limit_end, 'Active', array("comment.blog_id", "comment.status"), array($id, "Active"));
        //echo "<pre>";print_r($data['all_comment']);exit;
        $data['comment_count'] = count($this->comment_model->get_comment('', 'comment_id', 'DESC', '', '', 'Active', array("comment.blog_id", "comment.status"), array($id, "Active")));
        //echo '<pre>'; print_r($config); die;
        $data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html('', true);
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['main_content'] = 'blog_specific_view';
        $this->load->view('includes/template', $data);
    }

    function comment() {
        //product id
        //$id = $this->session->userdata("user_id");
        //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');
            //$this->form_validation->set_rules('Submit', '', 'required');
            $this->recaptcha->recaptcha_check_answer();
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
            $this->form_validation->set_rules('comment', 'Comment', 'trim|required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            $redirect_url = $this->session->flashdata('redirect_url');


            if ($this->form_validation->run() && $this->recaptcha->getIsValid()) {

                /* $data_to_store = array(
                  'keyword_name' => $this->input->post('keyword_name'),
                  'status' => $this->input->post('status'),
                  ); */
                //if the insert has returned true then we show the flash message

                $array = array();
                $array = $_POST;
                //echo '<pre>';print_r($array); die;
                foreach ($array as $k => $v) {
                    if (in_array($k, array('Submit', 'recaptcha_challenge_field', 'recaptcha_response_field', 'submit'))) {
                        unset($array[$k]);
                    }
                    /* if(is_array($v)){
                      $array[$k] = implode(",",$v);
                      }
                      if ($k == 'password'){
                      $array[$k] = md5($v);
                      } */
                }
                //print_r($array); die;
                if (@$this->comment_model->store_comment($array) == TRUE) {
                    $this->session->set_flashdata('flash_message', '' . _clang(YOUR_COMMENT_IS_WAITING) . '');
                    $this->session->set_flashdata('flash_class', 'alert-success');
                } else {
                    $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                }
                redirect($redirect_url);
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');
            } else {
                if (!$this->recaptcha->getIsValid()) {
                    $this->session->set_flashdata('flash_message', '' . _clang(OOPS_SOMETHING_WENT_WRONG) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                } else {
                    $this->session->set_flashdata('flash_message', '' . _clang(INCORRECT_CREDENTIALS) . '');
                    $this->session->set_flashdata('flash_class', 'alert-error');
                }
                $this->session->set_flashdata('validation_error_messages', validation_errors());
                redirect($redirect_url);
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data
    }

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

