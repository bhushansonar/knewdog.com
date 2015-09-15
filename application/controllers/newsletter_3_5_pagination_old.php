<?php
class Newsletter extends CI_Controller {
    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'newsletter';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
	
    public function __construct()
    {
        parent::__construct();
        
		$this->load->model('newsletter_model');
		$this->load->model('newsletter_category_model');
		$this->load->model('newsletter_keyword_model');
		$this->load->model('newsletter_language_model');
		$this->load->model('user_model');
		$this->load->model('subscribe_model');
		$this->load->helper('url');
        if(!$this->session->userdata('is_logged_in')){
            //redirect('kd2a2a0u1g4/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
		$user_id = $this->session->userdata('user_id');
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order');
		$mynewsletter = $this->input->post('mynewsletter');
		$language_id = $this->input->post('language_id');
		$newsletter_category = $this->input->post('newsletter_category');
		$rating_id = $this->input->post('rating_id');
		$author_country = $this->input->post('author_country');
		$author_zipcode = $this->input->post('author_zipcode');
		
		//my newsletter ******************************************************************
		/*$mynl_search_string = $this->input->post('mynl_search_string');        
        $mynl_order = $this->input->post('mynl_order');
		$mynl_mynewsletter = $this->input->post('mynl_mynewsletter');
		$mynl_language_id = $this->input->post('mynl_language_id');
		$mynl_newsletter_category = $this->input->post('mynl_newsletter_category');
		$mynl_rating_id = $this->input->post('mynl_rating_id');
		$mynl_author_country = $this->input->post('mynl_author_country');
		$mynl_author_zipcode = $this->input->post('mynl_author_zipcode');*/
		
		if($order == 'newsletter_id'){
			$order_type = 'DESC';
		}else{
			$order_type = 'ASC';
		}
		
		/*if($mynl_order == 'newsletter_id'){
			$mynl_order_type = 'DESC';
		}else{
			$mynl_order_type = 'ASC';
		}*/
        //$order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 2;
		$config["uri_segment"] = 2;
        $config['base_url'] = base_url().'newsletter';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
		$page = ($this->uri->segment(2,0)) ? $this->uri->segment(2,0) : 0;
		
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
            //if($this->session->userdata('order_type')){
              //  $order_type = $this->session->userdata('order_type');    
            //}else{
                //if we have nothing inside session, so it's the default "Asc"
              //  $order_type = 'DESC';    
           // }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;  
		
		//My Newsletter ********************************************
		//pagination settings
		/*$mynl_config = array();
        $mynl_config['per_page'] = 1;
		$mynl_config["uri_segment"] = 3;
        $mynl_config['base_url'] = base_url().'newsletter'.'/'.$this->uri->segment(2,0);;
        $mynl_config['use_page_numbers'] = TRUE;
        $mynl_config['num_links'] = 20;
        $mynl_config['full_tag_open'] = '<ul>';
        $mynl_config['full_tag_close'] = '</ul>';
        $mynl_config['num_tag_open'] = '<li>';
        $mynl_config['num_tag_close'] = '</li>';
        $mynl_config['cur_tag_open'] = '<li class="active"><a>';
        $mynl_config['cur_tag_close'] = '</a></li>';
		$mynl_page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        //limit end
      	//$mynl_page = $this->uri->segment(2);
	//	echo "<br>";
        //math to get the initial record to be select in the database
        $mynl_limit_end = ($mynl_page * $mynl_config['per_page']) - $mynl_config['per_page'];
        if ($mynl_limit_end < 0){
            $mynl_limit_end = 0;
        } 
		
        //if order type was changed
        if($mynl_order_type){
            $mynl_filter_session_data['mynl_order_type'] = $mynl_order_type;
        }
        else{
            //we have something stored in the session? 
            //if($this->session->userdata('order_type')){
              //  $order_type = $this->session->userdata('order_type');    
            //}else{
                //if we have nothing inside session, so it's the default "Asc"
              //  $order_type = 'DESC';    
           // }
        }
        //make the data type var avaible to our view
        $data['mynl_order_type_selected'] = $mynl_order_type; */ 
		
		$sub_wherefield = array('s_user_id');
		$sub_wherevalue = array($user_id);
		$subscribe_by_user_id = $this->subscribe_model->get_subscribe('', '', '', '', '',$sub_wherefield,$sub_wherevalue);
		
		$subscribe_newsletter_ids = array();
		for($s=0;$s<count($subscribe_by_user_id);$s++){
			$subscribe_newsletter_ids[] = $subscribe_by_user_id[$s]['s_newsletter_id'];
			}
		//echo '<pre>';print_r($subscribe_newsletter_ids);
		//echo $subscribe_newsletter_id = implode(",",$subscribe_newsletter_ids);die;
		/*$mynl_where_field = array();
		$mynl_where_value = array();
		$mynl_where_in_field = array('newsletter_id');
		$mynl_where_in_value = array($subscribe_newsletter_ids);*/
		/**********************************************************/
		$where_field = array();
		$where_value = array();
		
        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
        if($search_string !== false && $order !== false || $this->uri->segment(2) == true){ 
           
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
			$data['selected_language_id'] = $language_id;
			$data['selected_newsletter_category'] = $newsletter_category;
			$data['selected_newsletter_category_id'] = $rating_id;
			$data['selected_author_country'] = $author_country;
			$data['selected_author_zipcode'] = $author_zipcode;
            
			//save session data into the session
            if(isset($filter_session_data)){
              $this->session->set_userdata($filter_session_data);    
            }
            
            //fetch sql data into arrays
            $data['count_products']= $this->newsletter_model->count_newsletter_front($search_string, $order,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode);
          $config['total_rows'] = $data['count_products'];
			;
            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['newsletter'] = $this->newsletter_model->get_newsletter_front($search_string, $order, $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode);        
                }else{
                    $data['newsletter'] = $this->newsletter_model->get_newsletter_front($search_string, '', $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode);           
                }
            }else{
                if($order){
                    $data['newsletter'] = $this->newsletter_model->get_newsletter_front('', $order, $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode);        
                }else{
                    $data['newsletter'] = $this->newsletter_model->get_newsletter_front('', '', $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode);        
                }
            }
        }else{

            //clean filter data inside section
            $filter_session_data['newsletter_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
			//$filter_session_data['selected_language_id'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';
			$data['selected_language_id'] = null;
			$data['selected_newsletter_category'] = null;
			$data['selected_author_country'] = null;
			$data['order'] = null;
			$data['selected_language_id'] = null;
			$data['selected_newsletter_category_id'] = null;
			$data['selected_newsletter_category_id'] = null;
			$data['selected_author_country'] = null;
			$data['selected_author_zipcode'] = null;
			
            //fetch sql data into arrays
            $data['count_newsletter']= $this->newsletter_model->count_newsletter_front();
            @$data['newsletter'] = $this->newsletter_model->get_newsletter_front('', '', $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category_id,$rating_id,$author_country,$author_zipcode);        
            $config['total_rows'] = $data['count_newsletter'];

        }//!isset($search_string) && !isset($order)
		//MY newsletter ******************************************************************
		/*if($mynl_search_string !== false && $mynl_order !== false || $this->uri->segment(2) == true){ 
           
            
            if($mynl_search_string){
                $mynl_filter_session_data['mynl_search_string_selected'] = $mynl_search_string;
            }else{
                $mynl_search_string = $this->session->userdata('mynl_search_string_selected');
            }
            $data['mynl_search_string_selected'] = $mynl_search_string;

            if($mynl_order){
                $mynl_filter_session_data['mynl_order'] = $mynl_order;
            }
            else{
                $mynl_order = $this->session->userdata('mynl_order');
            }
			
            $data['mynl_order'] = $mynl_order;
			$data['mynl_selected_language_id'] = $mynl_language_id;
			$data['mynl_selected_newsletter_category'] = $mynl_newsletter_category;
			$data['mynl_selected_newsletter_category_id'] = $mynl_rating_id;
			$data['mynl_selected_author_country'] = $mynl_author_country;
			$data['mynl_selected_author_zipcode'] = $mynl_author_zipcode;
            
			//save session data into the session
            if(isset($mynl_filter_session_data)){
              $this->session->set_userdata($mynl_filter_session_data);    
            }
            
            //fetch sql data into arrays
            $data['mynl_count_products']= $this->newsletter_model->count_newsletter_front($mynl_search_string, $mynl_order,$mynl_language_id,$mynl_newsletter_category,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);
          $config['total_rows'] = $data['mynl_count_products'];
			;
            //fetch sql data into arrays
            if($mynl_search_string){
                if($mynl_order){
                    $data['mynl_newsletter'] = $this->newsletter_model->get_newsletter_front($mynl_search_string, $mynl_order, $mynl_order_type, $mynl_config['mynl_per_page'],$mynl_limit_end,'Active',$mynl_where_field,$mynl_where_value,$mynl_language_id,$mynl_newsletter_category,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);        
                }else{
                    $data['mynl_newsletter'] = $this->newsletter_model->get_newsletter_front($mynl_search_string, '', $mynl_order_type, $mynl_config['mynl_per_page'],$mynl_limit_end,'Active',$mynl_where_field,$mynl_where_value,$mynl_language_id,$mynl_newsletter_category,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);           
                }
            }else{
                if($mynl_order){
                    $data['mynl_newsletter'] = $this->newsletter_model->get_newsletter_front('', $mynl_order, $mynl_order_type, $mynl_config['mynl_per_page'],$mynl_limit_end,'Active',$mynl_where_field,$mynl_where_value,$mynl_language_id,$mynl_newsletter_category,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);        
                }else{
                    $data['mynl_newsletter'] = $this->newsletter_model->get_newsletter_front('', '', $mynl_order_type, $mynl_config['mynl_per_page'],$mynl_limit_end,'Active',$mynl_where_field,$mynl_where_value,$mynl_language_id,$mynl_newsletter_category,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);        
                }
            }
        }else{

            //clean filter data inside section
            $mynl_filter_session_data['mynl_newsletter_selected'] = null;
            $mynl_filter_session_data['mynl_search_string_selected'] = null;
            $mynl_filter_session_data['mynl_order'] = null;
            $mynl_filter_session_data['mynl_order_type'] = null;
			//$filter_session_data['selected_language_id'] = null;
            $this->session->set_userdata($mynl_filter_session_data);

            //pre selected options
            $data['mynl_search_string_selected'] = '';
            $data['mynl_order'] = 'id';
			$data['mynl_selected_language_id'] = null;
			$data['mynl_selected_newsletter_category'] = null;
			$data['mynl_selected_author_country'] = null;
			$data['mynl_order'] = null;
			$data['mynl_selected_language_id'] = null;
			$data['mynl_selected_newsletter_category_id'] = null;
			$data['mynl_selected_newsletter_category_id'] = null;
			$data['mynl_selected_author_country'] = null;
			$data['mynl_selected_author_zipcode'] = null;
			
            //fetch sql data into arrays
            $data['mynl_count_newsletter']= $this->newsletter_model->count_newsletter_front('', '','','','','','',$mynl_where_in_field,$mynl_where_in_value);
            @$data['mynl_newsletter'] = $this->newsletter_model->get_newsletter_front('', '', $mynl_order_type, $mynl_config['mynl_per_page'],$mynl_limit_end,'Active',$mynl_where_field,$mynl_where_value,$mynl_language_id,$mynl_newsletter_category_id,$mynl_rating_id,$mynl_author_country,$mynl_author_zipcode,$mynl_where_in_field,$mynl_where_in_value);        
            $mynl_config['total_rows'] = $data['mynl_count_newsletter'];
			//echo '<pre>';print_r($data['mynl_newsletter']); die;
        }//!isset($search_string) && !isset($order)
         */
        //initializate the panination helper
		//echo "limit_start->".$config['per_page']; 
		//echo '<pre>';print_r($config);
		//echo '<pre>'; print_r($config);
		$this->pagination->initialize($config); 
        $data['link'] = $this->pagination->create_links();
		//echo "link->".$data['link'];
		
		//echo '<pre>'; print_r($mynl_config);
		/*$this->pagination->initialize($mynl_config); 
		$data['mynl_link'] = $this->pagination->create_links();*/
		//echo "mylink->".$data['mynl_link'];
		//$data['link'] = $this->pagination->create_links();  
		//echo print_r($data['link']); die;
        //load the view
		// $data['category'] = $this->newsletter_category_model->get_category('', 'category_id', 'ASC', '','');
		//$data['flash_message'] = FALSE;
		//$this->session->set_userdata('flash_message', 'add');
		//echo '<pre>';print_r($data['newsletter']); die;
		$data['total_rows'] = $config['total_rows'];
		$data['limit_end'] = $limit_end;
		$data['limit_start'] = $config['per_page'];
		$data['page'] = $page;
		//my newsletter **************************************
		/*$data['mynl_total_rows'] = $mynl_config['total_rows'];
		$data['mynl_limit_end'] = $mynl_limit_end;
		$data['mynl_limit_start'] = $mynl_config['per_page'];
		$data['mynl_page'] = $mynl_page;*/
		
		$data['category'] = $this->newsletter_category_model->get_category('', '', 'ASC', '','','Active'); 
		//$data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '','','Active');
		$data['language'] = $this->newsletter_language_model->get_language('', '', 'ASC', '','','Active'); 
		$data['countries'] = $this->user_model->get_countries('country_name','ASC');
        $data['main_content'] = 'newsletter_view';
        $this->load->view('includes/template', $data);  

    }//index
	
	function specific(){
		$id = $this->uri->segment(4);
		$get_rate = $this->newsletter_model->get_rate_by_user($id);
		$data['get_rate'] = $get_rate;
		$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id_front($id);
		//$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id_front($id);
		//$wherefield = array("join_newsletter_id");
		//$wherevalue = array($id);
		$data['newsletter_review'] = $this->newsletter_model->get_newsletter_review('', '', 'DESC', '2','0','',array(),array());
		$data['main_content'] = 'newsletter_specific_view';
        $this->load->view('includes/template', $data);  
		}
	
	//Ajax call for Rate
	function rateit(){/*
		$action = $this->input->post('action');
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$ip = $_SERVER["REMOTE_ADDR"];
    	$therate = $value;
    	$thepost = $id;
		
		$user_id = $this->session->userdata("user_id");
		$wherefield =array("join_newsletter_id","join_user_id");
		$wherevalue = array($thepost,$user_id);
		$get_rate = $this->newsletter_model->get_rate_by_field($wherefield,$wherevalue);
	
    	if(@count($get_rate) == 0 ){
			$data = array(
					"join_newsletter_id" => $thepost,
					"ip" => $ip,
					"rate" => $therate,
					"user_id" => $user_id,
			);
			$get_rate = $this->newsletter_model->store_newsletter_rate($data);
    		//mysql_query("INSERT INTO wcd_rate (id_post, ip, rate)VALUES('$thepost', '$ip', '$therate')");
    	}else{
			$data = array(
					"rate" => $therate
			);
			$wherefield =array("ip","join_newsletter_id");
			$wherevalue = array($ip,$thepost);
			$get_rate = $this->newsletter_model->update_newsletter_rate($ip,$data,$wherefield,$wherevalue);
    		//mysql_query("UPDATE wcd_rate SET rate= '$therate' WHERE ip = '$ip'");
    	}
	
		
		*/}
	
	function display_rate(){
			$id = $this->uri->segment(3);
			$user_id = $this->session->userdata("user_id");
			//Pagination			
			$config['per_page'] = 10;
			$config["uri_segment"] = 4;
			$config['base_url'] = base_url().'newsletter/display-rate/'.$id;
			$config['use_page_numbers'] = TRUE;
			$config['num_links'] = 20;
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			
			$page = $this->uri->segment(4);
        //math to get the initial record to be select in the database
			$limit_end = ($page * $config['per_page']) - $config['per_page'];
			if ($limit_end < 0){
				$limit_end = 0;
			} 
			$wherefield = array("join_newsletter_id");
			$wherevalue = array($id);
			
			$data['count_products']= $this->newsletter_model->count_newsletter_review('','',$wherefield,$wherevalue);
          	$config['total_rows'] = $data['count_products'];
			//Pagination END
			 $this->pagination->initialize($config); 
			$get_rate = $this->newsletter_model->get_rate_by_user($id);
			$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id_front($id);
			$data['newsletter_review'] = $this->newsletter_model->get_newsletter_review('', '', 'DESC', $config['per_page'],$limit_end,'',$wherefield,$wherevalue);
			$data['get_rate'] = $get_rate;
			
			$data['main_content'] = 'add_rating_views';
        	$this->load->view('includes/template', $data);  
			
			}
	function addreview(){
		$title = $this->input->post('title');
		$message = $this->input->post('message');
		$id = $this->input->post('join_newsletter_id');
		$this->form_validation->set_rules('rate', 'Rate', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
		
	 	 if ($this->form_validation->run())
            {
				$ip = $_SERVER["REMOTE_ADDR"];
                $data_to_store = array(
                    'join_user_id' => $this->input->post('join_user_id'),
					'join_newsletter_id' => $this->input->post('join_newsletter_id'),
					"ip" => $ip,
					"rate" => $this->input->post('rate'),
					'title' => $this->input->post('title'),
					'message' => $this->input->post('message'),
					'status' => $this->input->post('Inactive'),
                );
                //if the insert has returned true then we show the flash message
                if($this->newsletter_model->store_newsletter_review($data_to_store)){
					$this->session->set_flashdata('flash_class','alert-success');
					$this->session->set_flashdata('flash_message', '<strong>Well done!</strong> Your review added with Success.');
					//echo "if";die;
					redirect("newsletter/display-rate/".$id);
			    }else{
					$this->session->set_flashdata('flash_class','alert-error');
					$this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
					//echo "els"; die;
					redirect("newsletter/display-rate/".$id);
                }

            }else{
				//$this->display_rate();
				/*$id = $id;
			$user_id = $this->session->userdata("user_id");
			$get_rate = $this->newsletter_model->get_rate_by_user($id);
			$data['newsletter'] = $this->newsletter_model->get_newsletter_by_id_front($id);
			$wherefield = array("join_user_id","join_newsletter_id");
			$wherevalue = array($user_id,$id);
			$data['newsletter_review'] = $this->newsletter_model->get_newsletter_review('', '', 'DESC', '', '','',$wherefield,$wherevalue);
			$data['get_rate'] = $get_rate;
			
			$data['main_content'] = 'add_rating_views';
        	$this->load->view('includes/template', $data); */ 
			//echo "hii";
			 $this->session->set_flashdata('form_errors', validation_errors());
   			redirect("newsletter/display-rate/".$id);
				}
			
		/*$data['site_language'] = $this->site_language_model->get_language('', '','', '', '','Active');
        $data['main_content'] = 'kd2a2a0u1g4/newsletter_keyword/add';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);  */
		}
	function do_upload($filename) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($filename)) {
            $response = array('error' => $this->upload->display_errors());
            //$this->load->view('upload_form', $error);
        } else {
            $response = array('upload_data' => $this->upload->data());
            //$this->load->view('upload_success', $data);
        }

        return $response;
    }
	
	function validate_category($str)
	{
	   $array_value = $str; //this is redundant, but it's to show you how
	   //the content of the fields gets automatically passed to the method
		//print_r($str);
		if(count($array_value) <= 3){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function validate_keyword($str)
	{
	   $array_value = $str; //this is redundant, but it's to show you how
	   //the content of the fields gets automatically passed to the method
		//print_r($str);
		if(count($array_value) <= 20){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	

}