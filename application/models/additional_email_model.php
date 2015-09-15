<?php
class additional_email_model extends CI_Model {
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
    public function get_additional_email_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('additional_email');
		$this->db->where('additional_email_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	
	
	
	public function get_additional_email_by_field($field=array(),$value=array())
    {
		$this->db->select('*');
		$this->db->from('additional_email');
	if(count($field) > 0){
		for($i=0;$i<count($field);$i++){
			$this->db->where($field[$i], $value[$i]);
		}
	}
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
    public function get_additional_email($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null,$where_field = array(),$where_value = array())
    {
	    
		$this->db->select('*');
		$this->db->from('additional_email');
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
		$this->db->group_by('additional_email_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('additional_email_id', $order_type);
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
    function count_additional_email($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('additional_email');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('additional_email_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_additional_email($data)
    {
		$insert = $this->db->insert('additional_email', $data);
	    return $insert;
	}

    /**
    * Update keyword
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_additional_email($id, $data)
    {
		$this->db->where('additional_email_id', $id);
		$this->db->update('additional_email', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	function update_additional_email_by_item_number($id, $data)
    {
		$this->db->where('item_number', $id);
		$this->db->update('additional_email', $data);
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
	function delete_additional_email($id){
		$this->db->where('additional_email_id', $id);
		$this->db->delete('additional_email'); 
	}
	
	function delete_additional_email_by_userid($id){
		$this->db->where('user_id', $id);
		$this->db->delete('additional_email'); 
	}
 
}
?>