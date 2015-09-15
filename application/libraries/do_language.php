<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Do_language {
	
	var $CI;		
	
	public function __construct() {
	
	$this->CI =& get_instance();
	$this->CI->load->model('site_language_model');
	$this->CI->load->model('user_model');
	$this->CI->load->model('language_keyword_model');
	$this->set_language();
}
	function set_language(){
		//$CI =& get_instance();
		global $language_array;
		if(!$this->CI->session->userdata('language_shortcode'))
		{
			if(!$this->CI->session->userdata('is_logged_in')){
				$get_lang = 'en';
			}else{
				$get_lang_a = $this->CI->user_model->get_user_by_id($this->session->userdata('user_id'));
				$get_lang1 = $get_lang_a[0]['language_shortcode'];
				$get_lang = !empty($get_lang1) ? $get_lang1 : 'en';
				//$get_lang = $get_lang_a[0]['language_interface'];
				
			}
			$data = array(
				'language_shortcode' => $get_lang,
				);
				$this->CI->session->set_userdata($data);
			
		}
			//echo 'function-><pre>'; print_r($this->CI->session->userdata);
			
			$session_language_shortcode = $this->CI->session->userdata('language_shortcode');
			$get_lang_data = $this->CI->language_keyword_model->get_language_keyword('', '', '', '','','');
			//echo '<pre>'; print_r($get_lang_data);
			for($i=0;$i<count($get_lang_data);$i++){
			if(empty($get_lang_data[$i][$session_language_shortcode])){
				$session_lang_short = $get_lang_data[$i]["en"];
			}else{
				$session_lang_short = $get_lang_data[$i][$session_language_shortcode];
			}
				$language_array[] = array("define"=> stripslashes($get_lang_data[$i]["language_define"]), "lang" => stripslashes($session_lang_short));
				if(!defined(stripslashes($get_lang_data[$i]["language_define"])))
					define(stripslashes($get_lang_data[$i]["language_define"]),stripslashes($session_lang_short));
				
	}
	//echo '<pre>'; print_r($language_array);
	//echo '</pre>';
	//die;
		}
	
	}