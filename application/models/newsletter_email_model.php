<?php
class newsletter_email_model extends CI_Model {
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
    public function get_newsletter_email_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('newsletter_email');
		$this->db->where('newsletter_email_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    } 
	
	 public function get_newsletter_email_by_newsid($id)
    {
		$this->db->select('*');
		$this->db->from('newsletter_email');
		$this->db->where('newsletter_id', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch newsletter_email data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_newsletter_email($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null)
    {
	    
		$this->db->select('*');
		$this->db->from('newsletter_email');
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('newsletter_email_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('newsletter_email_id', $order_type);
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
    function count_newsletter_email($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('newsletter_email');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('newsletter_email_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_newsletter_email($data)
    {
		$insert = $this->db->insert('newsletter_email', $data);
	    return $insert;
	}

    /**
    * Update newsletter_email
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_newsletter_email($id, $data)
    {
		$this->db->where('newsletter_email_id', $id);
		$this->db->update('newsletter_email', $data);
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
    * Delete newsletter_emailr
    * @param int $id - newsletter_email id
    * @return boolean
    */
	function delete_newsletter_email($id){
		$this->db->where('newsletter_email_id', $id);
		$this->db->delete('newsletter_email'); 
	}
	
	function delete_newsletter_email_by_newsid($id){
		$this->db->where('newsletter_id', $id);
		$this->db->delete('newsletter_email'); 
	}
 
}
?>