<?php

class wanted_add_model extends CI_Model {

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
    public function get_wanted_add_by_id($id) {
        $this->db->select('*');
        $this->db->from('wanted_add');
        $this->db->where('wanted_add_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch wanted_add data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_wanted_add($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('wanted_add');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('wanted_add_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('wanted_add_id', $order_type);
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
    function count_wanted_add($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('wanted_add');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('wanted_add_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_wanted_add($data) {
        $insert = $this->db->insert('wanted_add', $data);
        return $insert;
    }

    /**
     * Update wanted_add
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_wanted_add($id, $data) {
        $this->db->where('wanted_add_id', $id);
        //$this->db->where_not_in('username', $names);
        $this->db->update('wanted_add', $data);
//        echo $this->db->last_query();
//        die;
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_wanted_add_status($id, $data) {

        $this->db->where_not_in('wanted_add_id', $id);
        $this->db->update('wanted_add', $data);

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
     * Delete wanted_addr
     * @param int $id - wanted_add id
     * @return boolean
     */
    function delete_wanted_add($id) {
        $this->db->where('wanted_add_id', $id);
        $this->db->delete('wanted_add');
    }

}

?>