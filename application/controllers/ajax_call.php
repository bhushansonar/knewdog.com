<?php

class Ajax_call extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    //const VIEW_FOLDER = 'kd2a2a0u1g4/site_language';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('site_language_model');
        $this->load->model('subscribe_model');
        $this->load->model('user_model');
        $this->load->model('newsletter_language_model');
        $this->load->model('site_language_model');
        $this->load->model('newsletter_keyword_model');
        $this->load->model('schedule_model');
        $this->load->model('additional_email_model');
        $this->load->model('time_zone_model');

        /* if(!$this->session->userdata('is_logged_in')){
          redirect('kd2a2a0u1g4/login');
          } */
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function set_session_language_shortcode() {
        //echo '<pre>'; print_r($_REQUEST);
        $language_shortcode = $this->input->post('lang');
        $data = array(
            'language_shortcode' => $language_shortcode,
        );
        $this->session->set_userdata($data);
        // print_r($this->session->userdata);
        //redirect($this->uri->uri_string());
    }

    public function profile_delete() {
        $id = $this->input->post('language_id');
        $field = $this->input->post('field');
        $user_id = $this->input->post('table_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $data = $get_user[0][$field];
        $newdata = explode(",", $data);
        //print_r($newdata);
        if (in_array($id, $newdata)) {
            unset($newdata[array_search($id, $newdata)]);
        }
        //print_r($newdata);
        if (count($newdata) > 0) {
            $str = implode(",", $newdata);
            $array = array($field => $str);
        } else {
            $array = array($field => '');
        }
        //print_r($array);
        if ($this->user_model->update_user($user_id, $array) == true) {
            return true;
        }
    }

    public function update_user() {

        $field = $this->input->post('field');
        $user_id = $this->input->post('user_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $userdata = $get_user[0][$field];
        if ($userdata == "YES") {
            $this->user_model->update_user($user_id, array($field => "NO"));
            echo "NO";
        } else if ($userdata == "NO") {
            $this->user_model->update_user($user_id, array($field => "YES"));
            echo "YES";
        }
    }

    public function remove_avatar() {

        $field = 'avatar';
        $user_id = $this->session->userdata('user_id');
        $get_user = $this->user_model->get_user_by_id($user_id);
        $userdata = $get_user[0][$field];

        @unlink(FCPATH . "uploads/avatar/" . $userdata);
        //echo FCPATH."uploads\avatar/".$userdata; die;
        $this->user_model->update_user($user_id, array($field => ""));
        echo "YES";
    }

    public function popups_ajax() {

        $cls = $this->uri->segment(3);
        if ($cls == 'subscribe_1') {
            $this->load->model('newsletter_model');
            $newsletter_id = $this->uri->segment(4);
            $user_id = $this->uri->segment(5);
            $data['cls'] = $cls;
            $data['user_id'] = $user_id;
            //allow check
            $type_of_membership = $this->session->userdata('type_of_membership');
            $data['type_of_membership'] = $type_of_membership;
            $data['allow_subscription'] = schedule_newsletter_to_choose_limit($type_of_membership);
            $where_field1 = array('s_user_id');
            $where_value1 = array($user_id);
            $data['subscribe_users'] = $this->subscribe_model->get_subscribe('', '', '', '', '', $where_field1, $where_value1);

            $where_Sfield = array('s_newsletter_id', 's_user_id');
            $where_Svalue = array($newsletter_id, $user_id);
            $data['subscribe'] = $this->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);

            $where_field_schedule = array('sd_user_id');
            $where_value_schedule = array($user_id);
            $data['schedule'] = $this->schedule_model->get_schedule('', 'schedule_id', 'ASC', '', '', $where_field_schedule, $where_value_schedule);
            $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
            $this->load->view('includes/popups_ajax.php', $data);
        } else if ($cls == 'subscribe_1_edit') {

            $this->load->model('newsletter_model');
            $newsletter_id = $this->uri->segment(4);
            $schedule_id = $this->uri->segment(5);
            $user_id = $this->session->userdata('user_id');
            $data['cls'] = $cls;
            $data['user_id'] = $user_id;

            $where_Sfield = array('s_newsletter_id', 's_user_id');
            $where_Svalue = array($newsletter_id, $user_id);
            $data['subscribe'] = $this->subscribe_model->get_subscribe('', '', '', '', '', $where_Sfield, $where_Svalue);
            $where_field_schedule = array('sd_user_id');
            $where_value_schedule = array($user_id);
            $data['schedule'] = $this->schedule_model->get_schedule('', 'schedule_id', 'ASC', '', '', $where_field_schedule, $where_value_schedule);
            $data['schedule_id'] = $schedule_id;
            $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
            $this->load->view('includes/popups_ajax.php', $data);
        } elseif ($cls == 'subscribe_success') {
            $this->load->model('newsletter_model');
            $newsletter_id = $this->uri->segment(4);
            $data['cls'] = $cls;
            $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
            $this->load->view('includes/popups_ajax.php', $data);
        } elseif ($cls == 'unsubscribe') {
            $this->load->model('newsletter_model');
            $newsletter_id = $this->uri->segment(4);
            $user_id = $this->uri->segment(5);

            $this->subscribe_model->delete_subscribe_with_userid_newsletterid($user_id, $newsletter_id);
            echo "delete";
        } elseif ($cls == 'profile') {
            $user_id = $this->session->userdata('user_id');
            //$this->load->model('additional_email_model');

            $data['cls'] = $cls;
            $data['number'] = $this->uri->segment(4);
            if ($this->session->userdata('language_shortcode')) {
                $orderby = $this->session->userdata('language_shortcode');
            } else {
                $orderby = 'en';
            }
            //echo $orderby;exit;
            $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', $orderby, 'ASC', '', '', 'Active');
            $data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '', '', 'Active', '');
            $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
            $data['user'] = $this->user_model->get_user_by_id($user_id);
            $data['time_zone'] = $this->time_zone_model->get_time_zone('', '', '', '', '', '', array(), array());
            //echo "got->". print_r($data['time_zone']); die;
            //$data['additional_email'] = $this->additional_email_model->get_additional_email_by_field(array("user_id"),array($user_id));
            $this->load->view('includes/popups_ajax.php', $data);
        } elseif ($cls == 'schedule') {
            $user_id = $this->session->userdata('user_id');
            $data['cls'] = $cls;
            $schedule_id = $this->uri->segment(4);
            $data['user'] = $this->user_model->get_user_by_id($user_id);
            $data['schedule'] = $this->schedule_model->get_schedule_by_id($schedule_id);
            $data['additional_email'] = $this->additional_email_model->get_additional_email_by_field(array("user_id"), array($user_id));
            //print_r($data['schedule']); die;
            $this->load->view('includes/popups_ajax.php', $data);
        } elseif ($cls == 'delete_schedule') {
            $user_id = $this->session->userdata('user_id');
            $data['cls'] = $cls;
            $schedule_id = $this->uri->segment(4);
            $this->schedule_model->delete_schedule($schedule_id);
            $this->subscribe_model->update_subscribe_with_schedule_id($schedule_id, array("schedule_id" => 0));
            echo "delete";
            //$data['additional_email'] = $this->additional_email_model->get_additional_email_by_field(array("user_id"),array($user_id));
            //print_r($data['schedule']); die;
            //$this->load->view('includes/popups_ajax.php',$data);
        } elseif ($cls == 'account_settings') {
            $user_id = $this->session->userdata('user_id');
            $data['cls'] = $cls;
            $data['number'] = $this->uri->segment(4);
            $data['keyword'] = $this->newsletter_keyword_model->get_keyword('', '', 'ASC', '', '', 'Active');
            $data['language'] = $this->newsletter_language_model->get_language('', 'language_longform', 'ASC', '', '', 'Active', '');
            $data['site_language'] = $this->site_language_model->get_language('', '', '', '', '', 'Active', '');
            $data['countries'] = $this->user_model->get_countries('country_name', 'ASC');
            $data['user'] = $this->user_model->get_user_by_id($user_id);
            $this->load->view('includes/popups_ajax.php', $data);
        } elseif ($cls == 'archive_newsletter') {

            $this->load->model('newsletter_model');
            $newsletter_id = $this->uri->segment(4);
            $data['cls'] = $cls;
            $data['newsletter'] = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
            $this->load->view('includes/popups_ajax.php', $data);
        } else if ($cls == 'additional_email') {
            $user_id = $this->session->userdata('user_id');
            $this->load->model('additional_email_model');

            $data['cls'] = $cls;
            $data['number'] = $this->uri->segment(4);
            $data['additional_email'] = $this->additional_email_model->get_additional_email_by_field(array("user_id"), array($user_id));
            $this->load->view('includes/popups_ajax.php', $data);
        } else if ($cls == 'cancle_account') {

            $user_id = $this->session->userdata('user_id');
            $data['cls'] = $cls;
            $data['number'] = $this->uri->segment(4);
            $data['user_id'] = $user_id;

            $this->load->view('includes/popups_ajax.php', $data);
        }
    }

    function popups_ajax_delete() {
        $email_id = $this->uri->segment(3);
        $this->additional_email_model->delete_additional_email($email_id);
        echo "delete_mail";
        //redirect('myknewdog');
    }

    function translate_keyword() {
//        echo "<pre>";
//        print_r($_POST);
//        exit;
        $lang = $this->session->userdata('language_shortcode');
        $main_translate_str = "";

        $sending_d_t = @$_POST['sending_d_t'];
        $every_d_t = explode(" ", $_POST['every_d_t']);
        $monthly_count = @$_POST['monthly_count'];
        $monthly = @$_POST['monthly'];
        $day_of_month = @$_POST['day_of_month'];
        $on = @$_POST['on'];

        $at_d_t = explode(" ", @$_POST['at_d_t']);
        $sending_to_email_d_t = $_POST['sending_to_email_d_t'];
        $to_email = $_POST['to_email'];

        //echo $_POST['sending_to_email_d_t'];
        //echo "<pre>";print_r($sending_to_email_d_t);exit;
//        if ($sending_to_email_d_t[1] == 'to') {
//            $to_email = "to_email";
//        } else {
//            $to_email = $sending_to_email_d_t[1];
//        }
        $ends_in_t = explode(" ", $_POST['ends_in_t']);
        $end_in_length = strlen($_POST['ends_in_t']);
        if ($end_in_length == 13) {
            $ends_in_t1 = $ends_in_t[1];
            $ends_in_t2 = $ends_in_t[2];
            $main_ends_in_t = "'" . $ends_in_t1 . "','";
            $main_ends_in_t .= $ends_in_t2 . "'";
        } elseif ($end_in_length >= 26) {
            $ends_in_t3 = $ends_in_t[1];
            $ends_in_t4 = $ends_in_t[2];
            $ends_in_t5 = $ends_in_t[4];
            $main_ends_in_t = "'" . $ends_in_t3 . "','";
            $main_ends_in_t .= $ends_in_t4 . "','";
            $main_ends_in_t .= $ends_in_t5 . "'";
        } elseif ($end_in_length == 21) {
            $ends_in_t6 = $ends_in_t[1];
            $ends_in_t7 = $ends_in_t[2];
            $main_ends_in_t = "'" . $ends_in_t6 . "','";
            $main_ends_in_t .= $ends_in_t7 . "'";
        } else {
            $main_ends_in_t = "";
        }

        $keyword_arry = array("'$sending_d_t'", "'$every_d_t[1]'", "'$every_d_t[3]'", "'$at_d_t[1]'", "'$to_email'", $main_ends_in_t);

//        echo "<pre>";
//        print_r($keyword_arry);
//        exit;
        $lang = $this->session->userdata('language_shortcode');
        $langauges = $this->user_model->get_translate_languages('en', $keyword_arry);
//        echo "<pre>";
//        print_r($langauges);
//        exit;
        $checkbox_value = array();
        //$days_value = "";
        if (!empty($_POST['weeks_on_d_t'])) {
            $weeks_on_d_remove_comma = str_replace(',', '', $_POST['weeks_on_d_t']);
            $weeks_on_d_t = explode(" ", $weeks_on_d_remove_comma);
            //echo "<pre>";print_r($weeks_on_d_t);exit;
            $weeks_on_d_t[0] = "'" . $weeks_on_d_t[0];
            $main_weeks_on_d_t = implode("','", $weeks_on_d_t) . "'";
            $keyword_checkbox_arry = array($main_weeks_on_d_t);
            // echo "<pre>";print_r($keyword_checkbox_arry);exit;
            $langauges_checkbox = $this->user_model->get_translate_languages('en', $keyword_checkbox_arry);
            //echo "<pre>";print_r($langauges_checkbox);exit;
//            $langauges_checkbox_on = end($langauges_checkbox);
//
//            $remove_last_element_from_langauges_checkbox = array_slice($langauges_checkbox, 0, count($langauges_checkbox) - 1);
            for ($c = 0; $c < count($langauges_checkbox); $c++) {

                if ($lang == 'de') {
                    $checkbox_value[] = $langauges_checkbox[$c]['de'];
                } elseif ($lang == 'fr') {
                    $checkbox_value[] = $langauges_checkbox[$c]['fr'];
                } else {
                    $checkbox_value[] = $langauges_checkbox[$c]['en'];
                }
            }
            $days_value = implode(", ", $checkbox_value);
        } else {
            $checkbox_value = array();
            $days_value = "";
        }
        //$monthly;
        //echo $days_value;exit;


        for ($i = 0; $i < count($langauges); $i++) {
            if ($lang == 'de') {
                $sending_d_translate[] = $langauges[$i]['de'];
            } elseif ($lang == 'fr') {
                $sending_d_translate[] = $langauges[$i]['fr'];
            } else {
                $sending_d_translate[] = $langauges[$i]['en'];
            }
        }
//        echo "<pre>";
//        print_r($sending_d_translate);
//        exit;
        $email_pre_keyword = end($sending_d_translate);

//        if ($to == 'to_email') {
//            $email_pre_keyword = "to";
//        } else {
//            $email_pre_keyword = $to;
//        }
//        echo $email_pre_keyword;
//        exit;
        if ($sending_d_translate[0] == 'Daily' || $sending_d_translate[0] == _clang(DAILY)) {
            $end_in_value = "";
            $end_in_value2 = "";

            if ($end_in_length == 13 || $end_in_length == 21) {
                if (!empty($ends_in_t[3])) {

                    $ending_value = $ends_in_t[3];
                } else {

                    $ending_value = "";
                }
                $end_in_value .=$sending_d_translate[5];
            } elseif ($end_in_length >= 26) {
                if (!empty($ends_in_t[3])) {

                    $ending_value = $ends_in_t[3];
                } else {
                    $ending_value = 1;
                }
                $end_in_value .=$sending_d_translate[5];
                $end_in_value2 = $sending_d_translate[6];
            }
            //echo "<pre>"; print_r($sending_d_translate);exit;
            echo $main_translate_str = "{$sending_d_translate[0]} {$sending_d_translate[1]} {$every_d_t[2]} {$sending_d_translate[2]} {$sending_d_translate[3]} {$at_d_t[2]} {$email_pre_keyword} {$sending_to_email_d_t} {$sending_d_translate[4]} {$end_in_value} {$ending_value} {$end_in_value2}";
            //exit;
        } elseif ($sending_d_translate[0] == 'Weekly' || $sending_d_translate[0] == _clang(WEEKLY)) {

            $end = "";
            $end2 = "";

            if ($end_in_length == 13 || $end_in_length == 21) {
                if (!empty($ends_in_t[3])) {
                    $ending_value = $ends_in_t[3];
                } else {
                    $ending_value = "";
                }
                $end .=@$sending_d_translate[5];
            } elseif ($end_in_length >= 26) {
                if (!empty($ends_in_t[3])) {
                    $ending_value = $ends_in_t[3];
                } else {
                    $ending_value = 1;
                }
                $end .=@$sending_d_translate[5];
                $end2 = @$sending_d_translate[6];
            }

            $sending_d = @$sending_d_translate[0];
            $every_d = @$sending_d_translate[1];
            $every_d_one = @$sending_d_translate[2];
            $at_d = @$sending_d_translate[3];
            $ending = @$sending_d_translate[4];


            //$main_translate_str .= "{$every_d} {$every_d_t[2]} {$every_d_one} {$on} {$days_value} {$at_d} {$at_d_t[2]}{$_POST['sending_to_email_d_t']} {$ending} {$end} {$ending_value} {$end2}";
            echo $main_translate_str = "{$sending_d} {$every_d} {$every_d_t[2]} {$every_d_one}  {$on} {$days_value} {$at_d} {$at_d_t[2]} {$email_pre_keyword} {$sending_to_email_d_t} {$ending} {$end} {$ending_value} {$end2}";
        } elseif ($sending_d_translate[0] == 'Monthly' || $sending_d_translate[0] == _clang(MONTHLY)) {

            $month = "'" . $monthly . "'";
            $monthly_value = $this->user_model->translate_languages_perticular_field('en', $month);
            if ($lang == 'de') {
                $monthly_weeks = @$monthly_value[0]['de'];
            } elseif ($lang == 'fr') {
                $monthly_weeks = @$monthly_value[0]['fr'];
            } else {
                $monthly_weeks = @$monthly_value[0]['en'];
            }

            $end = "";
            $end2 = "";
            $day_of_month;
            if ($day_of_month == 'last_day') {
                $last_day = 'Last day';
            } else {
                $last_day = $day_of_month;
            }
            $day_of_month_arry = array("'$last_day'");
            $week_last_day = $this->user_model->get_translate_languages('en', $day_of_month_arry);
            //echo "<pre>";
            //print_r($week_last_day[0]);
            if ($lang == 'de') {
                $last_day_translate = @$week_last_day[0]['de'];
            } elseif ($lang == 'fr') {
                $last_day_translate = @$week_last_day[0]['fr'];
            } else {
                $last_day_translate = @$week_last_day[0]['en'];
            }
            if (!empty($last_day_translate)) {
                $last_days = $last_day_translate;
            } else {
                $last_days = $day_of_month;
            }
            // exit;
            if ($end_in_length == 13 || $end_in_length == 21) {
                if (!empty($ends_in_t[3])) {
                    $ending_value = $ends_in_t[3];
                } else {
                    $ending_value = "";
                }
                $end .=@$sending_d_translate[5];
            } elseif ($end_in_length >= 26) {
                if (!empty($ends_in_t[3])) {
                    $ending_value = $ends_in_t[3];
                } else {
                    $ending_value = 1;
                }
                $end .=@$sending_d_translate[5];
                $end2 = @$sending_d_translate[6];
            }

            $sending_d = @$sending_d_translate[0];
            $every_d = @$sending_d_translate[1];
            $every_d_one = @$sending_d_translate[2];
            $at_d = @$sending_d_translate[3];
            $ending = @$sending_d_translate[4];
            echo $main_translate_str .= "{$sending_d} {$every_d} {$every_d_t[2]} {$every_d_one} {$on} {$last_days} {$monthly_count} {$monthly_weeks}  {$days_value} {$at_d} {$at_d_t[2]} {$email_pre_keyword} {$sending_to_email_d_t} {$ending} {$end} {$ending_value} {$end2}";
        }
        // echo $main_translate_str;
    }

    function popus_ajax_email_delete() {
        $email_id = $_POST['additional_email'];
        $email = $this->user_model->delete_additional_email($email_id);
        if ($email) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

