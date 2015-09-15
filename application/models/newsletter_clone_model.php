<?php
class newsletter_clone_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
		$this->load->library('upload');
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_newsletter_clone_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('newsletter_clone');
		$this->db->where('newsletter_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }  
	
	public function get_newsletter_clone_by_id_front($id)
    {
		$this->db->select('*,GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en) as g_en, GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id) as g_keyword_name');
		$this->db->from('newsletter_clone');
		$this->db->join('countries','countries.id = newsletter_clone.author_country','left');
		$this->db->join('language','language.language_id = newsletter_clone.language_id','left');
		$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter_clone`.`newsletter_category_id`) > 0", 'left');
		$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter_clone`.`newsletter_keyword_id`) > 0", 'left');
		$this->db->where('newsletter_id', $id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array(); 
    }    

    /**
    * Fetch newsletter_clone_clone data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
	
	 public function get_newsletter_clone_by_field($filed,$value)
    {
		$this->db->select('*');
		$this->db->from('newsletter_clone');
		$this->db->where($filed, $value);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	/**
    * Fetch category data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
	
    public function get_newsletter_clone($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus = null,$where_field= array(),$where_value = array())
    {
	    
		$this->db->select('*');
		$this->db->from('newsletter_clone');
		//$this->db->order_by('status', 'Active');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		if(count($where_field) > 0 && count($where_value) > 0){
				for($i=0; $i<count($where_field);$i++){
					$this->db->where($where_field[$i], $where_value[$i]);
				}
			}
		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('newsletter_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('newsletter_id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		
		
		$query = $this->db->get();
		return $query->result_array(); 	
    }
	
	 public function get_newsletter_clone_front($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus = null,$where_field= array(),$where_value = array(),$search_language=null,$search_category=null,$search_rating=null,$search_location=null,$search_zip_city=null,$where_in_field = array(),$where_in_value = array())
	 //,$language_id,$newsletter_category_id,$rating_id,$author_country,$author_zipcode
    {
	    
		$this->db->select('*,GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en) as g_en, GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id) as g_keyword_name, language.language_longform as newsletter_clone_language, ');
		$this->db->from('newsletter_clone');
		$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter_clone`.`newsletter_category_id`) > 0", 'left');
		$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter_clone`.`newsletter_keyword_id`) > 0", 'left');
		$this->db->join("newsletter_clone_rate", "newsletter_clone_rate.join_newsletter_id = newsletter_clone.newsletter_id", "left");
		$this->db->join("language", "language.language_id = newsletter_clone.language_id", "left");
		
		//$this->db->join('newsletter_category', 'newsletter_clone.newsletter_category_id = newsletter_category.newsletter_category_id', 'left');
		//$this->db->join('manufacturers', 'products.language_id = manufacturers.id', 'left');
		//$this->db->order_by('status', 'Active');
		if($wherestatus != null){
			$this->db->where('newsletter_clone.status', $wherestatus);
        }
		if(count($where_field) > 0 && count($where_value) > 0){
				for($i=0; $i<count($where_field);$i++){
					$this->db->where($where_field[$i], $where_value[$i]);
				}
			}
		if(count($where_in_field) > 0 && count($where_in_value) > 0){
				for($i=0; $i<count($where_in_field);$i++){
					$this->db->where_in($where_in_field[$i], $where_in_value[$i]);
				}
			}
		//search start
		if($search_string){
			$this->db->where("(newsletter_clone_name like '%$search_string%'");
			$this->db->or_where("author_name LIKE '%$search_string%'");
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_string);
			$this->db->or_where("(select GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id)) LIKE '%$search_string%' )");
			
			//$this->db->or_like($order, $search_string);
		}
		if($search_language){
			//$this->db->or_like('language_id',$search_language);
			$this->db->where('newsletter_clone.language_id', $search_language);
			}
		if($search_rating){
			//select newsletter_id,ROUND(ratings) as roundedratings  from newsletter_clone where (select ROUND(ratings) as roundedratings) = 3
			$this->db->where("(select ROUND(newsletter_clone.ratings) as roundedratings) =", $search_rating);
		//	$this->db->or_like('language_id', $search_rating);
			
			}
		if($search_category){
			$this->db->like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_category);
			//$this->db->where('GROUP_CONCAT(newsletter_category.en ORDER BY newsletter_category.en)', $search_category);
			}
		if($search_location){
			//$this->db->like('language_id', $search_location);
			$this->db->where('newsletter_clone.author_country', $search_location);
			}
		if($search_zip_city){
			//$this->db->like('author_zipcode', $search_zip_city);
			$this->db->where('newsletter_clone.author_zipcode', $search_zip_city);
			}
			//search end
		
		$this->db->group_by('newsletter_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('newsletter_id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array(); 	
    }
	


    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_newsletter_clone($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('newsletter_clone');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('newsletter_id', 'Asc');
		}
		$query = $this->db->get();
		
		return $query->num_rows();        
    }
	
	function count_newsletter_clone_front($search_string=null, $order=null,$search_language=null,$search_category=null,$search_rating=null,$search_location=null,$search_zip_city=null,$where_in_field = array(),$where_in_value = array())
    {
		//$search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus = null,$where_field= array(),$where_value = array(),$search_language=null,$search_category=null,$search_rating=null,$search_location=null,$search_zip_city=null,$where_in_field = array(),$where_in_value = array()
		/*$this->db->select('*');
		$this->db->from('newsletter_clone');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like('newsletter_clone_name', $search_string);
			$this->db->or_like('newsletter_clone_name', $search_string);
			$this->db->or_like('newsletter_clone_name', $search_string);
			$this->db->or_like('newsletter_clone_name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('newsletter_id', 'Asc');
		}
		$query = $this->db->get();*/
		
		$this->db->select('*,GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en) as g_en, GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id) as g_keyword_name, language.language_longform as newsletter_clone_language');
		$this->db->from('newsletter_clone');
		$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter_clone`.`newsletter_category_id`) > 0", 'left');
		$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter_clone`.`newsletter_keyword_id`) > 0", 'left');
		$this->db->join("newsletter_clone_rate", "newsletter_clone_rate.join_newsletter_id = newsletter_clone.newsletter_id", "left");
		$this->db->join("language", "language.language_id = newsletter_clone.language_id", "left");
		//$this->db->join('newsletter_category', 'newsletter_clone.newsletter_category_id = newsletter_category.newsletter_category_id', 'left');
		//$this->db->join('manufacturers', 'products.language_id = manufacturers.id', 'left');
		//$this->db->order_by('status', 'Active');
		
		
		//search start
		if($search_string){
			/*$this->db->like('newsletter_clone_name', $search_string);
			$this->db->or_like('author_name', $search_string);
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_string);
			$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id))', $search_string);*/
			$this->db->where("(newsletter_clone_name like '%$search_string%'");
			$this->db->or_where("author_name LIKE '%$search_string%'");
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_string);
			$this->db->or_where("(select GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id)) LIKE '%$search_string%' )");
			
			//$this->db->or_like($order, $search_string);
		}
		if($search_language){
			//$this->db->or_like('language_id',$search_language);
			$this->db->where('newsletter_clone.language_id', $search_language);
			}
		if($search_rating){
			//$this->db->or_like('language_id', $search_rating);
			
			}
		if($search_category){
			$this->db->like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_category);
			//$this->db->where('GROUP_CONCAT(newsletter_category.en ORDER BY newsletter_category.en)', $search_category);
			}
		if($search_location){
			//$this->db->like('language_id', $search_location);
			$this->db->where('newsletter_clone.author_country', $search_location);
			}
		if($search_zip_city){
			//$this->db->like('author_zipcode', $search_zip_city);
			$this->db->where('newsletter_clone.author_zipcode', $search_zip_city);
			}
		if(count($where_in_field) > 0 && count($where_in_value) > 0){
				for($i=0; $i<count($where_in_field);$i++){
					$this->db->where_in($where_in_field[$i], $where_in_value[$i]);
				}
			}
		//search end
		$this->db->group_by('newsletter_id');

		if($order){
			$this->db->order_by($order, 'DESC');
		}else{
		    $this->db->order_by('newsletter_id', 'ASC');
		}
		
		
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->num_rows();        
    }


	public function get_newsletter_clone_interest($order,$order_type = "DESC",$limit_start= null,$limit_end = null,$where_field = array())
	 //,$language_id,$newsletter_category_id,$rating_id,$author_country,$author_zipcode
    {
	    
		$this->db->select('*');
		$this->db->from('newsletter_clone');
		/*$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter_clone`.`newsletter_category_id`) > 0", 'left');
		$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter_clone`.`newsletter_keyword_id`) > 0", 'left');
		$this->db->join("newsletter_clone_rate", "newsletter_clone_rate.join_newsletter_id = newsletter_clone.newsletter_id", "left");
		$this->db->join("language", "language.language_id = newsletter_clone.language_id", "left");*/
		
		//$this->db->join('newsletter_category', 'newsletter_clone.newsletter_category_id = newsletter_category.newsletter_category_id', 'left');
		//$this->db->join('manufacturers', 'products.language_id = manufacturers.id', 'left');
		//$this->db->order_by('status', 'Active');
		$this->db->where("newsletter_clone_relation", "parent");
		//echo '<pre>'; print_r($where_field);die;
		if(count($where_field) > 0){
				for($i=0; $i<count($where_field);$i++){
					 //$this->db->where("FIND_IN_SET('".$where_field[$i]."',`newsletter_clone`.`newsletter_keyword_id`)");
					  //$this->db->where("FIND_IN_SET('2',`newsletter_clone`.`newsletter_keyword_id`)");
					//$this->db->where($where_field[$i], $where_value[$i]);
					if($i==0){
						$this->db->where("FIND_IN_SET('".$where_field[$i]."', `newsletter_clone`.`newsletter_keyword_id`)");
						}else{
						$this->db->or_where("FIND_IN_SET('".$where_field[$i]."', `newsletter_clone`.`newsletter_keyword_id`)");
						}
				}
			}
		
 		
		$this->db->group_by('newsletter_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('newsletter_id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
		
		
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result_array(); 	
    }
	
	
    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_newsletter_clone($data)
    {
		$insert = $this->db->insert('newsletter_clone', $data);
	    return $insert;
	}
	
	/*function store_newsletter_clone_clone($data)
    {
		$insert = $this->db->insert('newsletter_clone_clone', $data);
	    return $insert;
	}
*/
    /**
    * Update category
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_newsletter_clone($id, $data)
    {
		$this->db->where('newsletter_id', $id);
		$this->db->update('newsletter_clone', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete newsletter_clone_clone
    * @param int $id - category id
    * @return boolean
    */
	function delete_newsletter_clone($id){
		$this->db->where('newsletter_id', $id);
		$this->db->delete('newsletter_clone');
		//$this->db->flush_cache();
	}
	
	/**
    * Delete newsletter_clone_clone
    * @param int $id - category id
    * @return boolean
    */
	function delete_newsletter_clone_by_field($field,$value){
		$this->db->where($field, $value);
		$this->db->delete('newsletter_clone');
		//$this->db->flush_cache();
	}
	
	/*
	/
	/* Queries for RATE IT *******************************************************************
	/
	*/
	
	function get_rate_by_field($wherefield=array(),$wherevalue=array()){
		
		$this->db->select('*');
		//$this->db->from('newsletter_clone_rate');
		$this->db->from('newsletter_clone_review');
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);
			}
			}
		//$this->db->where($field, $value);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
			
		}
	function get_rate_by_user($join_newsletter_id){
		//$query = $this->db->query("select * from newsletter_clone_rate where join_newsletter_id = '".$join_newsletter_id."' group by join_user_id");
		//echo $this->db->last_query();
		$query = $this->db->query("select * from newsletter_clone_review where join_newsletter_id = '".$join_newsletter_id."' group by join_user_id");
		
		//die;
		return $query->result_array();
		}	
	
	
	function get_newsletter_clone_rate(){
		$this->db->select('*');
		$this->db->from('newsletter_clone_rate');
		//$this->db->where($field, $value);
		$query = $this->db->get();
		return $query->result_array();
		}
	
	 function store_newsletter_clone_rate($data)
		{
			$insert = $this->db->insert('newsletter_clone_rate', $data);
			return $insert;
		}

    /**
    * Update category
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_newsletter_clone_rate($id, $data,$wherefield=array(),$wherevalue=array())
    {
		//print_r($wherefield);
		//print_r($wherevalue);
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);	
			}
			}
		
		$this->db->update('newsletter_clone_rate', $data);
		//echo $this->db->last_query();
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	/*
	/
	/* Queries for newsletter_clone_clone Review *************************************
	/
	*/
 
 	  public function get_newsletter_clone_review_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('newsletter_clone_review');
		$this->db->where('newsletter_clone_review_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch keyword data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_newsletter_clone_review($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null,$wherefield=array(),$wherevalue=array())
    {
	    
		$this->db->select('newsletter_clone_review.*,newsletter_clone.newsletter_clone_name,user.firstname,user.lastname,user.username,user.username_only,user.privacy_settings');
		$this->db->from('newsletter_clone_review');
		$this->db->join("newsletter_clone", "newsletter_clone.newsletter_id = newsletter_clone_review.join_newsletter_id", "left");
		$this->db->join("user", "user.user_id = newsletter_clone_review.join_user_id", "left");
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);
			}
			}
		//$this->db->order_by('status', 'Active');
		
		/*if($wherelangshotcode != null){
			$this->db->where('language_shortcode', $wherelangshotcode);
        }	*/
		
		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('newsletter_clone_review_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('newsletter_clone_review_id', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_newsletter_clone_review($search_string=null, $order=null,$wherefield=array(),$wherevalue=array())
    {
		$this->db->select('*');
		$this->db->from('newsletter_clone_review');
		$this->db->join("newsletter_clone", "newsletter_clone.newsletter_id = newsletter_clone_review.join_newsletter_id", "left");
		$this->db->join("user", "user.user_id = newsletter_clone_review.join_user_id", "left");
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);
			}
			}
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('newsletter_clone_review_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_newsletter_clone_review($data)
    {
		$insert = $this->db->insert('newsletter_clone_review', $data);
	    return $insert;
	}

    /**
    * Update keyword
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_newsletter_clone_review($id, $data)
    {
		$this->db->where('newsletter_clone_review_id', $id);
		$this->db->update('newsletter_clone_review', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete keywordr
    * @param int $id - keyword id
    * @return boolean
    */
	function delete_newsletter_clone_review($id){
		$this->db->where('newsletter_clone_review_id', $id);
		$this->db->delete('newsletter_clone_review'); 
	}
	
	/*function delete_newsletter_clone_clone($id){
		$this->db->where('newsletter_id', $id);
		$this->db->delete('newsletter_clone_clone'); 
	}
	*/
	function delete_newsletter_clone_review_with_userid($id){
		$this->db->where('join_user_id', $id);
		$this->db->delete('newsletter_clone_review'); 
	}
	
	function insert_one_row_by_id($id){
		
		$this->db->query("INSERT newsletter_clone SELECT * FROM newsletter where newsletter.newsletter_id = '".$id."'");
		return true;
	}
}
?>