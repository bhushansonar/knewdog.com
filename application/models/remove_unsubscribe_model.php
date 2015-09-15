<?php
class remove_unsubscribe_model extends CI_Model {
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
    public function get_remove_unsubscribe_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('remove_unsubscribe');
		$this->db->where('remove_unsubscribe_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	
	 public function get_remove_unsubscribe_text()
    {
		$this->db->select('*');
		$this->db->from('remove_unsubscribe');
		$this->db->where('remove_unsubscribe','text');
		$this->db->where('status', 'Active');
		$query = $this->db->get();
		return $query->result_array(); 
    } 
	
	public function get_remove_unsubscribe_url()
    {
		$this->db->select('*');
		$this->db->from('remove_unsubscribe');
		$this->db->where('remove_unsubscribe','url');
		$this->db->where('status', 'Active');
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch remove_unsubscribe data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_remove_unsubscribe($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null)
    {
		$this->db->select('*');
		$this->db->from('remove_unsubscribe');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('remove_unsubscribe_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('remove_unsubscribe_id', $order_type);
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
    function count_remove_unsubscribe($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('remove_unsubscribe');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('remove_unsubscribe_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_remove_unsubscribe($data)
    {
		$insert = $this->db->insert('remove_unsubscribe', $data);
	    return $insert;
	}

    /**
    * Update remove_unsubscribe
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_remove_unsubscribe($id, $data)
    {
		$this->db->where('remove_unsubscribe_id', $id);
		//$this->db->where_not_in('username', $names);
		$this->db->update('remove_unsubscribe', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	function update_remove_unsubscribe_status($id,$data){
		$this->db->where_not_in('remove_unsubscribe_id', $id);
		$this->db->update('remove_unsubscribe', $data);
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
    * Delete remove_unsubscriber
    * @param int $id - remove_unsubscribe id
    * @return boolean
    */
	function delete_remove_unsubscribe($id){
		$this->db->where('remove_unsubscribe_id', $id);
		$this->db->delete('remove_unsubscribe'); 
	}
 
}
?>