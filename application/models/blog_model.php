<?php

class blog_model extends CI_Model {

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
    public function get_blog_by_id($id) {
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where('blog_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_blog_by_block_name($block_name) {
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where('block_name', $block_name);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_blog_by_field($field, $value) {
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_blog_by_field_array($field = array(), $value = array()) {
        $this->db->select('*');
        $this->db->from('blog');
        if (count($field) > 0) {
            for ($i = 0; $i < count($field); $i++) {
                $this->db->where($field[$i], $value[$i]);
            }
        }
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
    public function get_blog($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $where_field = array(), $where_value = array()) {

        $this->db->select('*');
        $this->db->from('blog');
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
        $this->db->group_by('blog_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('published_date', $order_type);
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
    function count_blog($search_string = null, $order = null, $wherestatus = null, $where_field = array(), $where_value = array()) {
        $this->db->select('*');
        $this->db->from('blog');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('blog_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_blog($data) {
        $insert = $this->db->insert('blog', $data);
        return $insert;
    }

    /**
     * Update keyword
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_blog($id, $data) {
        $this->db->where('blog_id', $id);
        $this->db->update('blog', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function do_clone($id) {
        $query = $this->db->where('blog_id', $id)->get('blog');
        $array = array();
        $array_a = $query->result_array();
        /* 		foreach($array_a[0] as $key => $value)
          {
          $array_row[] = "`".$key."`";
          $array_value[] = "'".$value."'";
          //$array[] = $row['user_id']; // add each user id to the array
          }
         */
        $array_a[0]['blog_id'] = null;
        //$comma_row = implode(",",$array_row);
        //$comma_value = implode(",",$array_value);
//echo '<pre>'; print_r($array_a[0]['blog_id']);
//echo '<pre>'; print_r($array_value);
        //echo "insert into blog (".$comma_row.") values (".$comma_value.")"; die;
        //$this->db->query("insert into blog (".$comma_row.") values (".$comma_value.")");
        //return true;
        $insert = $this->db->insert('blog', $array_a[0]);
        return $insert;
    }

    /**
     * Delete keywordr
     * @param int $id - keyword id
     * @return boolean
     */
    function delete_blog($id) {
        //delete image logic
        $blog_data = $this->blog_model->get_blog_by_id($id);
        $image_name = $blog_data[0]['featured_image'];
        $checkImage = array();
        $checkImage = $this->blog_model->get_blog_by_field("featured_image", $image_name);
        if (count($checkImage) <= 1) {
            //@unlink("./uploads/" . $image_name);
            @unlink("uploads/" . $image_name);
        }
        //delete image logic end
        $this->db->where('blog_id', $id);
        $this->db->delete('blog');
    }

}

?>