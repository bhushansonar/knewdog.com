<?php

class mail_sent_test extends CI_Controller {
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


        /* if(!$this->session->userdata('is_logged_in')){
          redirect('kd2a2a0u1g4/login');
          } */
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function sent_mail() {

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
        $get_admin_detail = get_admin_detail(); //common helper function for admin detail
        $htmlcontent = '<meta charset="utf-8"><div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;"><table cellspacing="0" cellpadding="0" border="0" style="width:100%">
	<tbody>
		<tr>
			<td>
			<table cellspacing="0" cellpadding="10" border="0" style="background:none repeat scroll 0 0 #E46C0A; width:700px">
				<tbody>
					<tr>
						<td>
						<div style="background: none repeat scroll 0% 0% white; padding: 10px; position: relative; height:135px;"><a href="https://www.knewdog.com"><img style="float:left; margin-bottom:10px; margin-right:60px; width:191px" src="https://www.knewdog.com//assets/img/logo_inner.png" alt="knewdog - the worlds safest newsletter library"></a><span style="color:#e46c0a; font-size:xx-large"><strong>The Worlds Safest Newsletter Library</strong></span></div>
        </td>
        </tr>
        <tr>
        <td>
        <table cellspacing = "0" cellpadding = "0" border = "0" style = "width:700px">
        <tbody>
        <tr>
        <td colspan = "2"><span style = "font-size:x-large"><strong>Your newsletter(s) you subscribed to on knewdog!</strong></span></td>
        </tr>
        <tr>
        <td style = "background-color: #ffffff; text-align: left;">
        <p><a title = "Hide My Ass! Pro VPN" href = "http://hidemyass.com/vpn/r19334/"><img alt = "HideMyAss.com" src = "http://ddfnmo6ev4fd.cloudfront.net/img/banners2014/df/468x60.gif"></a></p>

        <p>Hi bhushan01, </p>

        <p>We are pleased to send you herewith the newsletters you subscribed to on your profile on knewdog.com.</p>

        <p><span style = "color:#e46c0a; font-size:large"><strong>Go Premium and ...</strong></span></p>

        <ul>
        <li>get <strong>all </strong>your favourite newsletters<strong> in one single e-mail</strong>, </li>
        <li><strong>choose date and time</strong> when you want to get your newsletters and</li>
        <li>select<strong> individual e-mail address</strong> for different newsletter topics (e.g. work e-mail address for work related topics)!</li>
        </ul>

        <p><strong>To manage your newsletter subscriptions, please go to your knewdog profile: </strong><a target = "_blank" style = "color: #444444; cursor: pointer;">https://www.knewdog.com/index.php?/signin/</a></p>

        <div style = "color: #e46c0a;"><strong>Have fun reading!<br>
        The knewdog Wouff</strong><br>
        &nbsp;
        </div>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>

        <p>&nbsp;
        </p>
        </div>';
        /* $config['protocol'] = 'sendmail';
          $config['mailpath'] = '/usr/sbin/sendmail';
          $config['charset'] = 'iso-8859-1';
          $config['mailtype'] = 'html';
          $config['priority'] = 3;
          $this->email->initialize($config); */

        $this->email->from("admin@knewdog.com", $get_admin_detail['name']);
        $emails = array('hardik@amutechnologies.com', 'hardik.amutech@gmail.com', 'cool.vijay.89@gmail.com', 'vijay@amutechnologies.com');
        $this->email->to($emails);
        //$this->email->to("isabelle.savinien@gmail.com");
        $this->email->set_mailtype("html");

        $this->email->subject("Test newsletter for Advertisment");
        $this->email->message($htmlcontent);
        $filename = FCPATH . "uploads/database/newsletter_1107978815.html";
        $this->email->attach($filename);
        $this->email->send();
    }

}

