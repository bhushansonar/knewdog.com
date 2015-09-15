<?php

class Db_backup extends CI_Controller {
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
        $this->load->database();
        $this->load->dbutil();
    }

    public function databsebackup() {

        $prefs = array(
            'format' => 'zip',
            'filename' => 'backup-on-' . date("Y-m-d-H-i-s") . '.sql'
        );

        $backup = & $this->dbutil->backup($prefs);

        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = './uploads/database/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);
        $this->load->helper('download');


        $this->load->helper('email');
        //load email library
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://secure146.inmotionhosting.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@knewdog.com',
            'smtp_pass' => 'G#-(6Z{!d)LJ',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        if (valid_email('info@knewdog.com')) {
            // compose email
            $get_admin_detail = get_admin_detail(); //common helper function for admin detail
            $this->email->from("admin@knewdog.com", $get_admin_detail['name']);
            $this->email->to('info@cactus-competence.com');
            //$this->email->to('hardik@amutechnologies.com');
//			$this->email->cc('vijay@amutechnologies.com');
            $this->email->set_mailtype("html");
            $this->email->subject("knewdog database backup file " . date("Y-m-d"));
            $this->email->message("<p>Please Find the attached database backup file.</p><p>Regards,<br/>knewdog Team.</p>");
            $filename = FCPATH . "uploads/database/" . $db_name;
            $this->email->attach($filename);
            if ($this->email->send()) {
                //echo 'Your email was sent, successfully.';
            } else {
                //show_error($this->email->print_debugger());
            }
            @unlink($filename);
        }
        //force_download($db_name, $backup);
        //Update sitemap everyday
        sitemap_generator();
    }

}

?>