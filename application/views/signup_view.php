<main>
    <?php
    $facebook_login = K_facebook();
    if (!empty($facebook_login)) {
        $facebookurl1 = @$facebook_login['login_url'];
        $facebookurl = htmlspecialchars($facebookurl1);
    } else {
        $facebookurl = '#';
    }
    $google_login = K_google();
    if (!empty($google_login['authUrl'])) { //user is not logged in, show login button
        $googleurl1 = @$google_login['authUrl'];
        $googleurl = htmlspecialchars($googleurl1);
    } else {
        $googleurl = "#";
    }
    ?>
    <div class="set_errors">
        <?php
        echo validation_errors();
        //echo $this->session->flashdata('flash_message');
        if ($this->session->flashdata('flash_message')) {
            /* if($this->session->flashdata('flash_message') == 'add')
              { */
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
    </div>
    <section class="signupfree">

        <section class="signupfree_container">
            <?php /* ?> <article style="margin:30px auto 17px 0px; width:100%; line-height:0; text-align:center;">
              <div style="font-size:190%; line-height:normal;" class="signupfree_blacktitle"><?php echo _clang(SIGNUP_TITLE1);?></div>
              </article>
              <article style="margin:30px auto 17px 0px; width:100%; line-height:0; text-align:center;">
              <div style="font-size:18px;" class="signupfree_blacktitle"><?php echo _clang(SIGNUP_NOW);?> <u><?php echo _clang(FOR_FREE);?> !</u></div>
              </article><?php */ ?>
            <?php echo cms_block('SIGNUP_HEAD') ?>
            <br/>

            <section class="home_right">
                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                    <article>
                        <div class="topheader">
                            <ul>
                                <li class="signinwith"><?php echo _clang(SIGN_IN_WITH_SIGNUP); ?></li>
                                <li class="facebook"><a onClick="javascript:void window.open('<?php echo $facebookurl; ?>', 'fb_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;" href="<?php echo $facebookurl ?>"><img src="<?php echo base_url(); ?>assets/img/facebook.png" height="26" width="26" alt="facebook"><?php echo _clang(FACEBOOK) ?></a></li>
                                <li class="google"><a onClick="javascript:void window.open('<?php echo $googleurl; ?>', 'g_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;" href="<?php echo $googleurl ?>"><img src="<?php echo base_url(); ?>assets/img/google.png" height="26" width="26" alt="google"><?php echo _clang(GOOGLE) ?></a></li>
                            </ul>
                        </div>
                        <p class="quicksignup_home"><?php echo _clang(QUICK_SING_UP_SIGNUP); ?>.</p>
                        <form method="post" class="form_home" action="<?php echo site_url('signup/create_member') ?>">
                            <input class="username_home" name="username" type="text" placeholder="<?php echo _clang(USERNAME); ?>">
                            <input class="emailaddress_home" name="email" type="text" placeholder="<?php echo _clang(YOUR_EMAIL_ADD); ?>"><br/>
                            <!--<input class="signup_btn1" value="Sign Up Now!" name="Submit" type="submit" />-->
                            <input style="margin-top:5px; margin-bottom:5px; font-size: 20px; padding: 10px 23px;" class="btn btn_main" value="<?php echo _clang(SIGN_UP_BUTTON); ?>" name="Submit" type="submit" />
                        </form>
                        <p class="freeaccount quicksignup_home"><?php echo _clang(ITS_FREE) ?> !</p>
                        <span style="color:#808080; border-bottom:1px solid #BB753E; float: left; width: 100%; padding-bottom: 20px; font-size:15px; margin-top:23px; text-align: center">
                            <?php echo _clang(BY_CLICKING); ?>
                        </span>
                    </article>
                <?php } ?>
            </section>


            <?php /* ?> <section id="howdoesitwork">
              <article>
              <div class="signupfree_blacktitle howdoesitwork_title"><h2><?php echo _clang(HOW_DOES)?> ?</h2></div>
              <div class="dash_jwl_one_fourth">
              <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram1.png" class="alignnone size-full wp-image-257">
              <?php echo _clang(SIGNUP_WITH_YOUR);?>
              </div>
              <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram2.png" class="alignnone size-full wp-image-257">
              <?php echo _clang(BROWSE_OUR);?>
              </div>
              <div class="jwl_one_fourth"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram3.png" class="alignnone size-full wp-image-257">
              <?php echo _clang(READ_THE_NEWSLETTERS);?>
              </div>
              <div class="jwl_one_fourth last"><img height="113" width="113" src="<?php echo base_url(); ?>assets/img/pictogram4.png" class="alignnone size-full wp-image-257">
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
              </section><?php */ ?>
            <?php echo cms_block('SIGNUP_HOW_DOES'); ?>

            <section class="signupfree_container" style="float:left;">
                <?php /* ?><article style="margin:30px auto 17px 0px; width:100%; line-height:0; text-align:center;">
                  <div style="font-size:190%; line-height:normal;" class="signupfree_blacktitle"><?php echo _clang(SIGNUP_TITLE1);?></div>
                  </article>
                  <article style="margin:30px auto 17px 0px; width:100%; line-height:0; text-align:center;">
                  <div style="font-size:18px;" class="signupfree_blacktitle"><?php echo _clang(SIGNUP_NOW);?> <u><?php echo _clang(FOR_FREE);?> !</u></div>
                  </article><?php */ ?>
                <?php echo cms_block('SIGNUP_BOT'); ?>
                <br/>
                <section class="home_right">
                    <?php if (!$this->session->userdata('is_logged_in')) { ?>
                        <article>
                            <div class="topheader">
                                <ul>
                                    <li class="signinwith"><?php echo _clang(SIGN_IN_WITH_SIGNUP); ?></li>
                                    <li class="facebook"><a onClick="javascript:void window.open('<?php echo $facebookurl; ?>', 'fb_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;" href="<?php echo $facebookurl ?>"><img src="<?php echo base_url(); ?>assets/img/facebook.png" height="26" width="26" alt="facebook"><?php echo _clang(FACEBOOK) ?></a></li>
                                    <li class="google"><a  onClick="javascript:void window.open('<?php echo $googleurl; ?>', 'g_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;"  href="<?php echo $googleurl ?>"><img src="<?php echo base_url(); ?>assets/img/google.png" height="26" width="26" alt="google"><?php echo _clang(GOOGLE) ?></a></li>
                                </ul>
                            </div>
                            <p class="quicksignup_home"><?php echo _clang(QUICK_SING_UP_SIGNUP); ?>.</p>
                            <form method="post" class="form_home" action="<?php echo site_url('signup/create_member') ?>">
                                <input class="username_home" name="username" type="text" placeholder="<?php echo _clang(USERNAME); ?>">
                                <input class="emailaddress_home" name="email" type="text" placeholder="<?php echo _clang(YOUR_EMAIL_ADD); ?>"><br/>
                                <!--<input class="signup_btn1" value="Sign Up Now!" name="Submit" type="submit" />-->
                                <input style="margin-top:5px; margin-bottom:5px; font-size: 20px; padding: 10px 23px;" class="btn btn_main" value="<?php echo _clang(SIGN_UP_BUTTON); ?>" name="Submit" type="submit" />
                            </form>
                            <p class="freeaccount quicksignup_home"><?php echo _clang(ITS_FREE) ?> !</p>
                            <span style="color:#808080; float: left; width: 100%; padding-bottom: 20px; font-size:15px; margin-top:23px; text-align: center">
                                <?php echo _clang(BY_CLICKING); ?>
                            </span>
                        </article>
                    <?php } ?>
                </section>


            </section>

        </section>
    </section>
</main>