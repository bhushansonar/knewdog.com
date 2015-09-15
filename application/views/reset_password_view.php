<main>
<div class="set_errors">
<?php 
 echo validation_errors();
	  //echo $this->session->flashdata('flash_message');
      if($this->session->flashdata('flash_message')){
       /* if($this->session->flashdata('flash_message') == 'add')
        {*/
          echo '<div class="alert '.$this->session->flashdata("flash_class").'">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
          echo '</div>';       
        /*}else if($this->session->flashdata('flash_message') == 'update'){
		 echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> user updated with success.';
          echo '</div>'; 
		}else if($this->session->flashdata('flash_message') == 'delete'){
		echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Well done!</strong> user deleted with success.';
          echo '</div>';
		}else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }*/
      }?>
</div>
<section class="signupfree_container">
        <section class="homepage" id="container" style=" float:none; overflow:hidden;border-bottom: 1px solid #BB753E;">
        <div class="homepage_inner" style="text-align:center;">
            <article style="margin:30px auto 19px 0;">
                <h1 style="margin:0 0 0.8125em; font-weight:bold; font-size:190%;">Reset your Knewdog password for login!<?php //echo _clang(HOME_HEAD_TEXT);?></h1>
               <form style="text-align:center;" action="<?php echo site_url();?>signup/set_password" class="form_home" method="post">
               				<input type="hidden" name="email" value="<?php echo $this->uri->segment(3);?>" />
                            <input type="password" placeholder="Password" name="password" class="username_home">
                            <input type="password" placeholder="Confirm Pasword" name="password2" class="username_home"><br>
                            <input type="submit" name="Submit" value="Set Password" class="signup_btn1">
                        </form>
            </article>
		</div>
         </section>
          <section id="howdoesitwork">
                    <article>
                    <div class="signupfree_blacktitle howdoesitwork_title"><h2><?php echo _clang(HOW_DOES)?> ?</h2></div>
                        <div class="dash_jwl_one_fourth">
                            <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram1.png" class="alignnone size-full wp-image-257" alt="">
                            <?php echo _clang(SIGNUP_WITH_YOUR);?>
                            </div>
                            <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram2.png" class="alignnone size-full wp-image-257" alt="">
                            <?php echo _clang(BROWSE_OUR);?>
                            </div>
                            <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram3.png" class="alignnone size-full wp-image-257" alt="">
                            <?php echo _clang(READ_THE_NEWSLETTERS);?>
                            </div>
                            <div class="jwl_one_fourth last"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram4.png" class="alignnone size-full wp-image-257" alt="">
                            <?php echo _clang(DID_NOT_FIND);?>
                            </div>
                        </div>
                        <div class="clearboth"></div>
                        <p style="margin-bottom: 1.5em;"></p>
                        <h3><span style="color: #e46c0a; font-size:16px;"><?php echo _clang(OUR_PROMISE);?></span></h3>
                        <hr>
                    </article>
                </section>
                
                <section id="newfeaturestobecomingup">
                    <article>
                        <div class="signupfree_blacktitle newfeaturestobecomingup_title"><h2><?php echo _clang(NEW_FEATURES)?></h2></div>
                        <ul class="newfeaturestobecomingup">
                            <li><?php echo _clang(GET_ALL_YOUR);?></li>
                            <li><?php echo _clang(CHOOSE_DATE);?></li>
                            <li><?php echo _clang(SELECT_INDIVIDUAL);?></li>
                            <li><?php echo _clang(THE_FEEDBACK);?></li>
                            <li><?php echo _clang(QUICK_AND_EASY);?></li>
                            <li><?php echo _clang(COMPANY_ACCOUNTS);?></li>
                        </ul>
                        <hr>
                    </article>
                </section>
       
 </section>
        </main>