<?php

class invoice_model extends CI_Model {

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
    public function get_invoice_by_id($id) {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('invoice_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_invoice_custome_query($query) {
        $query = $this->db->query($query);
        return $query->result_array();
    }

    public function get_invoice_by_field($field = array(), $value = array()) {
        $this->db->select('*');
        $this->db->from('invoice');
        if (count($field) > 0) {
            for ($i = 0; $i < count($field); $i++) {
                $this->db->where($field[$i], $value[$i]);
            }
        }
        $query = $this->db->get();
        //$a = $query->result_array();
       // echo "<pre>";print_r($a);exit;
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
    public function get_invoice($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $where_field = array(), $where_value = array()) {

        $this->db->select('invoice.*,user.username,user.primary_email,user.user_id');
        $this->db->from('invoice');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        //$this->db->order_by('status', 'Active');

        /* if($wherelangshotcode != null){
          $this->db->where('language_shortcode', $wherelangshotcode);
          } */
        //change for search
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->join('user', 'invoice.user_id = user.user_id', 'left');
        $this->db->group_by('invoice_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('invoice_id', $order_type);
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
    function count_invoice($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('invoice');
        //$this->db->where('status', 'Active');
        $this->db->join('user', 'invoice.user_id = user.user_id', 'left');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('invoice_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean 
     */
    function store_invoice($data) {
        $insert = $this->db->insert('invoice', $data);
        return $insert;
    }

    /**
     * Update keyword
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_invoice($id, $data) {
        $this->db->where('invoice_id', $id);
        $this->db->update('invoice', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_invoice_by_item_number($id, $data) {
        $this->db->where('item_number', $id);
        $this->db->update('invoice', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPrimaryEmail($id) {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('item_number', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function get_email_reminder_for_end_of_term() {
        $this->db->select('*');
        $this->db->from('invoice');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function update_flag($id, $data) {
        $this->db->where('invoice_id', $id);
        $this->db->update('invoice', $data);
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
     * Delete keywordr
     * @param int $id - keyword id
     * @return boolean
     */
    function delete_invoice($id) {
        $this->db->where('invoice_id', $id);
        $this->db->delete('invoice');
    }

    function delete_invoice_by_userid($id) {
        $this->db->where('user_id', $id);
        $this->db->delete('invoice');
    }

}

?>