<?php
class Help extends CI_Controller {

	 public function __construct()
    {
        parent::__construct();
		
		$this->load->model('user_model');

        if(!$this->session->userdata('is_logged_in')){
            //redirect('kd2a2a0u1g4/login');
        }
    }
    /**
    ** Check if the user is logged in, if he's not, 
    ** send him to the login page
    ** @return void
    **/
	function index()
	{
		$block_name = $this->uri->segment(2);
		if(empty($block_name)){
			$data['cms_block'] = "HELP_PAGE";
		}else{
			$data['cms_block'] = $block_name;
			}
		$data['main_content'] = 'help_view';
		$this->load->view('includes/template', $data);
	}
    /**
    ** 
    ** @return mixed
    **/	

}