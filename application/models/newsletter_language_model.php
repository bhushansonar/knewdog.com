<?php
class newsletter_language_model extends CI_Model {
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
    public function get_language_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('language');
		$this->db->where('language_id', $id);
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
    public function get_language($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null)
    {
	    
		$this->db->select('*');
		$this->db->from('language');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like('language_longform', $search_string);
		}
		$this->db->group_by('language_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('language_id', $order_type);
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
    function count_language($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('language');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like('language_longform', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('language_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_language($data)
    {
		$insert = $this->db->insert('language', $data);
	    return $insert;
	}

    /**
    * Update keyword
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_language($id, $data)
    {
		$this->db->where('language_id', $id);
		$this->db->update('language', $data);
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
	function delete_language($id){
		$this->db->where('language_id', $id);
		$this->db->delete('language'); 
	}
 
}
?>