<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Functions {

    function enc_pass($string) {
// define a salt
        $salt = "KHSPWYBG";
//encrypt with multiple methods of encryption and add salt to it.
        $hash = sha1(sha1(md5($salt . $string))) . md5(sha1($string));
//return the hash back to the function caller.
        return $hash;
    }

    function genRandPass($length = 8) {
        $password = ""; //declare & intialise variable
//define possible characters to use in random password
        $passchar = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
// we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($passchar);
// check whether or not length exceeds allowed numbers
        if ($length > $maxlength) {
            $length = $maxlength;
        }
// set up a counter to count number of characters in password so far
        $i = 0;
// keep adding random character untill the defined length is reached
        while ($i < $length) {
//choose a random charcter from possible characters
            $char = substr($passchar, mt_rand(0, $maxlength - 1), 1);
// check whether or not this character has been used before in previous password characters
//strstr compares the string for the occurance of specifi character
            if (!strstr($password, $char)) {
//if the charcter has not been used then add that to the password
                $password .= $char;
//now increase the counter
                $i++;
            }
        }
        return $password;
    }

    function getNameFromNumber($num) {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }

    function get_tiny_url($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
	
	function get_newsletter_rand_id(){
		$month = strtoupper(date('M'));
		$digits = 5;
		$randno = rand(pow(10, $digits-1), pow(10, $digits)-1);
		$ids = $month.date('y').$randno."N";
		return $ids;
	}
	
	function get_newsletter_lsn_id(){
		//$sn = date('y').date('m').date("d").date("H").date("i").date("s");
		$sn = date('ymdHis');
		return $sn;
	}
	
	function get_user_rand_id(){ 
		$random = substr(number_format(time() * rand(),0,'',''),0,9);
		return $random;
	}
	function do_upload($filename,$path='./uploads/',$allowtype='gif|jpg|png') {
		
		$config['upload_path'] = $path;
		$config['allowed_types'] = $allowtype;
	    $config['max_size'] = '2048';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

		$ci = get_instance();
        $ci->load->library('upload');
        $ci->upload->initialize($config);
        if (!$ci->upload->do_upload($filename)) {
            $response = array('error' => $ci->upload->display_errors());
			//echo print_r($response); die;
            //$this->load->view('upload_form', $error);
        } else {
            $response = array('upload_data' => $ci->upload->data());
            //$this->load->view('upload_success', $data);
        }

        return $response;
    }
	
	/*function viewtext($Textvalue){
		$Textvalue=stripslashes($Textvalue);
		$Textvalue=trim($Textvalue);
	return $Textvalue;
}*/

}