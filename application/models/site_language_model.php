<?php
class site_language_model extends CI_Model {
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
		$this->db->from('site_language');
		$this->db->where('site_language_id', $id);
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
    public function get_language($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherestatus=null,$wherelangshotcode=null)
    {
	    
		$this->db->select('*');
		$this->db->from('site_language');
		
		if($wherestatus != null){
			$this->db->where('status', $wherestatus);
        }
		
		if($wherelangshotcode != null){
			$this->db->where('language_shortcode', $wherelangshotcode);
        }		

		if($search_string){
			$this->db->like('language_longform', $search_string);
		}
		$this->db->group_by('site_language_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('site_language_id', $order_type);
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
		$this->db->from('site_language');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like('language_longform', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('site_language_id', 'Asc');
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
		/*$fields = array(
                        $data['language_shortcode'] => array('type' => 'TEXT')
		);*/
		//$this->dbforge->add_column('language_keyword', $fields);
		$this->db->query('ALTER TABLE  `language_keyword` ADD  `'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `newsletter_keyword` ADD  `'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `newsletter_category` ADD  `'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `cms` ADD  `display_name_'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `cms` ADD  `'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `blog` ADD  `title_'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `blog` ADD  `description_'.$data['language_shortcode'].'` TEXT NOT NULL');
		//bhushan changes
                $this->db->query('ALTER TABLE  `email_template` ADD  `subject_'.$data['language_shortcode'].'` TEXT NOT NULL');
		$this->db->query('ALTER TABLE  `email_template` ADD  `description_'.$data['language_shortcode'].'` TEXT NOT NULL');
		//end changes
		$insert = $this->db->insert('site_language', $data);
	    return $insert;
	}

    /**
    * Update keyword
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_language($id, $data)
    {
		$this->db->where('site_language_id', $id);
		$this->db->update('site_language', $data);
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
		$this->load->model('language_keyword_model');
		$getlang = $this->get_language_by_id($id);
		$this->db->query('ALTER TABLE  `language_keyword` DROP  `'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `newsletter_keyword` DROP  `'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `newsletter_category` DROP  `'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `cms` DROP  `display_name_'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `cms` DROP  `'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `blog` DROP  `title_'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `blog` DROP  `description_'.$getlang[0]['language_shortcode'].'`');
                //bhushan changes
                $this->db->query('ALTER TABLE  `email_template` DROP  `subject_'.$getlang[0]['language_shortcode'].'`');
		$this->db->query('ALTER TABLE  `email_template` DROP  `description_'.$getlang[0]['language_shortcode'].'`');
                //end changes
                
		$this->db->where('site_language_id', $id);
		$this->db->delete('site_language'); 
	}
 
}
?>