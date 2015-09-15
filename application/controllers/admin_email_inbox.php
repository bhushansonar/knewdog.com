<?php

class Admin_email_inbox extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'kd2a2a0u1g4/email_inbox';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('newsletter_model');
        $this->load->model('newsletter_clone_model');
        $this->load->model('Imap_model');
        $this->load->model('remove_unsubscribe_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in_admin')) {
            redirect('kd2a2a0u1g4/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {
        $mail = $this->Imap_model->get_mail_count();
        $this->Imap_model->close_imap();
        $data['mail_unread'] = $mail; // Get the imap mail array
        $data['main_content'] = 'kd2a2a0u1g4/email_inbox/inbox';
        $this->load->view('kd2a2a0u1g4/includes/template', $data);
    }

//index

    public function inboxlist() {

        $mailarray = $this->Imap_model->get_inboxlist();
        $this->Imap_model->close_imap();
        $data['mailarray'] = $mailarray;
//        echo "<pre>";
//        print_r($data['mailarray']);
//        exit;
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
//        echo '<pre>';
//        print_r($bodymail);
//        die;
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
        $id = $this->uri->segment(4);
        $raw_email = $this->uri->segment(5);
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
        $mailarray = $this->Imap_model->imap_get_mail_array();
        $body = $this->Imap_model->imap_read_body($id);

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
        /* $unsubscribes = $this->newsletter_model->get_newsletter_by_id($bodymail[0]['newsletter_id']);
          $diaplay_array = array($unsubscribes[0]['unsubscribe_url'],$unsubscribes[0]['unsubscribe_text']);
          $return_html = remove_unsubscribe_list($body, $display_array); */


        $unsubscribes = $this->newsletter_model->get_newsletter_by_id($bodymail[0]['newsletter_id']);
        //echo '<pre>'; print_r($unsubscribes); die;
        $display_array = array();
        $display_array = array($unsubscribes[0]['unsubscribe_url'], $unsubscribes[0]['unsubscribe_text']);
        $return_html = remove_unsubscribe_list($body, $display_array);
        //echo '<pre>'; print_r($return_html);
        //echo "count->".count($return_html['count']);
        //die;
        //Ens removing Unsubscribe.
        //echo $body; die;
        //echo '<pre>'; print_r($mailarray); die;
        if (count($return_html['count']) > 0) {
            $mailarray = json_decode(json_encode($mailarray), true);
            for ($i = 0; $i < count($mailarray); $i++) {
                if (in_array($id, $mailarray[$i])) {
                    $subject = $mailarray[$i]['subject'];
                    $from = $mailarray[$i]['from'][0]['mailbox'] . "@" . $mailarray[$i]['from'][0]['host'];
                    $fromname = $mailarray[$i]['from'][0]['personal'];
                }
            }
            //echo $subject."<br>".$from;
            //echo $body; die;
            $sn_id = $this->functions->get_newsletter_lsn_id();
            $data_to_store = array(
                'newsletter_rand_id' => $bodymail[0]['newsletter_rand_id'],
                'sn' => $bodymail[0]['newsletter_rand_id'] . $sn_id,
                'newsletter_relation' => 'child',
                'newsletter_name' => $fromname,
                'headline' => $subject,
                'description' => $return_html['html'],
                'author_name' => $fromname,
                'email' => $from,
                'last_updated_date' => date("Y-m-d H:i:s"),
                'added_date' => date("Y-m-d H:i:s"),
            );
            //if the insert has returned true then we show the flash message
            if ($this->newsletter_model->store_newsletter($data_to_store)) {
                $this->Imap_model->imap_delete_mail($id);
                $data['flash_message'] = TRUE;
                //$this->session->set_flashdata('flash_message', 'add');
                $this->Imap_model->close_imap();
                //redirect('kd2a2a0u1g4/emailinbox/inboxlist');
                $this->session->set_userdata('flash_message', 'add');
                $this->session->set_userdata('unsubscribe_count', count($return_html['count']));
                redirect('kd2a2a0u1g4/newsletter/');
            } else {

            }
        } else {
            $this->session->set_flashdata('flash_message', 'not_process');
            redirect('kd2a2a0u1g4/emailinbox/body/' . $id . "/" . $raw_email);
        }
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

    public function delete_mail() {
        $id = $this->uri->segment(4);
        $raw_email = $this->uri->segment(5);
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
        $mailarray = $this->Imap_model->imap_get_mail_array();
        $body = $this->Imap_model->imap_read_body($id);


        $mailarray = json_decode(json_encode($mailarray), true);
        for ($i = 0; $i < count($mailarray); $i++) {
            if (in_array($id, $mailarray[$i])) {
                $subject = $mailarray[$i]['subject'];
                $from = $mailarray[$i]['from'][0]['mailbox'] . "@" . $mailarray[$i]['from'][0]['host'];
                $fromname = $mailarray[$i]['from'][0]['personal'];
            }
        }
        //echo $subject."<br>".$from;
        //echo $body; die;
        $this->Imap_model->imap_delete_mail($id);
        $data['flash_message'] = TRUE;
        //$this->session->set_flashdata('flash_message', 'add');
        $this->Imap_model->close_imap();



        $this->session->set_flashdata('flash_message', 'delete');
        redirect('kd2a2a0u1g4/emailinbox/inboxlist');
    }

}

