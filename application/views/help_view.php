<main>
<div class="set_errors">
<?php 
 echo validation_errors();
     if($this->session->flashdata('flash_message')){
          echo '<div class="alert '.$this->session->flashdata("flash_class").'">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
          echo '</div>';       
      }?>
</div>
       <section class="help" id="container">
            <section id="help_leftbar">
            	<?php echo cms_block($cms_block)?>
            	<?php /*?><div class="help_leftbar_inner">
                    <div class="page_helptitle"><h2>We're here to help!</h2></div>
                    <article id="help_article">
                    	<p>Explore the help topics, and if you can't find your answer or just want to say 'hi', please <a style="color:#808080; text-decoration:none;" href="#">email us</a>.
                    	<b style="font-size:14px;">We would appreciate a short feedback from you as well.</b></p>     
                    </article>
                    
                    <article id="help_article">
                        <div class="jwl_one_half"><p></p>
                            <h3>What would you like help with?</h3>
                            <ul>
                            <li><a href="http://www.knewdog.com/help/guide/" title="Getting started">Getting started</a></li>
                            <li><a href="http://www.knewdog.com/help/faq/" title="FAQ">Questions and answers (FAQ)</a></li>
                            <li><a href="http://www.knewdog.com/home/contact/" title="Contact us!">Contact us</a></li>
                            </ul>
                            <p></p>
                        </div>  
                        <div class="jwl_one_half last">
                            <p></p>
                            <h3>Find us on the Interwebs</h3>
                            <p>We‘re always happy to keep you updated on <br/>Twitter, 
                            <a onClick="javascript:_gaq.push(['_trackEvent','outbound-article','http://www.facebook.com']);" href="#">Facebook</a>, 
                            <a onClick="javascript:_gaq.push(['_trackEvent','outbound-article','http://plus.google.com']);" href="#">Google+</a>, 
                            <a onClick="javascript:_gaq.push(['_trackEvent','outbound-article','http://www.linkedin.com']);" href="#">Linkedin</a> and 
                            <a href="#">Xing</a> too.<br> Just come by our pages and say ‚hi‘.</p>
                            <p></p>
                        </div>   
                    </article>                                     
                </div><?php */?>
            </section>
            <?php include_once("includes/sidebars/help_sidebar.php");?>
        </section>
</main>