<?php
class Error extends CI_Controller {

	 public function __construct()
    {
        parent::__construct();
		
		$this->load->model('user_model');
		$this->load->library('recaptcha');
		
        if(!$this->session->userdata('is_logged_in')){
            //redirect('kd2a2a0u1g4/login');
        }
    }
	
	function index()
	{
		
		$data['main_content'] = 'error_view';
		//$data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
		$this->load->view('includes/template', $data); 
		
	}
	
	function contactus_data()
	{
		$this->load->library('form_validation');
		$this->recaptcha->recaptcha_check_answer();
		//echo "captch->".$this->recaptcha->getIsValid(); die;
		
		
		// field name, error message, validation rules
		//$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'User name', 'trim|required');
		$this->form_validation->set_rules('usermail', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('usersite', 'usersite', 'trim');
		$this->form_validation->set_rules('subject', 'subject', 'trim');
		$this->form_validation->set_rules('message', 'message', 'trim|required');
		//$this->form_validation->set_message('is_unique', 'The %s is already taken! Please choose another.');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
		if($this->input->post('redirect'))
		{
			$redirect = $this->input->post('redirect');
		}else{
			$redirect = '';
			}
		 if ($this->form_validation->run() && $this->recaptcha->getIsValid() )
            {
				
				//$pass = generate_password();
				$username = $this->input->post('username');
				$usermail = $this->input->post('usermail');
				$usersite = $this->input->post('usersite');
				$subject = $this->input->post('subject');
				$message = $this->input->post('message');
				
                $user_rand_id = $this->functions->get_user_rand_id();
				$data_to_store = array(
					'user_rand_id' => $user_rand_id,
                   	'username' => $this->input->post('username'),
					'usermail' => $this->input->post('usermail'),
					'usersite' => $this->input->post('usersite'),
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message')
					//'password' => md5($pass),
					//'primary_email' => $email,
					//'type_of_membership' => 'FREE',
					//'date_of_registration' => date("Y-m-d H:i:s"),
					//'status' => 'Inactive'
			    );
				
				//captcha validation
				
				//print_r($array); die;
			  
			  
			   $this->load->helper('email');
    				//load email library
    				$this->load->library('email');
    
    				//read parameters from $_POST using input class
    				 // check is email addrress valid or no
						if (valid_email($usermail)){  
						  // compose email
						  $get_admin_detail = get_admin_detail(); //common helper function for admin detail
						  $this->email->from($usermail); 
						  $this->email->to($get_admin_detail['email']); 
						  $this->email->set_mailtype("html");
						  $this->email->subject('Contact Us Detail');
						  	
							//$mail_data['url'] = site_url().'home/confirm/'.base64url_encode($email);
							$mail_data['username'] = $this->input->post('username');
							$mail_data['usermail'] = $this->input->post('usermail');
							$mail_data['usersite'] = $this->input->post('usersite');
							$mail_data['subject'] = $this->input->post('subject');
							$mail_data['message'] = $this->input->post('message');
							
							$message = $this->load->view('mail_templates/contactus_mail', $mail_data,true); 
							//echo $message; die;
						  	$this->email->message($message);
						  
						  // try send mail ant if not able print debug
						  if ( ! $this->email->send())
						  {
							$msgadd = "<strong>"._clang(EMAIL_NOT_SENT)." </strong>";//.$this->email->print_debugger();  
							 $data['flash_message'] = TRUE;
							$this->session->set_flashdata('flash_class','alert-error');
									$this->session->set_flashdata('flash_message', $msgadd);
								if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('contactus');    
								}
						  }
						  else{
							  if($this->user_model->store_user($data_to_store)){
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-success');
									$this->session->set_flashdata('flash_message', '<strong>'._clang(WELL_DONE).'</strong>'._clang(EMAIL_END).'');
									if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('contactus');    
								}
									 //redirect('kd2a2a0u1g4/user'.'');
								}else {
									$data['flash_message'] = TRUE;
									$this->session->set_flashdata('flash_class','alert-error');
									$this->session->set_flashdata('flash_message', '<strong>'._clang(OH_SNAP).'</strong> '._clang(CHANGE_A_FEW_THINGS_UP).'');
								if($redirect == 'home'){
								redirect('home');    	
								}else{
								redirect('contactus');    
								}
									
									}
							  
							  }
			  
			  }else {
					if($redirect == 'home'){
						$this->session->set_flashdata('validation_error_messages',validation_errors());
						redirect('home');
					}
				}
			  
			  
				//redirect('contactus');
                //redirect('kd2a2a0u1g4/keyword/update/'.$id.'');

            }else{
				if(!$this->recaptcha->getIsValid()) {
				
                            $this->session->set_flashdata('flash_message',''._clang(INCORRECT_CAPTCHA).'');
							$this->session->set_flashdata('flash_class', 'alert-error');
                        } else {
                            $this->session->set_flashdata('flash_message',''._clang(INCORRECT_CREDENTIALS).'');
							$this->session->set_flashdata('flash_class', 'alert-error');
                        }
		
				$this->session->set_flashdata('validation_error_messages',validation_errors());
				redirect('contactus');
				
				}//captcha validation over
				
				//echo $data_to_store['usermail']; die;
                //if the insert has returned true then we show the flash message
             
					
					

            
		
		$data['main_content'] = 'contactus_view';
		
		
		$this->load->view('includes/template', $data); 
	}
}
?>