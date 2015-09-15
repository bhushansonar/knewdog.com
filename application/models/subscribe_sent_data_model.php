<?php
class subscribe_sent_data_model extends CI_Model {
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
    public function get_subscribe_sent_data_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('subscribe_sent_data');
		$this->db->where('subscribe_sent_data_id', $id);
		$query = $this->db->get();
		return $query->result_array();
    }    


	public function get_subscribe_sent_data_by_field_value($wherefield=array(),$wherevalue =array() )
    {
		$this->db->select('*');
		$this->db->from('subscribe_sent_data');
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);
			}
			}
		$query = $this->db->get();
		return $query->result_array(); 
    }   
	
	 
	
	public function check_subscribe_sent_in_day($subscribe_id,$every = 1)
    {
		$query1 = $this->db->query('SELECT * from subscribe_sent_data where sending = "Daily" and subscribe_id = "'.$subscribe_id.'" order by subscribe_sent_data_id DESC limit 1');
		$data = $query1->result_array();
		echo "data->".count($data);
		if(count($data) > 0){
			if(empty($every)){
				$every = 1;
			}
			if($every == 1){
				$where = "";
			}else{
				$where = "and DATE(date_sent) != CURRENT_DATE";
				}
			if($every == 'last_day'){
				$a_date = date("Y-m-d");
				//echo date("Y-m-t", strtotime($a_date));
				$e = $days_ago = date("Y-m-t", strtotime($a_date));
			}else{
				$e = $days_ago = date('Y-m-d', strtotime(''.$every.' days',strtotime($data[0]['date_sent'])));
			}
				//echo 'SELECT * from subscribe_sent_data where subscribe_id = "1" and sending = "Daily" AND DATE(date_sent) = "'.$e.'"';
				//die;
			//echo "subscribe_id->".$subscribe_id. ' SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Daily" '.$where.' AND DATE(date_sent) = "'.$e.'"'; 
			//die;
				//SELECT * FROM subscribe_sent_data WHERE date_sent <= CURRENT_DATE AND date_sent >= ( CURRENT_DATE - INTERVAL 2 DAY )
				
				$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Daily" '.$where.' AND CURRENT_DATE = "'.$e.'" ORDER BY subscribe_sent_data_id DESC LIMIT 1');
			
			//$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Daily" and DATE(date_sent) = CURDATE() ');
			echo $this->db->last_query();
			//die;
			$return_data = $query->result_array();
			if(count($return_data) > 0){
					return true;
				}else{
					return false;
					}
		}else{
			
			return true;	
			
			}
    }    
	
	public function check_subscribe_sent_in_weekly($subscribe_id,$weeks_on,$every = 1)
    {
		
		//SELECT * FROM posts WHERE  WEEK(post_date) = WEEK(CURDATE())
		//SELECT udfDayOfWeek(NOW(), 3);
		$query1 = $this->db->query('SELECT * from subscribe_sent_data where sending = "Weekly" and subscribe_id = "'.$subscribe_id.'" order by subscribe_sent_data_id DESC limit 1');
		$data = $query1->result_array();
	
		if(count($data) > 0){
			$days_array = array('Sunday'=>1,'Monday'=>2,'Tuesday'=>3,'Wednesday' => 4,'Thursday' => 5, 'Friday' => 6, 'Saturday' => 7);
			$get_day = $days_array[$weeks_on];
			
			if(empty($every)){
				$every = 1;
			}
			if($every == 1){
				$where = "";
			}else{
				$where = "and DATE(date_sent) != CURRENT_DATE";
				}
				$e = $weeks_ago = date('Y-m-d', strtotime(''.$every.' weeks',strtotime($data[0]['date_sent'])));
			//(DATE(date) = date_sub(date('2011-09-17 00:00:00'), INTERVAL -1 week))
			//echo 'SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Weekly" '.$where.' AND DATE(date_sent) = "'.$e.'" and (SELECT DAYOFWEEK(date_sent) = '.$get_day.')';
			//die;
			//$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Weekly" '.$where.' AND CURRENT_DATE = "'.$e.'" and (SELECT DAYOFWEEK(date_sent) = '.$get_day.')');
			//SELECT * from subscribe_sent_data where subscribe_id = "19" and sending = "Weekly" and DATE(date_sent) != CURRENT_DATE AND  WEEK("2014-07-25") = WEEK(CURDATE()) and (SELECT DAYOFWEEK(CURDATE()) = 2)
			$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Weekly" '.$where.' AND  WEEK("'.$e.'") = WEEK(CURDATE()) and (SELECT DAYOFWEEK(CURDATE()) = '.$get_day.')');
			echo $this->db->last_query();
			//die;
			$return_data = $query->result_array();
			if(count($return_data) > 0){
					return true;
				}else{
					return false;
				}
		}else{
			return true;
			}
    }    
	
	public function check_subscribe_sent_in_monthly($subscribe_id,$currunt_day,$every = 1,$result_array_3,$i)
    {
		
		//SELECT * FROM posts WHERE  WEEK(post_date) = WEEK(CURDATE())
		//SELECT udfDayOfWeek(NOW(), 3);
		/*$days_array = array('Sunday'=>1,'Monday'=>2,'Tuesday'=>3,'Wednesday' => 4,'Thursday' => 5, 'Friday' => 6, 'Saturday' => 7);
		$get_day = $days_array[$weeks_on];
		$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'" and sending = "Monthly" AND MONTH(date_sent) = MONTH(CURDATE()) and (SELECT DAYOFWEEK(date_sent) = '.$get_day.')');
		//echo $this->db->last_query();
		return $query->result_array();*/
		
		$query1 = $this->db->query('SELECT * from subscribe_sent_data where sending = "Monthly" and subscribe_id = "'.$subscribe_id.'" order by subscribe_sent_data_id DESC limit 1');
		//echo $this->db->last_query();
		//die;
		$data = $query1->result_array();
	
		if(count($data) > 0){
			$days_array = array('Sunday'=>1,'Monday'=>2,'Tuesday'=>3,'Wednesday' => 4,'Thursday' => 5, 'Friday' => 6, 'Saturday' => 7);
			
			if(empty($every)){
				$every = 1;
			}
			
			$where = "and DATE(date_sent) != CURRENT_DATE";
			
			if($result_array_3[$i]['monthly_on'] == 'day_of_the_month')
			{
				if($every == 'last_day'){
					$check_sent_date = get_n_months_date(date("Y-m-t",strtotime($data[0]['date_sent'])),$every);
				}else{
						$check_sent_date = get_n_months_date(date("Y-m-".$result_array_3[$i]['day_of_the_month'],strtotime($data[0]['date_sent'])),$every);
					}
			
			$Full_where = 'where subscribe_id = "'.$subscribe_id.'" and sending = "Monthly" '.$where.' AND CURRENT_DATE = "'.$check_sent_date.'"';
			}else{
				$get_day = $days_array[$result_array_3[$i]['monthly_weekday_day']];
				$get_month = get_n_months_date(date("Y-m-d",strtotime($data[0]['date_sent'])),$every); //get Day of month for every
				//echo "sent date=>".$check_sent_date = find_the_first_day_of_month($e,$get_day);
			$Full_where = 'where subscribe_id = "'.$subscribe_id.'" and sending = "Monthly" '.$where.' AND (SELECT DAYOFWEEK(CURDATE()) = '.$get_day .') AND MONTH("'.$get_month.'") = MONTH(CURDATE())';
			// and (SELECT DAYOFWEEK(CURDATE()) = '.$get_day.')
				}

			$query = $this->db->query('SELECT * from subscribe_sent_data '.$Full_where);
			
			echo $this->db->last_query();
				//die;
			$return_data = $query->result_array();
			if(count($return_data) > 0){
					return true;
				}else{
					return false;
				}
		}else{
			return true;
			}
		
    }    
	
	public function check_subscribe_sent_in_yearly($subscribe_id)
    {
		
		$query = $this->db->query('SELECT * from subscribe_sent_data where subscribe_id = "'.$subscribe_id.'"  and sending = "Yearly" AND YEAR(date_sent) = YEAR(CURDATE())');
		//echo $this->db->last_query();
		return $query->result_array();
		
    }    
	

    /**
    * Fetch subscribe_sent_data data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_subscribe_sent_data($search_string=null, $order=null, $order_type='DESC', $limit_start=null, $limit_end=null,$wherefield=array(),$wherevalue=array())
    {
	    
		$this->db->select('*');
		$this->db->from('subscribe_sent_data');
		
		if(count($wherefield) > 0){
			for($i=0;$i<count($wherefield);$i++){
			$this->db->where($wherefield[$i],$wherevalue[$i]);
			}
			}
		//$this->db->order_by('status', 'Active');

		if($search_string){
			$this->db->like($order, $search_string);
		}
		$this->db->group_by('subscribe_sent_data_id');

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('subscribe_sent_data_id', $order_type);
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
    function count_subscribe_sent_data($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('subscribe_sent_data');
		//$this->db->where('status', 'Active');
		if($search_string){
			$this->db->like($order, $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('subscribe_sent_data_id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_subscribe_sent_data($data)
    {
		$insert = $this->db->insert('subscribe_sent_data', $data);
	    return $insert;
	}

    /**
    * Update subscribe_sent_data
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_subscribe_sent_data($id, $data)
    {
		$this->db->where('subscribe_sent_data_id', $id);
		$this->db->update('subscribe_sent_data', $data);
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
    * Delete subscribe_sent_datar
    * @param int $id - subscribe_sent_data id
    * @return boolean
    */
	function delete_subscribe_sent_data($id){
		$this->db->where('subscribe_sent_data_id', $id);
		$this->db->delete('subscribe_sent_data'); 
	}
	
	//not in use
	function delete_subscribe_sent_data_with_userid_newsletterid($user_id,$newsletter_id){
		$this->db->where('s_user_id', $user_id);
		$this->db->where('s_newsletter_id', $newsletter_id);
		$this->db->delete('subscribe_sent_data'); 
	}
	
	function delete_subscribe_sent_data_with_userid($user_id){
		$this->db->where('sd_user_id', $user_id);
		$this->db->delete('subscribe_sent_data'); 
	}
 
}
?>