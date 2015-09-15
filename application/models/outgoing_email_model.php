<?php
class outgoing_email_model extends CI_Model {
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
    public function get_outgoing_email_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('outgoing_email');
		$this->db->where('outgoing_email_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	
	 public function get_outgoing_email_by_field_value_array($field =array(),$value= array())
    {
		$this->db->select('*');
		$this->db->from('outgoing_email');
		
		if(count($field) > 0){
			for($i=0;$i<count($field);$i++){
				$this->db->where($field[$i], $value[$i]);
			}
		}
		$query = $this->db->get();
		return $query->result_array(); 
    }    
	
	 public function get_outgoing_email_unique($field =array(),$value= array())
    {
		$query = $this->db->query("SELECT count(*) as mail_count, `email`, `type_of_member` FROM outgoing_email GROUP BY `email`,`type_of_member`");
		
		return $query->result_array(); 
    }    

    /**
    * Fetch outgoing_email data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_outgoing_email($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null)
    {
	    
		$this->db->select('*');
		$this->db->from('outgoing_email');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('outgoing_email_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('outgoing_email_id', $order_type);
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
    function count_outgoing_email($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('outgoing_email');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('outgoing_email_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_outgoing_email($data)
    {
		$insert = $this->db->insert('outgoing_email', $data);
	    return $insert;
	}

    /**
    * Update outgoing_email
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_outgoing_email($id, $data)
    {
		$this->db->where('outgoing_email_id', $id);
		$this->db->update('outgoing_email', $data);
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
    * Delete outgoing_emailr
    * @param int $id - outgoing_email id
    * @return boolean
    */
	function delete_outgoing_email($id){
		$this->db->where('outgoing_email_id', $id);
		$this->db->delete('outgoing_email'); 
	}
	
	
 
}
?>