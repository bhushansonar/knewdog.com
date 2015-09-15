<?php
class Admin_language_keyword extends CI_Controller {
    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'kd2a2a0u1g4/language_keyword';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	
    public function __construct()
    {
        parent::__construct();
		 $this->load->model('site_language_model');
        $this->load->model('language_keyword_model');

        if(!$this->session->userdata('is_logged_in_admin')){
            redirect('kd2a2a0u1g4/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 50;

        $config['base_url'] = base_url().'kd2a2a0u1g4/languagekeyword';
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
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
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
        if($search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */
            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if(isset($filter_session_data)){
              $this->session->set_userdata($filter_session_data);    
            }
            
            //fetch sql data into arrays
            $data['count_products']= $this->language_keyword_model->count_language_keyword($search_string, $order);
          	$config['total_rows'] = $data['count_products'];
//die;
            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['language'] = $this->language_keyword_model->get_language_keyword($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['language'] = $this->language_keyword_model->get_language_keyword($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['language'] = $this->language_keyword_model->get_language_keyword('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['language'] = $this->language_keyword_model->get_language_keyword('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['language_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products']= $this->language_keyword_model->count_language_keyword();
            $data['language'] = $this->language_keyword_model->get_language_keyword('', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_products'];

        }//!isset($search_string) && !isset($order)
         
        //initializate the panination helper
		//echo"<pre>"; print_r($config); exit;
        $this->pagination->initialize($config);   
        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/language_keyword/list';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
		    $this->form_validation->set_rules('location', 'Location', 'required');
			$this->form_validation->set_rules('language_define', 'language Define', 'required|is_unique[language_keyword.language_define]');
			$this->form_validation->set_rules('en', 'English', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            
			//echo $password = $this->functions->get_something(); die;
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                /*$data_to_store = array(
                    'location' => $this->input->post('location'),
					'language_define' => $this->input->post('language_define'),
                );
				echo '<pre>';print_r($_POST); 
				echo '<pre>'; print_r($data_to_store);
				die;*/
				//$this->db->set('password', $this->__encrip_password($this->input->post('password')));
				
                //if the insert has returned true then we show the flash message
                if($this->language_keyword_model->store_language_keyword($_POST)){
                    $data['flash_message'] = TRUE;
					$this->session->set_flashdata('flash_message', 'add');
					redirect('kd2a2a0u1g4/languagekeyword/');
					 //redirect('kd2a2a0u1g4/language'.'');
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }
			//print_r($data)
//$data['main_content'] = 'kd2a2a0u1g4/language_keyword/list';
        //$this->load->view('kd2a2a0u1g4/includes/template', $data); 
		//$this->session->set_flashdata('flash_message',$data);
        }
        //load the view
		//redirect('kd2a2a0u1g4/login');
		//$this->language_keyword_model->count_language_keyword();
		$data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
        $data['main_content'] = 'kd2a2a0u1g4/language_keyword/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        //product id 
        $id = $this->uri->segment(4);
  //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('location', 'Location', 'required');
			$this->form_validation->set_rules('en', 'English', 'required');
			//$this->form_validation->set_rules('language_define', 'language Define', 'required|edit_unique[language_keyword.language_define.'.$id.']');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                /*$data_to_store = array(
                    'language_shortcode' => $this->input->post('language_shortcode'),
					'language_longform' => $this->input->post('language_longform'),
					 'status' => $this->input->post('status'),
                );*/
                //if the insert has returned true then we show the flash message
				$redirect_url = $this->input->post('redirect_url');
				foreach($_POST as $k=>$v){
						if (in_array($k,array('redirect_url'))) 
					 	{
								unset($_POST[$k]);
						}
					}
                if(@$this->language_keyword_model->update_language_keyword($id, $_POST) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
				$this->session->set_flashdata('flash_message', 'update');
				
				redirect($redirect_url);
                //redirect('kd2a2a0u1g4/language/update/'.$id.'');

            }//validation run
		
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
		
		
        $data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
		$data['language'] = $this->language_keyword_model->get_language_keyword_by_id($id);
        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/language_keyword/edit';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);            

    }//update

    /**
    * Delete product by his id
    * @return void
    */
    public function delete()
    {
        //product id 
        $id = $this->uri->segment(4);
        $this->language_keyword_model->delete_language_keyword($id);
		$this->session->set_flashdata('flash_message', 'delete');
		redirect('kd2a2a0u1g4/languagekeyword/');
    }//edit
	
}