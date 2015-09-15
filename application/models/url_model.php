<?php
 
class Url_model extends CI_Model{
 
    public function __construct(){
        $this->load->database();
    }
    public function getURLS(){
 
        $this->db->select('articleID');
        $query=$this->db->get('articleTable');
        return $query->result_array();
    }
}
?>