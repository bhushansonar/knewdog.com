<?php

class Schedule_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    /**
     * Get product by his is
     * @param int $product_id 
     * @return array
     */
    public function get_schedule_by_id($id) {
        $this->db->select('*');
        $this->db->from('schedule');
        $this->db->where('schedule_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch schedule data from the database
     * possibility to mix search, filter and order
     * @param string $search_string 
     * @param strong $order
     * @param string $order_type 
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_schedule($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherefield = array(), $wherevalue = array()) {

        $this->db->select('*');
        $this->db->from('schedule');

        if (count($wherefield) > 0) {
            for ($i = 0; $i < count($wherefield); $i++) {
                $this->db->where($wherefield[$i], $wherevalue[$i]);
            }
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('schedule_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('schedule_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
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
    function count_schedule($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('schedule');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('schedule_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean 
     */
    function store_schedule($data) {
//        echo "<pre>";
//        print_r($data);
//        exit;
        $insert = $this->db->insert('schedule', $data);
        return $insert;
    }

    /**
     * Update schedule
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_schedule($id, $data) {
        $this->db->where('schedule_id', $id);
        $this->db->update('schedule', $data);
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
     * Delete scheduler
     * @param int $id - schedule id
     * @return boolean
     */
    function delete_schedule($id) {
        $this->db->where('schedule_id', $id);
        $this->db->delete('schedule');
    }

    //not in use
    function delete_schedule_with_userid_newsletterid($user_id, $newsletter_id) {
        $this->db->where('s_user_id', $user_id);
        $this->db->where('s_newsletter_id', $newsletter_id);
        $this->db->delete('schedule');
    }

    function delete_schedule_with_userid($user_id) {
        $this->db->where('sd_user_id', $user_id);
        $this->db->delete('schedule');
    }

}

?>