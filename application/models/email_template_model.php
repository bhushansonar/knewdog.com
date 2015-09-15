<?php
class email_template_model extends CI_Model {
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_email_template_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('email_template');
		$this->db->where('email_template_id', $id);
		$query = $this->db->get();
                return $query->result_array(); 
    }    
	
	public function get_email_template_block_name($block_name)
    {
		$this->db->select('*');
		$this->db->from('email_template');
		$this->db->where('block_name', $block_name);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	
	public function get_email_template_by_field($field,$value)
    {
		$this->db->select('*');
		$this->db->from('email_template');
		$this->db->where($field, $value);
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
    public function get_email_template($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null,$where_field = array(),$where_value = array())
    {
	    
		$this->db->select('*');
		$this->db->from('email_template');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		if(count($where_field) > 0 && count($where_value) > 0){
				for($i=0; $i<count($where_field);$i++){
					$this->db->where($where_field[$i], $where_value[$i]);
				}
			}
		//$this->db->order_by('status', 'Active');
		
		/*if($wherelangshotcode != null){
			$this->db->where('language_shortcode', $wherelangshotcode);
        }	*/
		//change for search
		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('email_template_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('email_template_id', $order_type);
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

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_email_template($search_string=null, $order=null,$wherestatus=null,$where_field = array(),$where_value = array())
    {
		$this->db->select('*');
		$this->db->from('email_template');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		if(count($where_field) > 0 && count($where_value) > 0){
				for($i=0; $i<count($where_field);$i++){
					$this->db->where($where_field[$i], $where_value[$i]);
				}
			}
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('email_template_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
//    function store_email_template($data)
//    {
//		$insert = $this->db->insert('email_template', $data);
//	    return $insert;
//	}

    /**
    * Update keyword
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_email_template($id, $data)
    {
		$this->db->where('email_template_id', $id);
		$this->db->update('email_template', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	
 
}
?>