<?php

class advertisement_model extends CI_Model {

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
    public function get_advertisement_by_id($id) {
        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('advertisement_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch advertisement data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_advertisement($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('advertisement');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like('advertisement', $search_string);
        }
        $this->db->group_by('advertisement_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('advertisement_id', $order_type);
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

    public function get_advertisement_active() {

        $this->db->select('*');
        $this->db->from('advertisement');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_advertisement($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('advertisement');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like('advertisement', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('advertisement_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_advertisement($data) {
        $insert = $this->db->insert('advertisement', $data);
        return $insert;
    }

    /**
     * Update advertisement
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_advertisement($id, $data) {
        $this->db->where('advertisement_id', $id);
        $this->db->update('advertisement', $data);
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
     * Delete advertisementr
     * @param int $id - advertisement id
     * @return boolean
     */
    function delete_advertisement($id) {
        $this->db->where('advertisement_id', $id);
        $this->db->delete('advertisement');
    }

    function get_add_from_keyword($keywords) {
        //$this->db->query("select * from advertisement where
        //";
        $where = "";
        for ($i = 0; $i < count($keywords); $i++) {
            if ($i != 0) {
                $where .= "OR FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            } else {
                $where .= "FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            }
        }
        $query_row = "select * from advertisement where status = 'Active' and " . $where;
        $query = $this->db->query($query_row);
        //echo $this->db->last_query();
        return $query->result_array();
    }

}

?>