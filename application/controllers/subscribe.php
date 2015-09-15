<?php
class Subscribe extends CI_Controller {
    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = '';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	
    public function __construct()
    {
        parent::__construct();
		$this->load->model('newsletter_model');
        $this->load->model('user_model');
		$this->load->model('subscribe_model');

        if(!$this->session->userdata('is_logged_in')){
           // redirect('kd2a2a0u1g4/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
         

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            //$this->form_validation->set_rules('keyword_define', 'keyword define', 'required|is_unique[newsletter_keyword.keyword_define]');
			//$this->form_validation->set_rules('en', 'Keyword for English', 'required');
            //$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            

            //if the form has passed through the validation
               $data_to_store = array(
                    's_newsletter_id' => $this->input->post('s_newsletter_id'),
					 's_user_id' => $this->input->post('s_user_id'),
					 'schedule_id' => $this->input->post('schedule_id'),
					 'subscribe_date' => date("Y-m-d H:i:s"),
                );
                //if the insert has returned true then we show the flash message
				
                if($this->subscribe_model->store_subscribe($data_to_store)){
					/*$newsletter_data1 = $this->newsletter_model->get_newsletter_by_id($this->input->post('s_newsletter_id'));
					$newsletter_data = $this->newsletter_model->just_get_last_sn_id($newsletter_data1[0]['newsletter_rand_id']);
					$update_array = array(
					"sn_of_last_newsletter" => $newsletter_data[0]['sn']
					);
					$this->user_model->update_user($this->input->post('s_user_id'),$update_array);*/
					echo "success";
					
                     //redirect('kd2a2a0u1g4/keyword'.'');
                }else{
                    //$data['flash_message'] = FALSE; 
                }

          //print_r($data)
//$data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/list';
        //$this->load->view('kd2a2a0u1g4/includes/template', $data); 
		//$this->session->set_flashdata('flash_message',$data);
        }
        //load the view
		//redirect('kd2a2a0u1g4/login');
		
		
    }       

    /**
    * Update item by his id
    * @return void
    */
	
	 public function edit()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            //$this->form_validation->set_rules('keyword_define', 'keyword define', 'required|is_unique[newsletter_keyword.keyword_define]');
			//$this->form_validation->set_rules('en', 'Keyword for English', 'required');
            //$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            
			$s_newsletter_id = $this->input->post('s_newsletter_id');
			$s_user_id = $this->input->post('s_user_id');
            //if the form has passed through the validation
               $data_to_store = array(
                    
					 'schedule_id' => $this->input->post('schedule_id'),
                );
                //if the insert has returned true then we show the flash message
				$s_sub_field = array("s_newsletter_id","s_user_id");
				$s_sub_value = array($s_newsletter_id,$s_user_id);
                if($this->subscribe_model->update_subscribe_with_user_id_nl_id($s_sub_field,$s_sub_value,$data_to_store)){
							$this->session->set_flashdata('flash_message', _clang(YOUR_SUBSCRIPTION_UPDATED));
							$this->session->set_flashdata('flash_class', 'alert-success');
							$this->session->set_flashdata('flash_mynl_tab', 'tab_2');
					
                     		
                }else{
                    		$this->session->set_flashdata('flash_message', _clang(OOPS_SOMTHING_WENT_WRONG));
							$this->session->set_flashdata('flash_class', 'alert-error');
							$this->session->set_flashdata('flash_mynl_tab', 'tab_2');
                }
				redirect("newsletter");

          //print_r($data)
//$data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/list';
        //$this->load->view('kd2a2a0u1g4/includes/template', $data); 
		//$this->session->set_flashdata('flash_message',$data);
        }
		$this->session->set_flashdata('flash_message', _clang(OOPS_SOMTHING_WENT_WRONG));
		$this->session->set_flashdata('flash_class', 'alert-error');
		$this->session->set_flashdata('flash_mynl_tab', 'tab_2');
        redirect("newsletter");
		
    }       

	
	
    public function update()
    {
        //product id 
        $id = $this->uri->segment(4);
  //echo "hi"; die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            //$this->form_validation->set_rules('keyword_name', 'keyword name', 'required|edit_unique[newsletter_keyword.keyword_name.'.$id.']');
			$this->form_validation->set_rules('en', 'Keyword for English', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
    
                /*$data_to_store = array(
                    'keyword_name' => $this->input->post('keyword_name'),
					 'status' => $this->input->post('status'),
                );*/
                //if the insert has returned true then we show the flash message
                if($this->newsletter_keyword_model->update_keyword($id, $_POST) == TRUE){
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
				$this->session->set_flashdata('flash_message', 'update');
				redirect('kd2a2a0u1g4/keyword/');
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');

            }//validation run
		
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
		
		 $data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
        $data['keyword'] = $this->newsletter_keyword_model->get_keyword_by_id($id);
        //load the view
        $data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/edit';
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
        $this->newsletter_keyword_model->delete_keyword($id);
		$this->session->set_flashdata('flash_message', 'delete');
		redirect('kd2a2a0u1g4/keyword/');
    }//edit

}