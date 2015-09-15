<?php
class Blog extends CI_Controller {
    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    //const VIEW_FOLDER = 'kd2a2a0u1g4/site_language';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	
    public function __construct()
    {
        parent::__construct();
       
        /*if(!$this->session->userdata('is_logged_in')){
            redirect('kd2a2a0u1g4/login');
        }*/
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
  	public function index(){
		
		$data['main_content'] = 'blog_view';
        $this->load->view('includes/template', $data);  

	
	}
	public function profile_delete(){
		$id = $this->input->post('language_id');
		$field = $this->input->post('field');
		$user_id = $this->input->post('table_id');
		$get_user = $this->user_model->get_user_by_id($user_id);
		$data = $get_user[0][$field];
		$newdata = explode(",",$data);
		//print_r($newdata);
		if (in_array($id, $newdata)) 
			{
				unset($newdata[array_search($id,$newdata)]);
			}
		//print_r($newdata);
		if(count($newdata) > 0){
			$str = implode(",",$newdata);
			$array = array($field => $str);
		}else{
			$array = array($field => '');
			}
			//print_r($array);
		if($this->user_model->update_user($user_id, $array) == true)
		{
			return true;
		}
		
		}
	public function popups_ajax(){
	
		$cls = $this->uri->segment(3);
		if($cls == 'subscribe_1'){
			$this->load->model('newsletter_model');
			$newsletter_id = $this->uri->segment(4);
			$user_id = $this->uri->segment(5);
			$data['cls'] = $cls;
			$data['user_id'] = $user_id;
			
			$where_Sfield = array('s_newsletter_id','s_user_id');
			$where_Svalue = array($newsletter_id,$user_id);
			$data['subscribe'] = $this->subscribe_model->get_subscribe('', '', '','', '',$where_Sfield,$where_Svalue);
			$where_field_schedule = array('sd_user_id');		
			$where_value_schedule = array($user_id);
			$data['schedule'] = $this->schedule_model->get_schedule('', 'schedule_id', 'ASC', '','',$where_field_schedule,$where_value_schedule);						  
					$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
					$this->load->view('includes/popups_ajax.php',$data);  
			
		}else if($cls == 'subscribe_1_edit'){
			
			$this->load->model('newsletter_model');
			$newsletter_id = $this->uri->segment(4);
			$schedule_id = $this->uri->segment(5);
			$user_id = $this->session->userdata('user_id');
			$data['cls'] = $cls;
			$data['user_id'] = $user_id;
			
			$where_Sfield = array('s_newsletter_id','s_user_id');
			$where_Svalue = array($newsletter_id,$user_id);
			$data['subscribe'] = $this->subscribe_model->get_subscribe('', '', '','', '',$where_Sfield,$where_Svalue);
			$where_field_schedule = array('sd_user_id');		
			$where_value_schedule = array($user_id);
			$data['schedule'] = $this->schedule_model->get_schedule('', 'schedule_id', 'ASC', '','',$where_field_schedule,$where_value_schedule);
			$data['schedule_id'] = $schedule_id;				  
			$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
			$this->load->view('includes/popups_ajax.php',$data);  
			
		}
		elseif($cls == 'subscribe_success'){
			$this->load->model('newsletter_model');
			$newsletter_id = $this->uri->segment(4);
			$data['cls'] = $cls;
			$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
			$this->load->view('includes/popups_ajax.php',$data);  
			}
		elseif($cls == 'unsubscribe'){
			$this->load->model('newsletter_model');
			$newsletter_id = $this->uri->segment(4);
			$user_id = $this->uri->segment(5);
			
			$this->subscribe_model->delete_subscribe_with_userid_newsletterid($user_id,$newsletter_id);
				echo "delete";
			}
		elseif($cls == 'profile'){
			$user_id = $this->session->userdata('user_id');
			$data['cls'] = $cls;
			$data['number'] = $this->uri->segment(4);
			$data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '','','Active');
			$data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '','','Active','');
			$data['countries'] = $this->user_model->get_countries('country_name','ASC');	
			$data['user'] = $this->user_model->get_user_by_id($user_id);
			$this->load->view('includes/popups_ajax.php',$data);  
			}
		elseif($cls == 'schedule'){
			$user_id = $this->session->userdata('user_id');
			$data['cls'] = $cls;
			$schedule_id = $this->uri->segment(4);
			$data['user'] = $this->user_model->get_user_by_id($user_id);
			$data['schedule'] = $this->schedule_model->get_schedule_by_id($schedule_id);
			//print_r($data['schedule']); die;
			$this->load->view('includes/popups_ajax.php',$data);  
		}elseif($cls == 'account_settings'){
			$user_id = $this->session->userdata('user_id');
			$data['cls'] = $cls;
			$data['number'] = $this->uri->segment(4);
			$data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '','','Active');
			$data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '','','Active','');
			$data['site_language'] = $this->site_language_model->get_language('', '', '', '','','Active','');
			$data['countries'] = $this->user_model->get_countries('country_name','ASC');	
			$data['user'] = $this->user_model->get_user_by_id($user_id);
			$this->load->view('includes/popups_ajax.php',$data);  
		}
	}
	
	
}