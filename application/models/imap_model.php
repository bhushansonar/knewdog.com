<?php

/**
 * IMAP Mail Library
 *
 * @package imap
 * @category Libraries
 * @author Keiran Smith
 * @link http://keiran-smith.net
 * @version 1.0
 * @copyright Keiran Smith 2009
 *
 * The IMAP Library Provides access to an IMAP
 * Mail Server over the Codeigniter PHP Framework
 * */
class Imap_model extends CI_Model {

    var $CI;
    var $config;
    var $conn;
    var $headers;

    public function __construct() {
        $this->load->database();
        $this->CI = & get_instance();
    }

    public function imap($config) {
        $this->config = $config;

        $this->conn = @imap_open("{" . $this->config['imap_server'] . "}" . $this->config['imap_folder'], $this->config['imap_user'], $this->config['imap_pass']);

        if (!$this->conn) {
            return $this->imap_get_last_error();
        }
    }

    public function imap_fetch() {

        $emails = imap_search($this->conn, 'ALL');
        if (!count($emails)) {
            return '<p>No e-mails found.</p>';
        } else {
            return $emails;
        }
    }

    public function imap_check() {
        $imap_opj = imap_check($this->conn);
        return $imap_obj;
    }

    public function __imap_count_mail() {
        $this->headers = @imap_headers($this->conn);
        if (!empty($this->headers)) {
            return sizeof($this->headers);
        } else {
            return $this->imap_get_last_error();
        }
    }

//Extra function
    public function getBody($uid, $imap) {
        $body = $this->get_part($imap, $uid, "TEXT/HTML");
// if HTML body is empty, try getting text body
        if ($body == "") {
            $body = $this->get_part($imap, $uid, "TEXT/PLAIN");
        }
        return $body;
    }

    public function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
        if (!$structure) {

            $uid = imap_uid($imap, $uid);
//echo "uid->".$uid."<br>";
//echo "ft_uid=>".FT_UID;
// die;
//error_reporting(0);
            $structure = imap_fetchstructure($imap, $uid, FT_UID);
        }
//echo "<br/>structure-><pre>".print_r($structure)."</pre>";
        if ($structure) {
            if ($mimetype == $this->get_mime_type($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
                $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
                switch ($structure->encoding) {
                    case 3: return imap_base64($text);
                    case 4: return imap_qprint($text);
                    default: return $text;
                }
            }

// multipart
            if ($structure->type == 1) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = "";
                    if ($partNumber) {
                        $prefix = $partNumber . ".";
                    }
                    $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }

    public function get_mime_type($structure) {
        $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

        if ($structure->subtype) {
            return $primaryMimetype[(int) $structure->type] . "/" . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }

//function end
// a function to decode MIME message header extensions and get the text
    public function decode_imap_text($str) {
        $result = '';
        $decode_header = imap_mime_header_decode($str);
        foreach ($decode_header AS $obj) {
            $result .= htmlspecialchars(rtrim($obj->text, "\t"));
        }
        return $result;
    }

    public function imap_unread() {
//$m_gdmy = "20-March-2014";
//$m_search= imap_search ($this->conn, 'UNSEEN');
//If mailbox is empty......Display "No New Messages", else........ You got mail....oh joy
//echo $m_search;
//echo '<pre>'; print_r($m_search);
//echo count($m_search); die;
//$count = (count($m_search) > 0) ? count($m_search) : 0;
        $count = 0;
        if (!$this->conn) {
            echo "Error";
        } else {
            $headers = imap_headers($this->conn);
            foreach ($headers as $mail) {
                $flags = substr($mail, 0, 4);
                $isunr = (strpos($flags, "U") !== false);
                if ($isunr)
                    $count++;
            }
        }
//echo $count; die;
        $this->close_imap();
        return $count;
    }

    public function imap_get_mail_array($email_add = '') {
        /* for($i = 1; $i < $this->__imap_count_mail() + 1; $i++)
          {
          $mailHeader[] = @imap_headerinfo($conn, $i);
          }

          return $mailHeader; */
        $emails = imap_search($this->conn, 'ALL');
//echo "11";
//        echo $emails;
//print_r($emails);exit;
//echo "count=>". count($email123);
//print_r($email123); die;
        if (empty($emails)) {
            $overview[] = 'No e-mails found.';
            return;
        } else { // If we've got some email IDs, sort them from new to old and show them
            rsort($emails);
//            echo "<pre>";
//            print_r($emails);exit;
            foreach ($emails as $key => $email_id) {
                $overview[$key] = imap_headerinfo($this->conn, $email_id);
//
                //$overview[$key]->
                if (count(get_object_vars($overview[$key])) > 0) {
                    //echo "got here";
                    // $o = new stdClass;
                    // $o->email_id = $email_id;
                    @array_push($overview[$key]->to, $email_add);
                }
//             }
//$overview[]['to_mail'] = $email_id;
//$fromaddr = $header->from[0]->mailbox . "@" . $header->from[0]->host;
// Fetch the email's overview and show subject, from and date.
//$overview[] = imap_fetch_overview($this->conn,$email_id,0);
//echo "seen->".$overview[0]->seen."<br/>";
//$setcount = (($overview[0]->seen == 1) ? 0 : 1);
//$count += $setcount;

                /* ?>
                  <a href="body.php?email_id= <?php echo $email_id;?>">

                  <div class="email_item clearfix <?php echo $overview[0]->seen?'read':'unread'?>"> <?php // add a different class for seperating read and unread e-mails ?>
                  <span class="subject" title="<?php echo decode_imap_text($overview[0]->subject)?>"><?php echo decode_imap_text($overview[0]->subject)?></span>
                  <span class="from" title="<?php echo decode_imap_text($overview[0]->from)?>"><?php echo decode_imap_text($overview[0]->from)?></span>
                  <span class="date"><?php echo $overview[0]->date?></span>
                  <?php $message = getBody($email_id,$stream);?>
                  <div class="body"><?php //echo $message;?></div>
                  </div>
                  </a>
                  <?php */
            }
//            echo "enter";
//           echo "<pre>";print_r($overview);
//           exit;
//            echo "after";
            return $overview;
        }
    }

    public function imap_send_mail($to, $subject, $message, $additional_headers = NULL, $cc = NULL, $bcc = NULL, $rpath = NULL) {
        if (@imap_mail($to, $subject, $message, $additional_headers = NULL, $cc = NULL, $bcc = NULL, $rpath = NULL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function imap_read_mail($mail_id) {
        $mail_header = imap_header($this->conn, $mail_id);
        $mail_body = imap_body($this->conn, $mail_id);

        foreach ($mail_header as $mail_head) {
            $mail[] = $mail_head;
        }

        $mail['body'] = $mail_body;

        return $mail;
    }

    public function imap_read_body($mail_id) {
// $mail_body = imap_body($this->conn, $mail_id);
        $message = $this->getBody($mail_id, $this->conn);
        return $message;
    }

    public function imap_delete_mail($mail_id) {
        if (@imap_delete($this->conn, $mail_id)) {
            @imap_expunge($this->conn);
            return TRUE;
        } else {
            return $this->imap_get_last_error();
        }
    }

    public function imap_get_last_error() {
        $error = imap_last_error($this->conn);
        if (!empty($error)) {
            return $error;
        } else {
            return NULL;
        }
    }

    public function close_imap() {
        @imap_close($this->conn);
    }

//Database Class functions start //

    public function get_newsletter_email_by_id($id) {
        $this->db->select('*');
        $this->db->from('newsletter_email');
        $this->db->where('newsletter_email_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_newsletter_email_by_email($email) {
        $this->db->select('*');
        $this->db->from('newsletter_email');
        $this->db->where('email', $email);
        $query = $this->db->get();
//echo "<pre>";print_r($query->result_array());exit;
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    /**
     * Fetch newsletter_email data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_newsletter_email($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
//echo "comming";exit;
        $this->db->select('*');
        $this->db->from('newsletter_email');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
//$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like('newsletter_email', $search_string);
        }
        $this->db->group_by('newsletter_email_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('newsletter_email_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        exit;
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_newsletter_email($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('newsletter_email');
//$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like('newsletter_email', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('newsletter_email_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_newsletter_email($data) {
        $insert = $this->db->insert('newsletter_email', $data);
        return $insert;
    }

    /**
     * Update newsletter_email
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_newsletter_email($id, $data) {
        $this->db->where('newsletter_email_id', $id);
        $this->db->update('newsletter_email', $data);
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
     * Delete newsletter_emailr
     * @param int $id - newsletter_email id
     * @return boolean
     */
    function delete_newsletter_email($id) {
        $this->db->where('newsletter_email_id', $id);
        $this->db->delete('newsletter_email');
    }

//Imap
    public function get_inboxlist() {
        $mails = $this->get_newsletter_email('', '', '', '', '', '');
//echo "<pre>";print_r($mails);exit;
        $ci = & get_instance();
        $ci->load->config('imap');
        $configmailbox = $ci->config->item('mailbox');
//echo '<pre>';print_r($mailarray); die;
        for ($m = 0; $m < count($mails); $m++) {
            $mailboxes[] = array(
                'label' => 'Mails',
                'mailbox' => $configmailbox,
                'username' => $mails[$m]['email'],
                'password' => decrypt($mails[$m]['password']),
                'folder' => 'INBOX',
            );
        }
//        echo "<pre>";
//        print_r($mailboxes);
//  exit;
        for ($i = 0; $i < count($mailboxes); $i++) {

            $config['imap_server'] = $mailboxes[$i]['mailbox'];
            $config['imap_user'] = $mailboxes[$i]['username'];
            $config['imap_pass'] = $mailboxes[$i]['password'];
            $config['imap_folder'] = $mailboxes[$i]['folder'];
// Load the IMAP Library
            $this->imap($config);
            $mailarray[$i] = $this->imap_get_mail_array($mailboxes[$i]['username']);
//if (!empty($mailarray[$i]))
// @array_push($mailarray[$i], array("to_mai" => $mailboxes[$i]['username']));
//$mailarray[$i]['to_add'] = $mailboxes[$i]['username'];
//$mail += $this->Imap_model->imap_unread();
        }
//echo "<pre>"; print_r($mailarray);exit;
        return $mailarray;
    }

    public function get_mail_count() {
        $mails = $this->get_newsletter_email('', '', '', '', '', '');
//echo '<pre>';print_r($mailarray); die;
        $ci = & get_instance();
        $ci->load->config('imap');
        $configmailbox = $ci->config->item('mailbox');
        for ($m = 0; $m < count($mails); $m++) {
            $mailboxes[] = array('label' => 'Mails',
                'mailbox' => $configmailbox,
                'username' => $mails[$m]['email'],
                'password' => decrypt($mails[$m]['password']),
                'folder' => 'INBOX',
            );
        }
//echo '<pre>'; print_r($mailboxes);
//echo '<pre>'; print_r($mailbox); die;
        $mailcount = 0;
        if (!empty($mailboxes)) {
            if (count($mailboxes) > 0) {
                for ($i = 0; $i < count($mailboxes); $i++) {
                    $config['imap_server'] = $mailboxes[$i]['mailbox'];
                    $config['imap_user'] = $mailboxes[$i]['username'];
                    $config['imap_pass'] = $mailboxes[$i]['password'];
                    $config['imap_folder'] = $mailboxes[$i]['folder'];
// Load the IMAP Library
                    $this->imap($config);
//$mailarray[] = $this->Imap_model->imap_get_mail_array();
                    $mailcount += $this->imap_unread();
                }
            }
        }
        return $mailcount;
    }

}

?>