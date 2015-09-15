<?php
class cpanel_model extends CI_Model {
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
    public function get_cpanel_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('cpanel');
		$this->db->where('cpanel_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch cpanel data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_cpanel($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null)
    {
	    
		$this->db->select('*');
		$this->db->from('cpanel');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like('cpanel', $search_string);
		}
		$this->db->group_by('cpanel_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('cpanel_id', $order_type);
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
    function count_cpanel($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('cpanel');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like('cpanel', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('cpanel_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_cpanel($data)
    {
		$insert = $this->db->insert('cpanel', $data);
	    return $insert;
	}

    /**
    * Update cpanel
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_cpanel($id, $data)
    {
		$this->db->where('cpanel_id', $id);
		$this->db->update('cpanel', $data);
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
    * Delete cpanelr
    * @param int $id - cpanel id
    * @return boolean
    */
	function delete_cpanel($id){
		$this->db->where('cpanel_id', $id);
		$this->db->delete('cpanel'); 
	}
 
}
?>