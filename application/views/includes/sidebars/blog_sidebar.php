<?php 
$ci =& get_instance();
$ci->load->model('blog_model');
//$search_string, $order, $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value,$language_id,$newsletter_category,$rating_id,$author_country,$author_zipcode
//New in our database:$this->blog_model->get_blog('', '', $order_type, $config['per_page'],$limit_end,'Active',$where_field,$where_value);
$where_field1 = array("schedule_status");
$where_value1 = array("Active");
$blog = $ci->blog_model->get_blog('', 'blog_id', 'DESC', '3','0','Active',$where_field1,$where_value1);
$language_shortcode = $this->session->userdata('language_shortcode');
//This might also interest you:
?>
<aside id="sidebar">
  <div id="sidebar_right">
  	<?php if(count($blog) > 0){?>
    <aside class="widget">
      <h3 class="widget-title"><?php echo _clang(LATEST_NEWS); ?></h3>
      <div class="widget_content">
        <ul>
        <?php for($i=0;$i<count($blog);$i++){
			/*if(!empty($blog[$i]['title_'.$language_shortcode])){
						$blog_title = $blog[$i]['title_'.$language_shortcode];
					}else{
						$blog_title = $blog[$i]['title_en'];
						}*/
			$blog_title = !empty($blog[$i]['title_'.$language_shortcode]) ? $blog[$i]['title_'.$language_shortcode] : $blog[$i]['title_en'];
			?>
          <li><a rel="bookmark" title="Permalink to <?php echo $blog_title ?>" href="<?php echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']?>"><?php echo $blog_title?></a></li>
          <?php }?>
        </ul>
      </div>
    </aside>
 	<?php }?>
     <?php
	 $this->load->library('facebook');
     //$this->load->config('facebook');
     
//http://www.facebook.com/feeds/page.php?id=392611907527091&format=rss20&pubDate=LastModified
//$fbApiGetPosts = $facebook->api('/me/feed?limit=5');
$data_rss_feed = $this->facebook->api('/392611907527091/feed?limit=3');
$rss_feed = $data_rss_feed['data'];
	?>
	
	
    <aside class="widget">
      <h3 class="widget-title"><?php echo _clang(FACEBOOK_NEWS); ?></h3>
      <div class="widget_content">
        <ul class="facebooknews">
        <?php for($i=0;$i<count($rss_feed);$i++){
			$post_id = explode("_",$rss_feed[$i]['id']);
			if(isset($rss_feed[$i]['message'])){
			?>
          <li> <a target="_blank" title="<?php echo $rss_feed[$i]['message']?>" href="https://www.facebook.com/knewdog/posts/<?php echo $post_id[1]?>"><?php echo substr(strip_tags($rss_feed[$i]['message']),0,100)?></a><br/><span><?php echo date('j. F Y',strtotime($rss_feed[$i]['created_time']))?></span> </li>
         <?php }
		 }?>
          <!--<li> <a target="_blank" href="#">Du kriegst nichts mehr „gebacken“? Wirst von den Unmengen an Mails...</a> <span>9. January 2014</span> </li>
          <li> <a target="_blank" href="#">Du kriegst nichts mehr „gebacken“? Wirst von den Unmengen an Mails...</a> <span>9. January 2014</span> </li>-->
        </ul>
      </div>
    </aside>
  </div>
</aside>