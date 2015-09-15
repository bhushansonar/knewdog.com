<?php
class Dashboard extends CI_Controller {
    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */	
	function index()
	{   
           // echo "enter"; die;
            $this->load->model('comment_model');
		if(!$this->session->userdata('is_logged_in_admin')){
            redirect('kd2a2a0u1g4/login');
        }
		if(!$this->session->userdata('username')){
				$this->session->unset_userdata('is_logged_in_admin');
				$this->session->sess_destroy();
					 redirect('kd2a2a0u1g4/login');
				}
		//if($this->session->userdata('is_logged_in')){
                 $data['untreated_comment']= $this->comment_model->count_untreated_comment();
                 $data['main_content'] = 'kd2a2a0u1g4/dashboard_view';
        $this->load->view('kd2a2a0u1g4/includes/template', $data); 
			//$this->load->view('home_view');	
        //}else{
        	//$this->load->view('kd2a2a0u1g4/login');	
        //}
		
	}

    /**
    * encript the password 
    * @return mixed
    */	
   

}