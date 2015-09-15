<?php

class Admin_comment extends CI_Controller {
    /**
     * name of the folder responsible for the views 
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/comment';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('site_language_model');
        $this->load->model('comment_model');

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

        $config['base_url'] = base_url() . 'kd2a2a0u1g4/comment';
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
            $data['count_products'] = $this->comment_model->count_comment($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['comment'] = $this->comment_model->get_comment($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['comment'] = $this->comment_model->get_comment($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['comment'] = $this->comment_model->get_comment('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['comment'] = $this->comment_model->get_comment('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['comment_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->comment_model->count_comment();
            $data['comment'] = $this->comment_model->get_comment('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper 
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/comment/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function add() {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation
            //$this->form_validation->set_rules('location', 'Location', 'required');
            //$this->form_validation->set_rules('block_name', 'Block name', 'required|is_unique[comment.block_name]');
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'E-mail ', 'required|valid_email');
            $this->form_validation->set_rules('comment', 'Comment', 'required');
            //$this->form_validation->set_rules('language_define', 'language Define', 'required|is_unique[comment.language_define]');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            //echo $password = $this->functions->get_something(); die;
            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                /* $data_to_store = array(
                  'location' => $this->input->post('location'),
                  'language_define' => $this->input->post('language_define'),
                  );
                  echo '<pre>';print_r($_POST);
                  echo '<pre>'; print_r($data_to_store);
                  die; */
                //$this->db->set('password', $this->__encrip_password($this->input->post('password')));
                //if the insert has returned true then we show the flash message
                //echo '<pre>'; print_r($_POST); die;
                //echo '<pre>'; print_r($_POST); die;
                $redirect_url = $this->session->userdata('redirect_url');
                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }

                if ($this->comment_model->store_comment($_POST)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('kd2a2a0u1g4/comment/');
                    //redirect('kd2a2a0u1g4/language'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/comment/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id 
        $id = $this->uri->segment(4);
//        echo "<pre>";print_r($_POST);exit;
        //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //form validation
            //$this->form_validation->set_rules('name', 'Name', 'required');
            //$this->form_validation->set_rules('email', 'E-mail ', 'required|valid_email');
            //$this->form_validation->set_rules('comment', 'Comment', 'required');
            //$this->form_validation->set_rules('language_define', 'language Define', 'required|edit_unique[comment.language_define.'.$id.']');
            //$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            /* if ($this->form_validation->run())
              { */


            //if the insert has returned true then we show the flash message
            //echo '<pre>'; print_r($_POST);
            /* $post = array();
              foreach($_POST as $key => $value){
              $doc = new DOMDocument();
              $doc->loadHTML($value);
              $yourText = $doc->saveHTML();
              $post[$key] = mysql_real_escape_string(nl2br(htmlentities($yourText)));

              } */

            //echo '<pre>'; print_r($post); die;
            $redirect_url = $this->session->userdata('redirect_url');
            foreach ($_POST as $k => $v) {
                if (in_array($k, array('redirect_url'))) {
                    unset($_POST[$k]);
                }
            }

            if ($this->comment_model->update_comment($id, $_POST) == TRUE) {
                $this->session->set_flashdata('flash_message', 'updated');
            } else {
                $this->session->set_flashdata('flash_message', 'not_updated');
            }
            $this->session->set_flashdata('flash_message', 'update');
            //redirect('kd2a2a0u1g4/comment/');
            redirect($redirect_url);

            //}//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data 

        $data['comment'] = $this->comment_model->get_comment_by_id($id);

        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/comment/edit';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//update

    public function status() {
        $id = $this->uri->segment(4);
        $comment_data = $this->comment_model->get_comment_by_id($id);
        if ($comment_data[0]['status'] == 'Inactive') {
            $data_to_store = array(
                'status' => 'Active'
            );
        } else {

            $data_to_store = array(
                'status' => 'Inactive'
            );
        }
        //echo '<pre>';print_r($data_to_store); die;
        //if the insert has returned true then we show the flash message
        if ($this->comment_model->update_comment($id, $data_to_store) == TRUE) {
            $this->session->set_flashdata('flash_message', 'updated');
        } else {
            $this->session->set_flashdata('flash_message', 'not_updated');
        }
        $this->session->set_flashdata('flash_message', 'update');
        $redirect_url = $this->session->userdata('redirect_url');
        redirect($redirect_url);
        //redirect('kd2a2a0u1g4/wanted_add/update/'.$id.'');
    }

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id 
        $id = $this->uri->segment(4);
        $this->comment_model->delete_comment($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('kd2a2a0u1g4/comment/');
    }

//edit
}