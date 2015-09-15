<?php

class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();
    }

    public function is_unique($str, $field) {
        //echo "hi"; die;
        $field_ar = explode('.', $field);
        $query = $this->CI->db->get_where($field_ar[0], array($field_ar[1] => $str), 1, 0);
        //echo '<pre>'; print_r($query->num_rows()); die;
        //$this->CI->form_validation->set_message($field,'That %s already exists.');
        if ($query->num_rows() === 0) {
            return TRUE;
        }

        return FALSE;
    }

    function edit_unique($value, $params) {
        $CI = & get_instance();
        $CI->load->database();
        /* $defined_word ='';
          if(defined(UNIQUE_MESSAGE_USER_EXISTS)){
          $defined_word = UNIQUE_MESSAGE_USER_EXISTS;
          }else{
          $defined_word = "Sorry, that %s is already being used.";
          } */
        $CI->form_validation->set_message('edit_unique', UNIQUE_MESSAGE_USER_EXISTS);

        list($table, $field, $current_id) = explode(".", $params);

        $query = $CI->db->select()->from($table)->where($field, $value)->limit(1)->get();
        $array = json_decode(json_encode($query->row()), true);
        $first_id = array_keys($array);
        if ($query->row() && $query->row()->$first_id[0] != $current_id) {
            return FALSE;
        }
    }

    function count_schedule($value, $params) {
        $CI = & get_instance();
        $CI->load->database();
        //echo $params; die;
        list($current_user_id, $count) = explode(".", $params);
        $CI->form_validation->set_message('count_schedule', "Sorry, you can only add " . $count . " %ss.");

        //$query = $CI->db->select()->from($table)->where($field, $current_user_id)->get();
        //$array = $query->result_array();
        $CI->db->select('*');
        $CI->db->from('schedule');
        $CI->db->where('sd_user_id', $current_user_id);
        $query = $CI->db->get();
        //echo $CI->db->last_query(); die;
        $array = $query->result_array();

        //$array = json_decode(json_encode($query->row()), true);
        //echo '<pre>'; print_r($array); die;
        //echo $count. " == ".count($array); die;
        if (count($array) >= $count) {
            return FALSE;
        }
    }

    function count_content($value, $params) {
        $CI = & get_instance();
        $CI->load->database();

        list($table, $field, $current_user_id, $count) = explode(".", $params);
        $CI->form_validation->set_message('count_content', "Sorry, you can only add " . $count . " %ss .");

        $query = $CI->db->select()->from($table)->where($field, $current_user_id)->get();
        $array = $query->result_array();
        //$array = json_decode(json_encode($query->row()), true);
        //echo '<pre>'; print_r($array); die;
        //echo $count. " == ".count($array); die;
        if (count($array) >= $count) {
            return FALSE;
        }
    }

    function valid_url($str) {
        require('AvailabilityService.php');
        $service = new HelgeSverre\DomainAvailability\AvailabilityService(true);
        $domain = $str;
//        if (!$domain) {
//            return FALSE;
//        }
        $domain = preg_replace("(^https?://)", "", $domain);
        $available = $service->isAvailable($domain);

        if ($available) {
            return FALSE;
        } else {
            return TRUE;
        }
        /* if(filter_var($str, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) == TRUE){
          return TRUE;
          }else{
          return FALSE;
          } */
        //$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        // $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        /* $pattern = "/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/";
          if (!preg_match($pattern, $str))
          {
          return FALSE;
          }

          return TRUE; */
//        $ch = @curl_init($str);
//
//        @curl_setopt($ch, CURLOPT_HEADER, TRUE);
//        @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
//        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
//        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        $status = array();
//        preg_match('/HTTP\/.* ([0-9]+) .*/', @curl_exec($ch), $status);
//        echo '<pre>';
//        print_r($status);
//        echo '</pre>';
//        echo "dns->" . checkdnsrr($str, 'ANY');
//        die;
//        if (@$status[1] == 200 || @$status[1] == 302) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
    }

    function check_min_max($input, $min, $max) {
        $length = ($input);

        if ($length <= $max && $length >= $min) {
            return TRUE;
        } elseif ($length < $min) {
            $this->form_validation->set_message('check_length', 'Minimum number is ' . $min);
            return FALSE;
        } elseif ($length > $max) {
            $this->form_validation->set_message('check_length', 'Maximum number is ' . $max);
            return FALSE;
        }
    }

    function password_matches($submitted_value, $admin_id) {
        $CI = & get_instance();
        $CI->load->database();
        $CI->load->model('user_model');
        $get_user = $CI->user_model->get_user_by_id($admin_id);
        $old_type_pass_field = md5($submitted_value);
        $old_db_password = $get_user[0]['password'];
        //load your admin by id, validate current password.
        if ($old_db_password != $old_type_pass_field) {
            $CI->form_validation->set_message('password_matches', 'The password you supplied does not match your existing password.');
            return FALSE;
        }

        //passed...
        return TRUE;
    }

}
