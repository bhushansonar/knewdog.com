<main>
<div class="set_errors">
<?php
$this->load->model('comment_model'); 
 echo validation_errors();
     if($this->session->flashdata('flash_message')){
          echo '<div class="alert '.$this->session->flashdata("flash_class").'">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
          echo '</div>';       
      }?>
</div>
       <section class="blog" id="container">
            <section id="blog_leftbar">
            	<div class="blog_leftbar_inner">
                <div class="page_blogtitle"><h2><?php echo _clang(KNEWDOG_BLOG); ?></h2>
                <hr>
                </div>
                <?php $language_shortcode = $this->session->userdata('language_shortcode');?>
                <?php for($i=0;$i<count($blog);$i++){
					if(!empty($blog[$i]['title_'.$language_shortcode])){
						$blog_title = $blog[$i]['title_'.$language_shortcode];
					}else{
						$blog_title = $blog[$i]['title_en'];
						}
					if(!empty($blog[$i]['description_'.$language_shortcode])){
						$blog_description = $blog[$i]['description_'.$language_shortcode];
					}else{
						$blog_description = $blog[$i]['description_en'];
						}
					?>
                <article class="blog_article">
                <div class="header_blogtitle">
                    <div class="blogtitle"><h2><a rel="bookmark" title="Permalink to <?php echo $blog_title ?>" href="<?php echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']?>"><?php echo $blog_title ?></a></h2><div style="color:#000000;" class="date_time"><span><?php echo _clang(PUBLISHED_ON_B);?></span> <?php echo date('j, F Y',strtotime($blog[$i]['published_date']))?></div></div>
                    <?php 
					$comment_c = $this->comment_model->get_comment('', 'comment_id','DESC', '', '','', array("comment.blog_id","comment.status"), array($blog[$i]['blog_id'],"Active"));
					?>
                    <div class="comments-link"><a title="Comment on How to reduce noise?" href="<?php echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']?>"><?php echo count($comment_c);?><!--<span class="leave-reply">Reply</span>--></a></div>
                </div>
                
                <div class="blog_content">
               <?php if(@getimagesize((site_url('uploads')."/".$blog[$i]['featured_image']))){?>
               		<img style="float:left;" alt="Feature Image" width="80" class="feature_img_blog" src="<?php echo site_url('uploads')."/".$blog[$i]['featured_image']?>"  />
                    
               <?php 
			   $width = 'width:581px;';
			   }else{
				   
			 $width = 'width:600px;';
				   }?>
               
                <div style="margin-left:5px; <?php echo $width;?>"><?php echo get_excerpt($blog_description,250,'...');?></div>
                <div ><a style="padding-top:5px;" href="<?php echo site_url('blog/specific')."/".url_title($blog_title,'dash',true)."/".$blog[$i]['blog_id']?>" class="more-link"><?php echo _clang(MORE); ?></a></div>
                <!--</p>-->
                </div>
                </article>
                <?php }?>
                   
                </div>
                	<?php echo '<div class="pagination">'.$link.'</div>'; ?>
            </section>
            
            <?php include_once("includes/sidebars/blog_sidebar.php");?>
         
        </section>
</main>