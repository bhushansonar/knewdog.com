<main>
<!--<link href="<?php //echo site_url('assets/css')?>/rateit.css" rel="stylesheet" type="text/css">-->
<div class="set_errors">
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
<?php
$this->load->model('newsletter_model');

 //echo validation_errors();
 if ($this->session->flashdata('form_errors')){ //change!
    echo "<div class='error'>";
    echo $this->session->flashdata('form_errors');
    echo "</div>";
    }
     if($this->session->flashdata('flash_message')){
          echo '<div class="alert '.$this->session->flashdata("flash_class").'">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
          echo '</div>';       
      }
	  //echo '<pre>'; print_r($newsletter_review); 
	  ?>
</div>
      <section class="knewdog findnewsletter" id="container">
            <section id="knewdog_leftbar">
            	<div class="knewdog_leftbar_inner" style="width:100%;">
                	<div class="page_helptitle">
						<h2><?php echo _clang(CUSTOMER_REVIEW_A); ?> <a style="font-size:24px;" href="<?php echo site_url('newsletter/specific')."/".url_title($newsletter[0]['newsletter_name'],'dash',true)."/".$newsletter[0]['newsletter_id']?>"><?php echo $newsletter[0]['newsletter_name']?></a></h2>
					</div>
                	 <?php 
								
									include("rating/rating_calculation.php");
								   include("rating/rating_view.php");
								  $user_id = $this->session->userdata("user_id"); 
									//echo "user_id->".$newsletter[$i]["user_id"];
									$wherefield =array("join_newsletter_id","join_user_id");
									$wherevalue = array($newsletter[0]["newsletter_id"],$user_id);
									$get_news_user_id = $this->newsletter_model->get_rate_by_field($wherefield,$wherevalue);
								if(!empty($user_id)){
									if(count($get_news_user_id) > 0){
											$readonly = "true";		
								    }else{
										$readonly = "false";	
										}
								}else{
										$readonly = "true";
									}
								//echo '<pre>'; print_r($get_news_user_id);
							
								
										if(count($get_news_user_id) > 0){
										$star_read_only = true;
										}else{
										
											$star_read_only = false;
											}
								//}
								   ?>
                                   <div class="starrating_detail">
                                        <div class="reviewstar">
                                            <div title="<?php echo $avg_round;?>" style="float:left; margin-top:2px;" data-productid="<?php echo $newsletter[0]['newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $avg_round;?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="true" class="rateit rateit9"></div>
                                            <a style="margin-left:3px;" href="javascript:void(0)">(<?php echo $total_user_rate;?>)</a>
                                        </div>
                                        <div class="reviewstar"><div style="color:#808080; margin-top:5px;"><?php echo round($avg_round,2)?> <?php echo _clang(OUT_OF_A); ?></div></div>
                                        
                                    </div>
                                    <div class="add_review contact">
                              
                                     <?php 
									if(!empty($user_id)){
										
										$this->load->model('subscribe_model');
										$where_s_field = array('s_user_id','s_newsletter_id');
										$where_s_value = array($user_id,$newsletter[0]["newsletter_id"]);
										$subscribed = $this->subscribe_model->get_subscribe('', '', '', '', '',$where_s_field,$where_s_value);
										if(count($subscribed) > 0){
											
											
									
										 if($get_news_user_id != true){?>
                                    	<div id="content" style="width:70%;">
                                       
                                       <h1><?php echo _clang(ADD_REVIEW); ?></h1>
                                        
                                        <form id="form_rate" action="<?php echo site_url("newsletter/addreview")?>" method="post" autocomplete="on">
                                                <input type="hidden" id="rate" name="rate" value="" />
                                                <input type="hidden" name="join_user_id" value="<?php echo $this->session->userdata("user_id")?>" />		
                                                <input type="hidden" name="join_newsletter_id" value="<?php echo $newsletter[0]["newsletter_id"]?>" />		
                                                
                                            <div><label for="subject" class="iconic quote-alt"> <?php echo _clang(RATE); ?>  <span class="required">*</span></label> 
                                            <div style="  width:210px; padding:10px; padding-top: 3px; padding-bottom: 13px;" data-productid="<?php echo $newsletter[0]['newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="0" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="false" class="rateit rateit9"></div> </div>
                                
                                            <p> <label for="subject" class="iconic quote-alt"> <?php echo _clang(TITLE); ?>  <span class="required">*</span></label> <input style="color:#555555;" type="text" name="title" id="title"  placeholder="<?php echo _clang(WHAT_WOULD); ?>"> </p>
                                
                                            <p> <label for="message" class="iconic"> <?php echo _clang(MESSAGE); ?>  <span class="required">*</span></label> <textarea placeholder="<?php echo _clang(DONTBESHY_RATING)?>" name="message" ></textarea> </p>
                                            <p class="indication"> <?php echo _clang(ALL_FIELDS); ?> <span class="required">*</span> <?php echo _clang(ARE_REQUIRED); ?></p>
                                            
                                            <input onclick="" type="submit" value="<?php echo _clang(SUBMIT_BUTTON)?>" style="width:104px; margin-left:128px;" class="btn btn_main">		
                                
                                        </form>		
                                       
                                    </div>
                                     <?php }else{?>
                                        <h1 style="clear: both; color: rgb(228, 108, 10); text-align: center;"><?php echo _clang(EDIT_YOUR); ?></h1>
                                        <div id="content" style="width:70%;">
                                       
                                       <h1><?php echo _clang(EDIT_REVIEW); ?></h1>
                                      
                                        
                                        <form id="form_rate" action="<?php echo site_url("newsletter/editreview")?>" method="post" autocomplete="on">
                                                
                                                <input type="hidden" name="join_user_id" value="<?php echo $this->session->userdata("user_id")?>" />		
                                                <input type="hidden" name="join_newsletter_id" value="<?php echo $newsletter[0]["newsletter_id"]?>" />		
                                          <?php for($i=0;$i<count($newsletter_review);$i++){
                                    if($newsletter_review[$i]['join_user_id'] == $this->session->userdata("user_id")){	?>
                                    <input type="hidden" id="rate" name="rate" value="<?php echo $newsletter_review[$i]['rate'];?>" />
                                       	   	<input type="hidden" name="newsletter_review_id" value="<?php echo $newsletter_review[$i]['newsletter_review_id']?>" />    
                                            <div><label for="subject" class="iconic quote-alt"> <?php echo _clang(RATE); ?>  <span class="required">*</span></label> 
                                            <div style="  width:210px; padding:10px; padding-top: 3px; padding-bottom: 13px;" data-productid="<?php echo $newsletter[0]['newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $newsletter_review[$i]['rate'];?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="false" class="rateit rateit9" ></div> </div>
                                
                                            <p> <label for="subject" class="iconic quote-alt"> <?php echo _clang(TITLE); ?>  <span class="required">*</span></label> <input style="color:#555555;" type="text" name="title" value="<?php echo $newsletter_review[$i]['title'];?>" id="title"  placeholder="<?php echo _clang(WHAT_WOULD); ?>"> </p>
                                
                                            <p> <label for="message" class="iconic"> <?php echo _clang(MESSAGE); ?>  <span class="required">*</span></label> <textarea placeholder="<?php echo _clang(DONTBESHY_RATING)?>" name="message"><?php echo $newsletter_review[$i]['message'];?></textarea> </p>
                                            <p class="indication"> <?php echo _clang(ALL_FIELDS); ?> <span class="required">*</span> <?php echo _clang(ARE_REQUIRED); ?></p>
                                            
                                            <input onclick="" type="submit" value="SUBMIT" style="width:104px; margin-left:128px;" class="btn btn_main">		
                                            <p style="text-align:right;"  class="indication"><?php echo _clang(WANT); ?> <a onclick="return confirmdeletereview('<?php echo $newsletter[0]["newsletter_id"]?>','<?php echo $newsletter_review[$i]['newsletter_review_id']?>');" href="javascript:void(0)<?php //echo site_url("newsletter/deletereview/".$newsletter[0]["newsletter_id"]."/".$newsletter_review[$i]['newsletter_review_id'])?>"><?php echo _clang(DELETE); ?></a> <?php echo _clang(YOUR_REVIEW); ?></p>
                                         
                                <?php 
												}
											}?>   
                                        </form>		
                                       
                                    </div>
                                        
                                        <?php }
										}else{
										
										echo '<h1 style="clear: both; color: rgb(228, 108, 10); text-align: center;">'._clang(PLEASE_SUBSCRIBE).'</h1>';
											}
									}else{
										?>
                                    
        <h1 style="clear: both; color: rgb(228, 108, 10); text-align: center;"><?php echo _clang(PLEASE_A); ?> <a style="cursor:pointer;" onclick="popup('signin')"><?php echo _clang(LOGIN_A); ?></a> <?php echo _clang(TO_ADD); ?></h1>  
                                    <?php }?>
    	
                                    </div>
                                   
                               <?php 
							   if(count($newsletter_review) > 0){
							   for($i=0;$i<count($newsletter_review);$i++){
								   ?>
                            	<div class="fullwidth_left details mostrecentreviews" style="width: 94%">
                                        <div class="minititle">
                                            <div title="<?php echo $newsletter_review[$i]['rate'];?>" style="float:left;" data-productid="<?php echo $newsletter_review[$i]['join_newsletter_id']; ?>" data-rateit-resetable="false" data-rateit-value="<?php echo $newsletter_review[$i]['rate'];?>" data-rateit-ispreset="true" data-rateit-reset="false" data-rateit-readonly="true" class="rateit rateit9" ></div>
                                            <label><?php echo $newsletter_review[$i]["title"]?></label>
                                        </div>
                                        <div class="description">
                                            <?php echo $newsletter_review[$i]["message"]?>
                                        </div>
                                        <span><?php echo _clang(PUBLISHED_ON_A); ?> <?php echo @date('j, F Y',strtotime($newsletter_review[$i]['date']));?> <?php echo _clang(BY_A); ?> <?php echo ($newsletter_review[$i]['username_only'] == 'YES') ? $newsletter_review[$i]["username"] : $newsletter_review[$i]["firstname"]." ".$newsletter_review[$i]["lastname"];?></span>
                                </div>
                                <?php }
							   }
							   ?>
                               <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?> 
                            
                
                </div>
            </section>
            <?php include_once("includes/sidebars/newsletter_sidebar.php");?>
            <script type="text/javascript">
             $('#form_rate .rateit').bind('rated reset', function (e) {
				 var ri = $(this);
		 
				 //if the use pressed reset, it will get value: 0 (to be compatible with the HTML range control), we could check if e.type == 'reset', and then set the value to  null .
				 var value = ri.rateit('value');
				 $("#rate").val(value);
				 //alert(value);
				 var productID = ri.data('productid'); 
				 //var starheight = ri.rateit('starheight'); 
				 // if the product id was in some hidden field: ri.closest('li').find('input[name="productid"]').val()
					//alert(productID);
					//alert(starheight)
				 //maybe we want to disable voting?
				 //ri.rateit('readonly', true);
		 
				 $.ajax({
					 url: '<?php echo site_url('newsletter/rateit');?>', //your server side script
					 data: { action:'rate', id: productID, value: value }, //our data
					 type: 'POST',
					 success: function (data) {
						 $('#response').append('<li>' + data + '</li>');
						$("#result_star").rateit('value',data);
					 },
					 error: function (jxhr, msg, err) {
						 $('#response').append('<li style="color:red">' + msg + '</li>');
					 }
				 });
			 });
            </script>
            <script src="<?php echo site_url('assets/js')?>/jquery.rateit.js" type="text/javascript"></script>
      </section>