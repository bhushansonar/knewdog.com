<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contactus_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
       // $this->load->database();
    }
	public function form_data()
    {
        $data=array(
            'name'=>$_POST['name'],
            'city'=>$_POST['city'],
            'state'=>$_POST['state'],
			'contact'=>$_POST['contact']
            );
	}
}