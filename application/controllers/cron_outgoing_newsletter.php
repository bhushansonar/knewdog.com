<?php

class Cron_outgoing_newsletter extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = '';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('newsletter_model');
        $this->load->model('user_model');
        $this->load->model('schedule_model');
        $this->load->model('subscribe_model');
        $this->load->model('subscribe_sent_data_model');
        $this->load->model('time_zone_model');
        $this->load->model('outgoing_email_model');
        $this->load->model('outgoing_email_yesterday_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in_admin')) {
            //redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

    }

    /**
     * Sending out newsletter
     * @return void
     */
    public function process() {
        date_default_timezone_set('UTC');
        $start_day_hour = date("H:i");
        //$start = strtotime(date("00:00")); //1402876800
        //$start_one = strtotime(date("00:01")); //1402876860
        echo $start_day_hour;
        if ($start_day_hour == '00:00') {
            //echo "comming";
            $this->db->empty_table('outgoing_email_yesterday');
            $result_array = $this->subscribe_model->get_subscribed_for_out_going_free_NS();
            //echo 'First array-><pre>';
            //print_r($result_array);
            for ($i = 0; $i < count($result_array); $i++) {
                /* if(!empty($result_array[$i]['time_zone'])){
                  $user_time_zone = $this->time_zone_model->get_time_zone_by_field(array("time_zone_id"),array($result_array[$i]['time_zone']));
                  date_default_timezone_set($user_time_zone[0]['time_zone']);
                  //echo date_default_timezone_get();
                  } */
                $user_id = $result_array[$i]['user_id'];
                $primary_email = $result_array[$i]['primary_email'];
                $newsletter_id = $result_array[$i]['newsletter_id'];
                $newsletter_rand_id = $result_array[$i]['newsletter_rand_id'];
                $newsletter_issues = $this->newsletter_model->get_newsletter_child_issues_for_send(array('newsletter_rand_id'), array($newsletter_rand_id), array(), array(), 'yesterday', '', '', '');
                if (count($newsletter_issues) > 0) {
                    //count($newsletter_issues)
                    //echo "hi";
                    $NL = 1;
                    for ($n = 0; $n < count($newsletter_issues); $n++) {
                        // echo "come";
                        //send 5 newsletter only
                        sending_subscribed_free_function($result_array, $i, $newsletter_issues, $n);
                        /*

                          echo "<br/>send mail to =>".$primary_email;
                          echo "<br/> issue_id=>".$newsletter_issues[$n]['newsletter_id']."<br/>";
                          $this->load->helper('email');
                          //load email library
                          $this->load->library('email');
                          $email = $primary_email;
                          $content = get_random_adds($user_id)."<br/>".$newsletter_issues[$n]['description'];
                          $subject = $newsletter_issues[$n]['headline'];
                          //read parameters from $_POST using input class
                          // check is email addrress valid or no
                          if (valid_email($email)) {
                          // compose email
                          $get_admin_detail =
                          get_admin_detail(); //common helper function for admin detail
                          $this->email->from($get_admin_detail['email'],$get_admin_detail['name']);
                          $this->email->to($email);
                          $this->email->set_mailtype("html");
                          $this->email->subject($subject);
                          $this->email->message($content);
                          if ($this->email->send()) {
                          echo "Mail sent.";

                          }else{
                          echo "Mail not sent!";
                          }

                          } */

                        if ($NL == 4) {
                            return;
                        }
                        $NL++;
                    }//NL loop end
                }
            } //result array loop end
            //exit;
            $unique_mail_1 = $this->outgoing_email_yesterday_model->get_outgoing_email_yesterday_unique();
            for ($u = 0; $u < count($unique_mail_1); $u++) {
                //$unique_mail_data = $this->outgoing_email_model->get_outgoing_email_by_field_value_array(array('email'),array($unique_mail[$u]['email']));
                send_mail_attachment($unique_mail_1[$u]['email'], $unique_mail_1[$u]['type_of_member'], true);
            }
            echo '<pre> First->';
            print_r($unique_mail_1);
        }//start day hour
        //echo '<pre>'; print_r($result_array);
        if ($start_day_hour == '00:00') {
            $this->db->empty_table('outgoing_email_yesterday');
            $result_array_2 = $this->subscribe_model->get_subscribed_for_out_going_notfree_null_NS();
            //echo '<pre>'; print_r($result_array_2);exit;
            for ($i = 0; $i < count($result_array_2); $i++) {
                /* if(!empty($result_array_2[$i]['time_zone'])){
                  $user_time_zone = $this->time_zone_model->get_time_zone_by_field(array("time_zone_id"),array($result_array_2[$i]['time_zone']));
                  date_default_timezone_set($user_time_zone[0]['time_zone']);
                  //echo date_default_timezone_get();
                  } */
                $user_id = $result_array_2[$i]['user_id'];
                $primary_email = $result_array_2[$i]['primary_email'];
                $newsletter_id = $result_array_2[$i]['newsletter_id'];
                $newsletter_rand_id = $result_array_2[$i]['newsletter_rand_id'];
                $newsletter_issues = $this->newsletter_model->get_newsletter_child_issues_for_send(array('newsletter_rand_id'), array($newsletter_rand_id), array(), array(), 'yesterday', '', '', '');
                //echo '<pre>'; print_r($newsletter_issues);
                if (count($newsletter_issues) > 0) {
                    //count($newsletter_issues)
                    $NL = 1;
                    for ($n = 0; $n < count($newsletter_issues); $n++) {//send 99 newsletter only
                        sending_subscribed_free_function($result_array_2, $i, $newsletter_issues, $n);
                        /* echo "<br/>send mail to =>".$primary_email;
                          echo "<br/> issue_id=>".$newsletter_issues[$n]['newsletter_id']."<br/>";
                          $this->load->helper('email');
                          //load email library
                          $this->load->library('email');
                          $email = $primary_email;
                          $content = get_random_adds($user_id)."<br/>".$newsletter_issues[$n]['description'];
                          $subject = $newsletter_issues[$n]['headline'];
                          //read parameters from $_POST using input class
                          // check is email addrress valid or no
                          if (valid_email($email)) {
                          // compose email
                          $get_admin_detail =
                          get_admin_detail(); //common helper function for admin detail
                          $this->email->from($get_admin_detail['email'],$get_admin_detail['name']);
                          $this->email->to($email);
                          $this->email->set_mailtype("html");
                          $this->email->subject($subject);
                          $this->email->message($content);
                          if ($this->email->send()) {
                          echo "Mail sent.";

                          }else{
                          echo "Mail not sent!";
                          }

                          } */
                        if ($NL == 99) {
                            return;
                        }

                        $NL++;
                    } //NL issues loop end
                }
            } //result array loop end

            $unique_mail_2 = $this->outgoing_email_yesterday_model->get_outgoing_email_yesterday_unique();
            for ($u = 0; $u < count($unique_mail_2); $u++) {
                //$unique_mail_data = $this->outgoing_email_model->get_outgoing_email_by_field_value_array(array('email'),array($unique_mail[$u]['email']));
                send_mail_attachment($unique_mail_2[$u]['email'], $unique_mail_2[$u]['type_of_member'], true);
            }
            echo '<pre> second->';
            print_r($unique_mail_2);
        }
//echo "dfdaf";exit;
        //Run every day every hours..
        $result_array_3 = $this->subscribe_model->get_subscribed_for_out_going_notfree_notnull_NS();
        echo '<pre>';
        print_r($result_array_3);
        $uniq_mail_cron = array();
        $this->db->empty_table('outgoing_email');
        for ($i = 0; $i < count($result_array_3); $i++) {//loop subscription to sent
            $user_id = $result_array_3[$i]['user_id'];
            $primary_email = $result_array_3[$i]['primary_email'];
            $newsletter_id = $result_array_3[$i]['newsletter_id'];
            $newsletter_rand_id = $result_array_3[$i]['newsletter_rand_id'];
            //$sn_of_last_newsletter = $result_array_3[$i]['sn_of_last_newsletter'];
            $sn_of_last_newsletter = $result_array_3[$i]['last_sn'];
            $subscribe_id = $result_array_3[$i]['subscribe_id'];

            //
            $sending_to_email = $result_array_3[$i]['sending_to_email'];
            $sending = $result_array_3[$i]['sending'];
            $every = $result_array_3[$i]['every'];
            $weeks_on = $result_array_3[$i]['weeks_on'];

            $monthly_on = $result_array_3[$i]['monthly_on'];
            $day_of_the_month = $result_array_3[$i]['day_of_the_month'];
            $monthly_weekday_count = $result_array_3[$i]['monthly_weekday_count'];
            $monthly_weekday_day = $result_array_3[$i]['monthly_weekday_day'];

            $at = $result_array_3[$i]['at'];
            $ends = $result_array_3[$i]['ends'];
            $ends_after = $result_array_3[$i]['ends_after'];
            $ends_on = $result_array_3[$i]['ends_on'];
            //
            //if(!empty($sn_of_last_newsletter)){
            //$newsletter_issues = $this->newsletter_model->get_newsletter_child_issues_for_send(array('newsletter_rand_id'),array($newsletter_rand_id),array(),array(),'yesterday');
            //$newsletter_data1 = $this->newsletter_model->get_newsletter_by_id($newsletter_id);
            $result_array_3[$i]['find_last_ns'] = true;
            if ($sn_of_last_newsletter == "") {
                $newsletter_data = $this->newsletter_model->just_get_last_sn_id($newsletter_rand_id);
                //echo "om->".$i;
                @$sn_of_last_newsletter = $newsletter_data[0]['sn'];
                $result_array_3[$i]['find_last_ns'] = false;
            }

            //$update_array = array(
            //"sn_of_last_newsletter" => $newsletter_data[0]['sn']
            //);
            //$this->user_model->update_user($user_id,$update_array);

            $get_last_ns_id = $this->newsletter_model->get_newsletter_by_field("sn", $sn_of_last_newsletter);
            //echo "last_sn-> ".$i." ".$get_last_ns_id[0]['newsletter_id'];
            //echo "last_numbne-><pre>".print_r($get_last_ns_id);
            //$raw_sn = explode("N",$sn_of_last_newsletter);
            //echo "raw_sn->". $raw_sn[1];
            //echo "<br/>test->".strtotime('2014-05-13 11:31:32');
            //echo "check->".check_ends_on($result_array_3[$i]);
            //echo "end_on->".check_ends_on($result_array_3[$i]);
            if (!empty($result_array_3[$i]['time_zone'])) {
                $user_time_zone = $this->time_zone_model->get_time_zone_by_field(array("time_zone_id"), array($result_array_3[$i]['time_zone']));
                date_default_timezone_set($user_time_zone[0]['time_zone']);
                //echo date_default_timezone_get();
            }
            $start_at = date("H:i", strtotime($at . ":00:00"));
            echo "<br/>current time->" . $current_time = date("H:i");
            echo "<br/>start at->" . $start_at;
            //die;
            if ($start_at == $current_time) {
                if (check_ends_on($result_array_3[$i]) == true) {
                    //echo "<br/>sendig->". $sending;
                    if ($sending == 'Daily') {

                        //$get_sent_subscribed_today = $this->subscribe_sent_data_model->check_subscribe_sent_in_day($subscribe_id,$every);
//								if($get_sent_subscribed_today == true){
//								//if(count($get_sent_subscribed_today) == 0){
//
//									$uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id,$result_array_3,$i,$sending);
//
//									}else{
//
//									echo "go else Already mail sent today<br/>";
//								}
                        if ($every != 'last_day') {
                            $get_sent_subscribed_today = $this->subscribe_sent_data_model->check_subscribe_sent_in_day($subscribe_id, $every);
                            if ($get_sent_subscribed_today == true) {
                                //if(count($get_sent_subscribed_today) == 0){

                                $uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id, $result_array_3, $i, $sending);
                            } else {

                                echo "go else Already mail sent today<br/>";
                            }
                        } else {

                            $a_date = date("Y-m-d");
                            //echo date("Y-m-t", strtotime($a_date));
                            $lastdate = $days_ago = date("Y-m-t", strtotime($a_date));
                            echo "last day->" . $lastdate;
                            if ($a_date == $lastdate) {
                                //$get_sent_subscribed_today = $this->subscribe_sent_data_model->check_subscribe_sent_in_day($subscribe_id,$every);
                                $uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id, $result_array_3, $i, $sending);
                            } else {
                                echo "go else last day / mail sent today<br/>";
                            }
                        }
                    } else if ($sending == 'Weekly') {
                        $currunt_day = date("l");
                        echo "current day->" . $currunt_day;
                        $weeks_on_array = explode(",", $weeks_on);
                        //echo '<pre>';print_r($weeks_on_array);
                        if (in_array($currunt_day, $weeks_on_array)) {
                            $get_sent_subscribed_weekly = $this->subscribe_sent_data_model->check_subscribe_sent_in_weekly($subscribe_id, $currunt_day, $every);
                            if ($get_sent_subscribed_weekly == true) {
                                $uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id, $result_array_3, $i, $sending);
                            } else {
                                echo "Already mail sent in this week!<br/>";
                            }
                        }
                    } else if ($sending == 'Monthly') {
                        $currunt_day = date("l");
                        $currunt_date = date("d");
                        echo "current date->" . $currunt_date;
                        //$weeks_on_array = explode(",",$weeks_on);
                        if ($monthly_on == 'day_of_the_month') {

                            if ($currunt_date == $day_of_the_month) {
                                $get_sent_subscribed_monthly = $this->subscribe_sent_data_model->check_subscribe_sent_in_monthly($subscribe_id, $currunt_day, $every, $result_array_3, $i);
                                if ($get_sent_subscribed_monthly == true) {
                                    $uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id, $result_array_3, $i, $sending);
                                } else {
                                    echo "Already mail sent in this Month! cron<br/>";
                                }
                            } else {
                                echo "Other Day";
                            }
                        } else {
                            echo "week no->" . $week_number = week_of_month(strtotime("today"));
                            echo "<br/>week_day->" . $currunt_day;
                            if ($week_number == $monthly_weekday_count) {
                                $get_sent_subscribed_monthly = $this->subscribe_sent_data_model->check_subscribe_sent_in_monthly($subscribe_id, $currunt_day, $every, $result_array_3, $i);
                                if ($get_sent_subscribed_monthly == true) {
                                    $uniq_mail_cron[] = sending_subscribed_function($get_last_ns_id, $result_array_3, $i, $sending);
                                } else {
                                    echo "Already mail sent in this Month! cron<br/>";
                                }
                            } else {
                                echo "Other Day 2";
                            }
                        }
                    }
                    /* else if($sending == 'Yearly'){
                      $currunt_day = date("l");
                      $get_sent_subscribed_yearly = $this->subscribe_sent_data_model->check_subscribe_sent_in_yearly($subscribe_id,$currunt_day);
                      if(count($get_sent_subscribed_yearly) == 0){
                      sending_subscribed_function($get_last_ns_id,$result_array_3,$i,$sending);
                      }else{
                      echo "Already mail sent in this Year!<br/>";
                      }

                      } */
                    //$uniq_mail_cron
                }
            } // check AT timing
            //}//sn last newsletter check ends
        } //check ends loop
        //sending mail attachments
        $unique_mail = $this->outgoing_email_model->get_outgoing_email_unique();
        for ($u = 0; $u < count($unique_mail); $u++) {
            //$unique_mail_data = $this->outgoing_email_model->get_outgoing_email_by_field_value_array(array('email'),array($unique_mail[$u]['email']));
            send_mail_attachment($unique_mail[$u]['email'], $unique_mail[$u]['type_of_member']);
        }
        echo '<pre>Third->';
        print_r($unique_mail);
    }

}

