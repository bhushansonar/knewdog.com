<?php

class language_keyword_model extends CI_Model {

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
    public function get_language_keyword_by_id($id) {
        $this->db->select('*');
        $this->db->from('language_keyword');
        $this->db->where('language_keyword_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_language_keyword_by_field_array($where_field = array(), $where_value = array()) {
        $this->db->select('*');
        $this->db->from('language_keyword');
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }

        $query = $this->db->get();
        //echo "query->".$this->db->last_query();;
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
    public function get_language_keyword($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('language_keyword');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        /* if($wherelangshotcode != null){
          $this->db->where('language_shortcode', $wherelangshotcode);
          } */

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('language_keyword_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('language_keyword_id', $order_type);
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
    function count_language_keyword($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('language_keyword');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('language_keyword_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_language_keyword($data) {
        $insert = $this->db->insert('language_keyword', $data);
        return $insert;
    }

    /**
     * Update keyword
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_language_keyword($id, $data) {
        $this->db->where('language_keyword_id', $id);
        $this->db->update('language_keyword', $data);
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
    function delete_language_keyword($id) {
        $this->db->where('language_keyword_id', $id);
        $this->db->delete('language_keyword');
    }

    function getFieldData($tabel, $field, $whereStr) {
        $this->db->select('en');
        $this->db->from($tabel);
        $this->db->where($field, $whereStr);
        $query = $this->db->get();
        $data = $query->result();
//        echo "<pre>";
//                print_r($data);exit;
        if ($data) {
            return $data[0]->$field;
        }
    }

    function get_field_data($tabel, $language_define, $field, $data) {

        $whereStr = "{$language_define} = '{$data}'";
        $sql = "Select $field from $tabel where  $whereStr";
        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            return $data[0]->$field;
        }
    }

}

?>