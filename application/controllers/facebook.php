<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {

	public function __construct(){
		parent::__construct();

        // To use site_url and redirect on this controller.
        $this->load->helper('url');
	}

	public function login(){

		$this->load->library('facebook'); // Automatically picks appId and secret from config
        // OR
        // You can pass different one like this
        //$this->load->library('facebook', array(
        //    'appId' => 'APP_ID',
        //    'secret' => 'SECRET',
        //    ));

		$user = $this->facebook->getUser();
        echo '<pre>';print_r($user);
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
				$access_token = $this->facebook->getAccessToken();
				$params = array('next' => base_url('welcome/logout/'), 'access_token' => $access_token);
				$data['logout_url'] = $this->facebook->getLogoutUrl($params);
				echo '<pre>'; print_r($data);
            } catch (FacebookApiException $e) {
                $user = null;
            }
        }else {
		
            $this->facebook->destroySession();
        }

        if ($user) {

            //$data['logout_url'] = site_url('welcome/logout'); // Logs off application
            // OR 
            // Logs off FB!
            // $data['logout_url'] = $this->facebook->getLogoutUrl();

        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('welcome/login'), 
                'scope' => array("email") // permissions here
            ));
        }
        $this->load->view('login',$data);

	}

    public function logout(){

        $this->load->library('facebook');

        /*// Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.*/
	//$signed_request_cookie = 'fbsr_' . $this->config->item('appID');
	//setcookie($signed_request_cookie, '', time() - 3600, "/");
	$this->facebook->destroySession();
	$this->session->sess_destroy();  //session destroy
	//redirect('/Welcome/login', 'refresh');  //redirect to the home page

        redirect('welcome/login');
    }

}

