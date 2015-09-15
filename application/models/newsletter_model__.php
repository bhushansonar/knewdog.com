<?php
class Newsletter_model extends CI_Model {
 
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
    public function get_newsletter_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('newsletter');
		$this->db->where('newsletter_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch Newsletter data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
	
	 public function get_newsletter_by_field($filed,$value)
    {
		$this->db->select('*');
		$this->db->from('newsletter');
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
	public function addQuotes($string)
	{
		$data = explode(',',$string);
		echo print_r($data);
		$d = array();
		for($i=0;$i<count($data);$i++){
			$d[] = '"'.$data[$i].'"';
			}
		//	echo print_r($d);
		$e = implode(',',$d);
		return trim($e);
	}
	/*public function get_keyword_name($ids){
		$id = $this->addQuotes($ids);
		$query = $this->db->query('select * from newsletter_keyword where newsletter_keyword_id IN ('.$id.')');
		//$this->db->from('newsletter_keyword');
		//$this->db->where_in('newsletter_keyword_id', $id);
		//$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result_array(); 	
		}*/
	public function get_keyword_ids($string){
		//$id = $this->addQuotes($string);
		//$query = $this->db->query('select * from newsletter_keyword where en  LIKE ('.$id.')');
		$this->db->select('en');
		$this->db->from('newsletter_keyword');
		$this->db->like('en', $string);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result_array(); 	
		
		}
    public function get_newsletter($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus = null,$where_field= array(),$where_value = array())
    {
	    
		$this->db->select('*');
		$this->db->from('newsletter');
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
	
	 public function get_newsletter_front($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus = null,$where_field= array(),$where_value = array(),$search_language=null,$search_category=null,$search_rating=null,$search_location=null,$search_zip_city=null)
	 //,$language_id,$newsletter_category_id,$rating_id,$author_country,$author_zipcode
    {
		//$d = 'keyword';
	   	
	   //echo '<pre>';print_r($da); die;
	   if($search_string){
	  	 $da = $this->get_keyword_ids($search_string);
	   }
		$this->db->select('*');
		$this->db->from('newsletter');
		
		//$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter`.`newsletter_category_id`) > 0", 'left');
		//$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter`.`newsletter_keyword_id`) > 0", 'left');
		//$this->db->join('newsletter_category', 'newsletter.newsletter_category_id = newsletter_category.newsletter_category_id', 'left');
		//$this->db->join('manufacturers', 'products.language_id = manufacturers.id', 'left');
		//$this->db->order_by('status', 'Active');
		if($wherestatus != null){
			$this->db->where('newsletter.status', $wherestatus);
        }
		if(count($where_field) > 0 && count($where_value) > 0){
				for($i=0; $i<count($where_field);$i++){
					$this->db->where($where_field[$i], $where_value[$i]);
				}
			}
		//search start
		if($search_string){
			$this->db->like('newsletter_name', $search_string);
			$this->db->or_like('author_name', $search_string);
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_string);
			for($i=0;$i<count($da);$i++){
				$ar[] = $da[$i]['en'];
				}
			$ex = implode(",",$ar);
			$sr = $this->addQuotes($ex);
			$this->db->where_in('newsletter_keyword_id',$sr);
			
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id))', $search_string);
			
			//$this->db->or_like($order, $search_string);
		}
		if($search_language){
			//$this->db->or_like('language_id',$search_language);
			$this->db->where('newsletter.language_id', $search_language);
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
			$this->db->where('newsletter.author_country', $search_location);
			}
		if($search_zip_city){
			//$this->db->like('author_zipcode', $search_zip_city);
			$this->db->where('newsletter.author_zipcode', $search_zip_city);
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
		echo $this->db->last_query();
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_newsletter($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('newsletter');
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
	
	function count_newsletter_front($search_string=null, $order=null,$search_language=null,$search_category=null,$search_rating=null,$search_location=null,$search_zip_city=null)
    {
		/*$this->db->select('*');
		$this->db->from('newsletter');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like('newsletter_name', $search_string);
			$this->db->or_like('newsletter_name', $search_string);
			$this->db->or_like('newsletter_name', $search_string);
			$this->db->or_like('newsletter_name', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('newsletter_id', 'Asc');
		}
		$query = $this->db->get();*/
		
		$this->db->select('*,GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en) as g_en, GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id) as g_keyword_name');
		$this->db->from('newsletter');
		$this->db->join('newsletter_category', "FIND_IN_SET(newsletter_category.newsletter_category_id , `newsletter`.`newsletter_category_id`) > 0", 'left');
		$this->db->join('newsletter_keyword', "FIND_IN_SET(newsletter_keyword.newsletter_keyword_id , `newsletter`.`newsletter_keyword_id`) > 0", 'left');
		//$this->db->join('newsletter_category', 'newsletter.newsletter_category_id = newsletter_category.newsletter_category_id', 'left');
		//$this->db->join('manufacturers', 'products.language_id = manufacturers.id', 'left');
		//$this->db->order_by('status', 'Active');
		
		
		//search start
		if($search_string){
			$this->db->like('newsletter_name', $search_string);
			$this->db->or_like('author_name', $search_string);
			//$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_category.en ORDER BY newsletter_category.en))', $search_string);
			$this->db->or_like('(select GROUP_CONCAT(DISTINCT newsletter_keyword.en ORDER BY newsletter_keyword.newsletter_keyword_id))', $search_string);
			
			//$this->db->or_like($order, $search_string);
		}
		if($search_language){
			//$this->db->or_like('language_id',$search_language);
			$this->db->where('newsletter.language_id', $search_language);
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
			$this->db->where('newsletter.author_country', $search_location);
			}
		if($search_zip_city){
			//$this->db->like('author_zipcode', $search_zip_city);
			$this->db->where('newsletter.author_zipcode', $search_zip_city);
			}
		//search end
		$this->db->group_by('newsletter_id');

		if($order){
			$this->db->order_by($order, 'DESC');
		}else{
		    $this->db->order_by('newsletter_id', 'ASC');
		}
		
		
		$query = $this->db->get();
		
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_newsletter($data)
    {
		$insert = $this->db->insert('newsletter', $data);
	    return $insert;
	}

    /**
    * Update category
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_newsletter($id, $data)
    {
		$this->db->where('newsletter_id', $id);
		$this->db->update('newsletter', $data);
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
    * Delete Newsletter
    * @param int $id - category id
    * @return boolean
    */
	function delete_newsletter($id){
		$this->db->where('newsletter_id', $id);
		$this->db->delete('newsletter');
		//$this->db->flush_cache();
	}
	
	/**
    * Delete Newsletter
    * @param int $id - category id
    * @return boolean
    */
	function delete_newsletter_by_field($field,$value){
		$this->db->where($field, $value);
		$this->db->delete('newsletter');
		//$this->db->flush_cache();
	}
	
 
}
?>