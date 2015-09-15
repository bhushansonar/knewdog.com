<?php

class comment_model extends CI_Model {

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
    public function get_comment_by_id($id) {
        $this->db->select('comment.*,blog.blog_id,blog.title_en');
        $this->db->from('comment');
        $this->db->join('blog', 'blog.blog_id = comment.blog_id', 'left');
        $this->db->where('comment.comment_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_by_block_name($block_name) {
        $this->db->select('*');
        $this->db->from('comment');
        $this->db->where('block_name', $block_name);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_comment_by_field($field, $value) {
        $this->db->select('*');
        $this->db->from('comment');
        $this->db->where($field, $value);
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
    public function get_comment($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $where_field = array(), $where_value = array()) {

        $this->db->select('comment.*,blog.blog_id,blog.title_en');
        $this->db->from('comment');
        $this->db->join('blog', 'blog.blog_id = comment.blog_id', 'left');
        if ($wherestatus != null) {
            $this->db->where('comment.status', $wherestatus);
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
        $this->db->group_by('comment.comment_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('comment.comment_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();
        //echo $this->db->
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_comment($search_string = null, $order = null, $blog_id = null) {
        $this->db->select('comment.*,blog.blog_id,blog.title_en');
        $this->db->from('comment');
        if ($blog_id) {
            $this->db->where('comment.blog_id', $blog_id);
        }
        $this->db->join('blog', 'blog.blog_id = comment.blog_id', 'left');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('comment_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean 
     */
    function store_comment($data) {
        $insert = $this->db->insert('comment', $data);
        return $insert;
    }

    /**
     * Update keyword
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_comment($id, $data) {
        $this->db->where('comment_id', $id);
        $this->db->update('comment', $data);
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
    function delete_comment_by_blogid($id) {
        $this->db->where('blog_id', $id);
        $this->db->delete('comment');
    }

    function delete_comment($id) {
        $this->db->where('comment_id', $id);
        $this->db->delete('comment');
    }

    function count_untreated_comment() {
        $this->db->where('status','Inactive');
        $num = $this->db->count_all_results('comment');
        return $num;
    }

}

?>