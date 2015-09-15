<?php

class Subscribe_model extends CI_Model {

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
    public function get_subscribe_by_id($id) {
        $this->db->select('*');
        $this->db->from('subscribe');
        $this->db->where('subscribe_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch subscribe data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_subscribe($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherefield = array(), $wherevalue = array()) {

        $this->db->select('*');
        $this->db->from('subscribe');

        if (count($wherefield) > 0) {
            for ($i = 0; $i < count($wherefield); $i++) {
                $this->db->where($wherefield[$i], $wherevalue[$i]);
            }
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('subscribe_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('subscribe_id', $order_type);
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
    function get_most_three_subscribed_newsletter() {

        $query = $this->db->query('SELECT subscribe.s_newsletter_id,COUNT(subscribe.s_newsletter_id) as count_newsletter_id, newsletter.newsletter_name, newsletter.author_name, newsletter.newsletter_id, newsletter.screenshot
FROM subscribe left join newsletter on subscribe.s_newsletter_id = newsletter.newsletter_id where newsletter.newsletter_name != "" and newsletter.author_name != ""
GROUP BY subscribe.s_newsletter_id
ORDER BY count_newsletter_id DESC LIMIT 3');

        //$query = $this->db->get();
        return $query->result_array();
    }

    //Sending newsletter 1
    function get_subscribed_for_out_going_free_NS() {

        $query = $this->db->query('SELECT sb.subscribe_id,sb.subscribe_date,sc.*,us.user_id,us.primary_email,ns.newsletter_id,ns.newsletter_rand_id,ns.blacklist_flag,ns.blacklist_index,us.type_of_membership from subscribe as sb left join schedule as sc on sb.schedule_id = sc.schedule_id left join user as us on sb.s_user_id = us.user_id left join newsletter as ns on sb.s_newsletter_id = ns.newsletter_id where us.status = "Active" and sb.schedule_id = 0 and us.type_of_membership = "FREE" and ns.blacklist_flag != "YES" order by sb.s_user_id');
        return $query->result_array();
    }

    //Sending newsletter 2

    function get_subscribed_for_out_going_notfree_null_NS() {

        $query = $this->db->query('SELECT sb.subscribe_id,sb.subscribe_date,sc.*,us.user_id,us.primary_email,ns.newsletter_id,ns.newsletter_rand_id,ns.blacklist_flag,ns.blacklist_index,us.type_of_membership from subscribe as sb left join schedule as sc on sb.schedule_id = sc.schedule_id left join user as us on sb.s_user_id = us.user_id left join newsletter as ns on sb.s_newsletter_id = ns.newsletter_id where us.status = "Active" and sb.schedule_id = 0 and us.type_of_membership != "FREE" and ns.blacklist_flag != "YES" order by sb.s_user_id');
        return $query->result_array();
    }

    //Sending newsletter 3
    function get_subscribed_for_out_going_notfree_notnull_NS() {

        $query = $this->db->query('SELECT
					sb.subscribe_id,
					sb.subscribe_date,
					sc.*,
					us.user_id,
					us.primary_email,
					ns.newsletter_id,
					ns.newsletter_rand_id,
					ns.blacklist_flag,
					ns.blacklist_index,
					us.type_of_membership,
					us.sn_of_last_newsletter,
					us.time_zone,
					(select outns.sn from outgoing_newsletter as outns where outns.user_id = us.user_id and outns.newsletter_id = ns.newsletter_id order by date desc limit 1) as last_sn
					from subscribe as sb
					left join schedule as sc on sb.schedule_id = sc.schedule_id
					left join user as us on sb.s_user_id = us.user_id
					left join newsletter as ns on sb.s_newsletter_id = ns.newsletter_id
					where us.status = "Active" and
					sb.schedule_id != 0 and
					us.type_of_membership != "FREE" and
					ns.blacklist_flag != "YES"
					order by sb.s_user_id ASC');
        return $query->result_array();
    }

    function count_subscribe($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('subscribe');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('subscribe_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_subscribe($data) {
        $insert = $this->db->insert('subscribe', $data);
        return $insert;
    }

    /**
     * Update subscribe
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_subscribe($id, $data) {
        $this->db->where('subscribe_id', $id);
        $this->db->update('subscribe', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_subscribe_with_schedule_id($id, $data) {
        $this->db->where('schedule_id', $id);
        $this->db->update('subscribe', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_subscribe_with_user_id_nl_id($id_field = array(), $id_value = array(), $data = array()) {
        if (count($id_field) > 0) {
            for ($i = 0; $i < count($id_field); $i++) {
                $this->db->where($id_field[$i], $id_value[$i]);
            }
        }
        //$this->db->where('subscribe_id', $id);
        $this->db->update('subscribe', $data);
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
     * Delete subscriber
     * @param int $id - subscribe id
     * @return boolean
     */
    function delete_subscribe($id) {
        $this->db->where('subscribe_id', $id);
        $this->db->delete('subscribe');
    }

    function delete_subscribe_with_userid_newsletterid($user_id, $newsletter_id) {
        $this->db->where('s_user_id', $user_id);
        $this->db->where('s_newsletter_id', $newsletter_id);
        $this->db->delete('subscribe');
    }

    function delete_subscribe_with_schedule_id($schedule_id) {
        $this->db->where('schedule_id', $schedule_id);
        $this->db->delete('subscribe');
    }

    function delete_subscribe_with_userid($user_id) {
        $this->db->where('s_user_id', $user_id);
        $this->db->delete('subscribe');
    }

    function delete_subscribe_with_newsletterid($newsletter_id) {
        $this->db->where('s_newsletter_id', $newsletter_id);
        $this->db->delete('subscribe');
    }

}

?>