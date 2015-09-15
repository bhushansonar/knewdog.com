<?php
class Signup extends CI_Controller {

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
		$data['main_content'] = 'signup_view';
		$this->load->view('includes/template', $data); 
	}
    /**
    ** 
    ** @return mixed
    **/	
   function create_member()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		//$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[4]|is_unique[user.username]');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|is_unique[user.primary_email]');
		$this->form_validation->set_message('is_unique', 'The %s is already taken! Please choose another.');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
		if($this->input->post('redirect'))
		{
			$redirect = $this->input->post('redirect');
		}else{
			$redirect = '';
		}
		 if ($this->form_validation->run())
            {
				
				$pass = generate_password();
				$email = $this->input->post('email');
                $user_rand_id = $this->functions->get_user_rand_id();
				$data_to_store = array(
					'user_rand_id' => $user_rand_id,
                   	'username' => $this->input->post('username'),
					'password' => md5($pass),
					'primary_email' => $email,
					'type_of_membership' => 'FREE',
					'date_of_registration' => date("Y-m-d H:i:s"),
					'status' => 'Inactive'
			    );
                //if the insert has returned true then we show the flash message
              
					 $this->load->helper('email');
    				//load email library
    				$this->load->library('email');
    
    				//read parameters from $_POST using input class
    				 // check is email addrress valid or no
						if (valid_email($email)){  
						  // compose email
						  $get_admin_detail = get_admin_detail(); //common helper function for admin detail
						  $this->email->from($get_admin_detail['email'] , $get_admin_detail['name']); 
						  $this->email->to($email); 
						  $this->email->set_mailtype("html");
						  $this->email->subject('Register confirmation for KnewDog!');
						  	$mail_data['url'] = site_url().'home/confirm/'.base64url_encode($email);
							$message = $this->load->view('mail_templates/signup_mail', $mail_data,true); 
						  	$this->email->message($message);
						  
						  // try send mail ant if not able print debug
						  if ( ! $this->email->send())
						  {
							$msgadd = "<strong>E-mail not sent </strong>";//.$this->email->print_debugger();  
							 $data['flash_message'] = TRUE;
							$this->session->set_flashdata('flash_class','alert-error');
									$this->session->set_flashdata('flash_message', $msgadd);
								if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('signup');    
								}
						  }else{
							  if($this->user_model->store_user($data_to_store)){
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-success');
									$this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We have sent you a link to confirm your subscription.');
									if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('signup');    
								}
									 //redirect('kd2a2a0u1g4/user'.'');
								}else {
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-error');
									$this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
								if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('signup');    
								}
									
									}
							  
							  }
						}
				

            }else {
					if($redirect == 'home'){
						$this->session->set_flashdata('validation_error_messages',validation_errors());
						redirect('home');
					}
				}
		
		$data['main_content'] = 'signup_view';
		$this->load->view('includes/template', $data); 
	}
	
	function set_password()
	{
			 
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
			 if ($this->form_validation->run())
            {
				$email = base64url_decode($this->input->post('email'));
                $data_to_store = array(
                   	'password' => md5($this->input->post('password')),
					'account_confirmed' => 'YES',
					'status' => 'Active'
			    );
				 if($this->user_model->update_user_by_email($email,$data_to_store)){
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-success');
									$this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We sent you password on your E-mail.');
									redirect('signup');
									 //redirect('kd2a2a0u1g4/user'.'');
								}else {
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-error');
									$this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
								redirect('signup'); 
									
									}
			}
		
	}

}