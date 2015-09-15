<?php
class Admin_model extends CI_Model {

    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	function validate($username, $password)
	{
		$this->db->where('username', $username);
                //
		$this->db->where('password', $password);
		$this->db->where('status', 'Active');
		$membership = array('power_admin', 'normal_admin');
		$this->db->where_in('type_of_membership', $membership);
		$query = $this->db->get('user');
		
		
		if($query->num_rows == 1)
		{
			return true;
		}		
	}
	
	function validate_front($username,$password)
	{
            
            $query = $this->db->query("SELECT * FROM (`user`) WHERE (`username` ='{$username}' OR `primary_email`='{$username}') AND `password` = '{$password}' AND `status` = 'Active'");
//		$this->db->or_where('username', $username);
//                $this->db->or_where('primary_email', $email);
//		$this->db->where('password', $password);
//		$this->db->where('status', 'Active');
//		$membership = array();
//		//$this->db->where_in('type_of_membership', $membership);
//		$query = $this->db->get('user');
            //$query->result_array();
                //echo $this->db->last_query(); die;
		$query->result_array();
		if($query->num_rows == 1)
		{
			return true;
		}		
	}
        function validate_email_front($primary_email)
	{
		
		$this->db->where('primary_email', $primary_email);
		$this->db->where('status', 'Active');
		$query = $this->db->get('user');
		if($query->num_rows == 1)
		{
			return true;
		}		
	}
        function update_password($email, $data) {
        $this->db->where('primary_email', $email);
        $this->db->update('user', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
    * Serialize the session data stored in the database, 
    * store it in a new array and return it to the controller 
    * @return array
    */
	function get_db_session_data()
	{
		$query = $this->db->select('user_data')->get('ci_sessions');
		$user = array(); /* array to store the user data we fetch */
		foreach ($query->result() as $row)
		{
		    $udata = unserialize($row->user_data);
		    /* put data in array using username as key */
		    $user['user_name'] = $udata['user_name']; 
		    $user['is_logged_in'] = $udata['is_logged_in']; 
		}
		return $user;
	}
	
    /**
    * Store the new user's data into the database
    * @return boolean - check the insert
    */	
	function create_member()
	{

		$this->db->where('user_name', $this->input->post('username'));
		$query = $this->db->get('membership');

        if($query->num_rows > 0){
        	echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>';
			  echo "Username already taken";	
			echo '</strong></div>';
		}else{

			$new_member_insert_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email_addres' => $this->input->post('email_address'),			
				'user_name' => $this->input->post('username'),
				'pass_word' => md5($this->input->post('password'))						
			);
			$insert = $this->db->insert('membership', $new_member_insert_data);
		    return $insert;
		}
	      
	}//create_member
	
	function get_user_id($username)
	{
//		$this->db->where('username', $username);
//		$query = $this->db->get('user');
		$query = $this->db->query("SELECT * FROM (`user`) WHERE (`username` ='{$username}' OR `primary_email`='{$username}')");
		
                //echo $this->db->last_query(); die;
                if($query->num_rows == 1)
		{
			return $query->result();
		}		
	}
}

