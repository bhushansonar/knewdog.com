<?php

class Cron_email_issues extends CI_Controller {
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
        $this->load->model('newsletter_clone_model');
        $this->load->model('administration_folder_model');
        $this->load->model('Imap_model');
        $this->load->model('remove_unsubscribe_model');
        $this->load->model('blog_model');
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
        $mail = $this->Imap_model->get_mail_count();
        //echo '<pre>'; print_r($mailarray); die;
        $this->Imap_model->close_imap();
        $data['mail_unread'] = $mail; // Get the imap mail array
        $data['main_content'] = 'kd2a2a0u1g4/email_inbox/inbox';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function inboxlist() {

        $mailarray = $this->Imap_model->get_inboxlist();
        echo '<pre>';
        print_r($mailarray);
        die;
        $this->Imap_model->close_imap();
        $data['mailarray'] = $mailarray;
        $data['main_content'] = 'kd2a2a0u1g4/email_inbox/inboxlist';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function body() {
        //product id 
        $id = $this->uri->segment(4);
        $email = base64url_decode($this->uri->segment(5));
        $bodymail = $this->Imap_model->get_newsletter_email_by_email($email);
        $this->load->config('imap');
        //echo '<pre>'; print_r($bodymail); die;
        $config['imap_server'] = $this->config->item('mailbox');
        $config['imap_user'] = $bodymail[0]['email'];
        $config['imap_pass'] = decrypt($bodymail[0]['password']);
        $config['imap_folder'] = 'INBOX';
        // Load the IMAP Library
        $this->Imap_model->imap($config);
        $body = $this->Imap_model->imap_read_body($id);
        //echo $body; die;	
        $this->Imap_model->close_imap();
        $data['email'] = $bodymail[0]['email'];
        $data['body'] = $body;
        $data['main_content'] = 'kd2a2a0u1g4/email_inbox/body';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//

    public function process() {

        //echo "stoped process"; 
        //die; 
        $mailarray = $this->Imap_model->get_inboxlist();
        //echo "<pre>";print_r($mailarray);exit;
        $newarray = array();
        for ($c = 0; $c < count($mailarray); $c++) {
            $mraray = $mailarray[$c];
            //echo ''print_r($mraray); die;					
            for ($m = 0; $m < count($mraray); $m++) {
                $newarray[] = $mraray[$m];
            }
        }
        ?>

        <?php

        $array = json_decode(json_encode($newarray), true);
        /* function sortFunction( $a, $b ) {
          return strtotime($a['MailDate']) - strtotime($b['MailDate']);
          }
         */ usort($array, "sortFunction");   //Here You can use asort($data,"sortFunction")
        $rarray = array_reverse($array);
//        echo '<pre>';
//        print_r($rarray);
//        exit;
        //echo "count->".count($rarray);
        $rarray = json_decode(json_encode($rarray), true);
        for ($r = 0; $r < count($rarray); $r++) {

            $id = trim($rarray[$r]['Msgno']); //$this->uri->segment(4);
            $raw_email = base64url_encode(decode_imap_text($rarray[$r]['to'][0]['mailbox']) . "@" . decode_imap_text($rarray[$r]['to'][0]['host'])); //base64url_encode($rarray[$r]['toaddress']); //$this->uri->segment(5);
            //$email = $rarray[$r]['toaddress'];
            $email = decode_imap_text($rarray[$r]['to'][0]['mailbox']) . "@" . decode_imap_text($rarray[$r]['to'][0]['host']); //$rarray[$r]['to'][0]->['mailbox']."@".$rarray[$r]['to'][0]->['host'];

            $bodymail = $this->Imap_model->get_newsletter_email_by_email($email);
            //echo "<pre>";print_r($bodymail);exit;
            $this->load->config('imap');
            //echo '<pre>'; print_r($bodymail); die;



            $config['imap_server'] = $this->config->item('mailbox');
            $config['imap_user'] = $bodymail[0]['email'];
            $config['imap_pass'] = decrypt($bodymail[0]['password']);
            $config['imap_folder'] = 'INBOX';
            // Load the IMAP Library
            $this->Imap_model->imap($config);
            $mailarray = $this->Imap_model->imap_get_mail_array();
            $body = $this->Imap_model->imap_read_body($id);

            $mailarray = json_decode(json_encode($mailarray), true);
//            echo '<pre>';
//            print_r($mailarray);
            echo "body->" . $body;

            for ($i = 0; $i < count($mailarray); $i++) {
                if (in_array($id, $mailarray[$i])) {
                    $subject = decode_imap_text($mailarray[$i]['subject']);
                    $from = decode_imap_text($mailarray[$i]['from'][0]['mailbox']) . "@" . decode_imap_text($mailarray[$i]['from'][0]['host']);
                    $fromname = decode_imap_text($mailarray[$i]['from'][0]['personal']);
                    if ($fromname == "") {
                        $fromname = decode_imap_text($mailarray[$i]['from'][0]['mailbox']);
                    }
                }
                //echo "<br>->decode->".$subject = str_replace("_"," ", mb_decode_mimeheader($subject));;
            }
            //die;
            //die;
            //Start Removing Unsubscribe.
            /* $unsubscribe_text = $this->remove_unsubscribe_model->get_remove_unsubscribe_text();
              //echo '<pre>'; print_r($unsubscribe_text);
              for($i=0;$i<count($unsubscribe_text);$i++){
              $unsubscribe_text_array[] = $unsubscribe_text[$i]['unsubscribe_text'];
              }
              $unsubscribe_url = $this->remove_unsubscribe_model->get_remove_unsubscribe_url();
              //echo '<pre>'; print_r($unsubscribe_url);
              for($i=0;$i<count($unsubscribe_url);$i++){
              $unsubscribe_url_array[] = $unsubscribe_url[$i]['unsubscribe_url'];
              }
              $display_array = array_merge($unsubscribe_url_array,$unsubscribe_text_array); */
//            echo '<pre>';
//            print_r($bodymail);
            $check_subscribtion_email = check_subscribtion_email($from, $fromname);

            if ($check_subscribtion_email == true) {
                $check_blacklist_index = increase_blacklist_index($subject, $bodymail[0]['newsletter_rand_id']);
                //echo "check_blacklist_index->". $check_blacklist_index;
                if ($check_blacklist_index == true) {
                    $unsubscribes = $this->newsletter_model->get_newsletter_by_id($bodymail[0]['newsletter_id']);
                    //echo '<pre>'; print_r($unsubscribes); die;
                    $display_array = array();
                    $display_array = array($unsubscribes[0]['unsubscribe_url'], $unsubscribes[0]['unsubscribe_text']);
                    $return_html = remove_unsubscribe_list($body, $display_array);
                    if (count($return_html['count']) > 0) {

                        //echo $subject."<br>".$from;	
                        echo "<br/>in news->" . $body;


                        $sn_id = $this->functions->get_newsletter_lsn_id();
                        $data_to_store = array(
                            'newsletter_rand_id' => $bodymail[0]['newsletter_rand_id'],
                            'sn' => $bodymail[0]['newsletter_rand_id'] . $sn_id,
                            'newsletter_relation' => 'child',
                            'newsletter_name' => $fromname,
                            'headline' => $subject,
                            'newsletter_email' => $from,
                            'description' => $return_html['html'], //$body,//$return_html['html'],
                            'newsletter_sender_name' => $fromname,
                            'author_name' => $fromname,
                            'email' => $from,
                            'last_updated_date' => date("Y-m-d H:i:s"),
                            'added_date' => date("Y-m-d H:i:s"),
                        );
                        //echo '<pre>'; print_r($data_to_store);
                        //if the insert has returned true then we show the flash message
                        $this->newsletter_model->store_newsletter($data_to_store);
                        $this->Imap_model->imap_delete_mail($id);
                        //$data['flash_message'] = TRUE;
                        //$this->session->set_flashdata('flash_message', 'add');
                        $this->Imap_model->close_imap();
                        //redirect('kd2a2a0u1g4/emailinbox/inboxlist');
                        //$this->session->set_userdata('flash_message', 'add');
                        //$this->session->set_userdata('unsubscribe_count', count($return_html['count']));
                        //redirect('kd2a2a0u1g4/newsletter/');
                    } else {

                        $sn_id = $this->functions->get_newsletter_lsn_id();
                        $data_to_store = array(
                            'newsletter_rand_id' => $bodymail[0]['newsletter_rand_id'],
                            'sn' => $bodymail[0]['newsletter_rand_id'] . $sn_id,
                            'newsletter_relation' => 'child',
                            'newsletter_name' => $fromname,
                            'headline' => $subject,
                            'newsletter_email' => $from,
                            'description' => $return_html['html'], //$body,//$return_html['html'],
                            'newsletter_sender_name' => $fromname,
                            'author_name' => $fromname,
                            'email' => $from,
                            'last_updated_date' => date("Y-m-d H:i:s"),
                            'added_date' => date("Y-m-d H:i:s"),
                        );
                        //echo '<pre>'; print_r($data_to_store);
                        //if the insert has returned true then we show the flash message
                        $this->newsletter_model->store_newsletter($data_to_store);
                        $last_newsletter_id = $this->db->insert_id();

                        $this->newsletter_clone_model->insert_one_row_by_id($last_newsletter_id);
                        $this->newsletter_model->delete_newsletter($last_newsletter_id);

                        $this->Imap_model->imap_delete_mail($id);
                        //$data['flash_message'] = TRUE;
                        //$this->session->set_flashdata('flash_message', 'add');
                        $this->Imap_model->close_imap();
                    }
                } else {
                    echo "<br/>in mail delete";
                    //Delete mail as its spam
                    $this->Imap_model->imap_delete_mail($id);
                    //$data['flash_message'] = TRUE;
                    //$this->session->set_flashdata('flash_message', 'add');
                    $this->Imap_model->close_imap();
                }
            } else {//$check_subscribtion_email flase clause move to administration folder
                $sn_id = $this->functions->get_newsletter_lsn_id();
                $data_to_store = array(
                    'newsletter_rand_id' => $bodymail[0]['newsletter_rand_id'],
                    'sn' => $bodymail[0]['newsletter_rand_id'] . $sn_id,
                    'newsletter_relation' => 'child',
                    'newsletter_name' => $fromname,
                    'headline' => $subject,
                    'newsletter_email' => $from,
                    'description' => $body, //$return_html['html'],//$body,//$return_html['html'],
                    'author_name' => $fromname,
                    'newsletter_sender_name' => $fromname,
                    'email' => $from,
                    'last_updated_date' => date("Y-m-d H:i:s"),
                    'added_date' => date("Y-m-d H:i:s"),
                );
                //echo '<pre>'; print_r($data_to_store);
                //if the insert has returned true then we show the flash message
                $this->newsletter_model->store_newsletter($data_to_store);
                $last_newsletter_id = $this->db->insert_id();

                $this->administration_folder_model->insert_one_row_by_id($last_newsletter_id);
                $this->newsletter_model->delete_newsletter($last_newsletter_id);

                $this->Imap_model->imap_delete_mail($id);
                //$data['flash_message'] = TRUE;
                //$this->session->set_flashdata('flash_message', 'add');
                $this->Imap_model->close_imap();
            }
        }

        //**
        /* Blog schedule logic Start */
        $current_time_for_blog = strtotime(date("Y-m-d H:i:s"));
        $field_blog = array("set_schedule", "schedule_status", "status");
        $value_blog = array("YES", "Inactive", "Active");
        $get_data = $this->blog_model->get_blog_by_field_array($field_blog, $value_blog);
        //echo '<pre>'; print_r($get_data);
        for ($i = 0; $i < count($get_data); $i++) {
            $blog_update_array = array();
            if ($current_time_for_blog >= strtotime($get_data[$i]['published_date'])) {
                $blog_update_array = array(
                    "schedule_status" => "Active",
                );
                $this->blog_model->update_blog($get_data[$i]['blog_id'], $blog_update_array);
            }
        }
        /*
          //Blog shcedule logic ends */
//bhushan changes 
        //start code of  email reminder confirmation
        $this->load->model('user_model');
        $this->load->model('email_template_model');
        $this->load->model('invoice_model');
        $this->load->helper('email');
        $this->load->library('email');

        $reminder_mail_data = $this->user_model->get_email_reminder();
        //echo "<pre>";print_r($reminder_mail_data);exit;
        $reminder_mail_data_end_of_term = $this->invoice_model->get_email_reminder_for_end_of_term();
        //echo "<pre>";print_r($reminder_mail_data_end_of_term);exit;
        // echo "<pre>";print_r($reminder_mail_data_end_of_term);exit;
        $get_admin_detail = get_admin_detail();
        for ($c = 0; $c < count($reminder_mail_data_end_of_term); $c++) {

            $user_details = $this->user_model->get_username_by_id($reminder_mail_data_end_of_term[$c]['user_id']);
            for ($m = 0; $m < count($user_details); $m++) {

                $username = $user_details[$m]['username'];
                $account_type = $user_details[$m]['type_of_membership'];

                $current_date = date('Y-m-d');
                $reminder_date_end = date('Y-m-d', strtotime('-4 week', strtotime($reminder_mail_data_end_of_term[$c]['date_to'])));

                if ($reminder_mail_data_end_of_term[$c]['date_to'] == $current_date) {
                    if ($reminder_mail_data_end_of_term[$c]['on_that_date'] == "NO") {
                        $mail_data['end_term_msg'] = "Inform you that your account will be downgraded next day automatically 1 day before end of term";
                        $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                        $this->email->to($reminder_mail_data_end_of_term[$i]["email"]);
                        $this->email->set_mailtype("html");
                        $session_lang = $this->session->userdata('language_shortcode');

                        $replace = array(
                            '{end_term_msg}',
                            '{username}',
                            '{account_type}'
                        );
                        $with = array(
                            "{$mail_data['end_term_msg']}",
                            "{$username}",
                            "{$account_type}");

                        $utf = "utf-8";
                        $email_template_content = $this->email_template_model->get_email_template_by_id(16);

                        if (isset($email_template_content[0]['description_' . $session_lang]) && !empty($email_template_content[0]['description_' . $session_lang])) {
                            $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                            $template_content = $email_template_content[0]['description_' . $session_lang];
                            $message = str_replace($replace, $with, $template_content);
                            $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                            $this->email->message($content);
                        } else {
                            $this->email->subject($email_template_content[0]['subject_en']);
                            $template_content = $email_template_content[0]['description_en'];
                            $message = str_replace($replace, $with, $template_content);
                            $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                            $this->email->message($content);
                        }

                        $this->email->send();
                    }
                    $content_data = array('on_that_date' => 'YES');
                    $this->invoice_model->update_flag($reminder_mail_data_end_of_term[$c]["invoice_id"], $content_data);
                }

                if ($reminder_mail_data_end_of_term[$c]['before_four_week'] == "NO" && $current_date == $reminder_date_end) {
                    $mail_data['end_term_date'] = $reminder_mail_data_end_of_term[$c]['date_to'];
                    $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                    $this->email->to($reminder_mail_data_end_of_term[$i]["email"]);
                    $this->email->set_mailtype("html");
                    $session_lang = $this->session->userdata('language_shortcode');
                    $replace = array('{end_term_date},{username},{account_type}');
                    $with = array("{$mail_data['end_term_date']}", "{$username}", "{$account_type}");

                    $utf = "utf-8";
                    $email_template_content = $this->email_template_model->get_email_template_by_id(15);
                    //echo "<pre>";print_r($email_template_content);exit;
                    if (isset($email_template_content[0]['description_' . $session_lang]) && !empty($email_template_content[0]['description_' . $session_lang])) {
                        $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                        $template_content = $email_template_content[0]['description_' . $session_lang];
                        $message = str_replace($replace, $with, $template_content);
                        $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    } else {
                        $this->email->subject($email_template_content[0]['subject_en']);
                        $template_content = $email_template_content[0]['description_en'];
                        $message = str_replace($replace, $with, $template_content);
                        $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    }

                    $this->email->send();
                }
                $content_data = array('before_four_week' => 'YES');
                $this->invoice_model->update_flag($reminder_mail_data_end_of_term[$c]["invoice_id"], $content_data);
            }
        }

        foreach ($reminder_mail_data as $key => $value) {
            $date_content[] = $value['to'];
        }


        $get_users_details = $this->user_model->get_user_by_filed('primary_email', $date_content);

        $current_date = date('Y-m-d');

        for ($i = 0; $i < count($reminder_mail_data); $i++) {
            //echo "<pre>";print_r($reminder_mail_data);
            //date from reminder table 
            $tbl_date = date('Y-m-d', strtotime($reminder_mail_data[$i]["date"]));
            //calculate 4week date
            $reminder_date = date('Y-m-d', strtotime('4 week', strtotime($tbl_date)));

            if ($reminder_date == $current_date) {
                if ($reminder_mail_data[$i]["compare_date"] != $current_date) {

                    $this->email->from($reminder_mail_data[$i]["from"]);
                    $this->email->to($reminder_mail_data[$i]["to"]);
                    $this->email->set_mailtype("html");
                    //$mail_data['url'] = site_url() . 'home/confirm/' . base64url_encode($reminder_mail_data[$i]["to"]);
                    $mail_data['url'] = '<a href="' . site_url() . 'home/confirm/' . base64url_encode($reminder_mail_data[$i]["to"]) . '">www.knewdog.com/confirm</a>';
                    $username = $get_users_details[0]['username'];
                    $subscription_date = $get_users_details[0]['date_of_registration'];
                    $formated_subscription_date = date("jS F, Y", strtotime($subscription_date));
                    $session_lang = $this->session->userdata('language_shortcode');
                    $replace = array('{page_url}', '{subscription_date}', '{username}');
                    $with = array("{$mail_data['url']}", "{$formated_subscription_date}", "{$username}");
                    $utf = "utf-8";

                    $email_template_content = $this->email_template_model->get_email_template_by_id(14);
                    //echo "<pre>";print_r($email_template_content);exit;
                    if (isset($email_template_content[0]['description_' . $session_lang]) && !empty($email_template_content[0]['description_' . $session_lang])) {
                        $this->email->subject($email_template_content[0]['subject_' . $session_lang]);
                        $template_content = $email_template_content[0]['description_' . $session_lang];
                        $message = str_replace($replace, $with, $template_content);

                        $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    } else {
                        $this->email->subject($email_template_content[0]['subject_en']);
                        $template_content = $email_template_content[0]['description_en'];
                        $message = str_replace($replace, $with, $template_content);
                        $content = "<html><meta charset='" . $utf . "'><body><div style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;'>$message</div></body></html>";
                        $this->email->message($content);
                    }

                    $this->email->send();
                    $date_content = array('date' => date('Y-m-d'), 'compare_date' => date('Y-m-d'));
                    $reminder_mail_data = $this->user_model->update_compare_date($reminder_mail_data[$i]["reminder_email_id"], $date_content);
                }
            }
        }//end code email reminder confirmation
    }

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id
        $this->load->model('newsletter_email_model');
        $this->load->model('cpanel_model');
        $id = $this->uri->segment(4);
        $emails = $this->newsletter_email_model->get_newsletter_email_by_newsid($id);
        $l_email = strtolower($emails[0]['newsletter_rand_id']);
        //delete emails

        $cpanel = $this->cpanel_model->get_cpanel('', '', '', '', '', '');
        $url2 = 'http://' . $cpanel[0]['username'] . ':' . decrypt($cpanel[0]['password']) . '@' . $cpanel[0]['site_domain'] . ':2082/frontend/' . $cpanel[0]['site_skin'] . '/mail/realdelpop.html?';
        $url2 .= 'email=' . $l_email . '&domain=' . $u_domain;
        $result2 = file_get_contents($url2);

        $this->newsletter_email_model->delete_newsletter_email_by_newsid($id);
        $this->session->set_userdata('flash_message1', 'mail_delete');
        $this->newsletter_model->delete_newsletter($id);
        $this->session->set_userdata('flash_message', 'delete');
        redirect('kd2a2a0u1g4/newsletter/');
    }

//edit
}
