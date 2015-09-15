<?php
class Sitemap extends CI_Controller {
 
    public function __construct(){
		//echo "die";
        parent::__construct();
       /* $this->load->model('blog_model');
		$this->load->model('newsletter_model');*/
		
    }
 
    function index()
    {
		//echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']
		//site_url('newsletter/specific') . "/" . url_title($newsletter[$i]['newsletter_name'], 'dash', true) . "/" . $newsletter[$i]['newsletter_id']
		//echo "hi"; die;
		/*$blogs = $this->blog_model->get_blog('', '', '', '', '','Active',array(),array());
		$mynl_where_field = array("newsletter_relation");
        $mynl_where_value = array("parent");
		$newsletter = $this->newsletter_model->get_newsletter('', '', '', '', '', 'Active',$mynl_where_field,$mynl_where_value);
        $data['blog'] = $blogs;
		$data['newsletter'] = $newsletter;
		$data['main_content'] = 'sitemap_view';
		header("Content-Type: text/xml;charset=iso-8859-1");
		//echo '<pre>'; print_r($data);
		//die;
		$filename = FCPATH . 'sitemap.xml';
		$xml = $this->load->view('sitemap_view', $data, TRUE);
		$this->load->helper('download');
		//force_download($filename, $xml);
		
		$this->load->helper('file');
		write_file($filename, utf8_encode($xml));*/
		echo $return  = sitemap_generator();
		//write_file($save, $backup); 
	 //writing to file
 
        //$this->load->view('sitemap_view', $data);
        //$this->load->view("sitemap_view",$data);
    }
}
 
?>