<div id="overlay">
    <!-- signup -->
    <div style="" class="popup signin">
        <div  class="freeusers_box signup_popup">
            <div class="popup_heading"><?php echo _clang(LOGIN_POPUP) ?></div>
            <div class="popup_cancle"><a style="opacity:1;" class="popup_close" href="#"><img height="32" width="32" src="<?php echo base_url(); ?>assets/img/popup-close.png" alt="Popup Close"></a></div>
            <div class="signupfree">

                <?php
                if ($this->session->userdata('is_logged_in')) {
                    $login_error = '<strong>ohh snap!</strong>
Already Login please logout!';
                }
                if (!empty($login_error)) {
                    ?>
                    <div style="margin:12px;" class="alert alert-error">
                        <a class="close" data-dismiss="alert">&#215;</a>
                        <?php echo $login_error; ?>
                    </div>
                <?php } ?>
                <div class="home_right">

                    <div>
                        <div class="topheader">
                            <ul>
                                <li class="signinwith"><?php echo _clang(SIGN_IN_WITH_SIGNUP); ?></li>
                                <?php
                                $facebook_login = K_facebook();
                                if (!empty($facebook_login)) {
                                    $facebookurl1 = @$facebook_login['login_url'];
                                    $facebookurl = htmlspecialchars($facebookurl1);
                                } else {
                                    $facebookurl = '#';
                                }
                                ?>
                                <li class="facebook"><a onClick="javascript:void window.open('<?php echo $facebookurl; ?>', 'fb_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;" href="<?php echo $facebookurl ?>"><img src="<?php echo base_url(); ?>assets/img/facebook.png" alt="facebook" height="26" width="26"><?php echo _clang(FACEBOOK) ?></a></li>
                                    <?php
                                    $google_login = K_google();
                                    if (!empty($google_login['authUrl'])) { //user is not logged in, show login button
                                        $googleurl1 = @$google_login['authUrl'];
                                        $googleurl = htmlspecialchars($googleurl1);
                                    } else {
                                        $googleurl = "#";
                                    }
                                    ?>
                                <li class="google"><a onClick="javascript:void window.open('<?php echo $googleurl; ?>', 'g_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                        return false;" href="<?php echo $googleurl; ?>"><img src="<?php echo base_url(); ?>assets/img/google.png" alt="google" height="26" width="26"><?php echo _clang(GOOGLE) ?></a></li>
                            </ul>
                        </div>
                        <p class="quicksignup_home"><?php echo _clang(QUICK_SIGN_IN_POPUP); ?></p>
                        <form method="post" class="form_home" action="<?php echo site_url('signin/validate_credentials_front') ?>">
                            <input class="username_home" name="username" type="text" placeholder="<?php echo _clang(USERNAME_LOGIN); ?>"/>
                            <input class="username_home" name="password" type="password" placeholder="<?php echo _clang(PASSWORD_LOGIN); ?>" /><br/>
                            <!--                            <label>
                                                            OR
                                                        </label>
                                                        <input style="margin-top:5px; margin-right:189px;" class="username_home" name="email" type="text" placeholder="Email" /><br/>-->
                            <input style="margin-top:5px; margin-bottom:5px;" class="btn btn_main" value="<?php echo _clang(SIGN_IN_BUTTON); ?>" name="Submit" type="submit" />
                            <a href="<?php echo site_url('signin/forgot_password') ?>"><?php echo _clang(FORGOT); ?></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- signup end-->
    <!-- advace_search_popup -->
    <div class="popup advance_search_popup">
        <div class="freeusers_box advancedsearch_popup_box">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
            <div class="heading"><?php echo _clang(FIND_EXACTLY); ?></div>
            <p><?php echo _clang(GET_THE); ?></p>
            <div class="gopremium_btn"><a class="btn btn_main" href="<?php echo site_url('premium-account') ?>">
                    <?php echo _clang(GO_PREMIUM_BUTTON_POPUP); ?>
<!--                    <img src="<?php echo base_url(); ?>assets/img/gopremium.png" height="33" width="129"  alt="gopremium">-->
                </a><span><a class="popup_close" href="javascript:void(0);">
                        <?php echo _clang(NO_THANK); ?>
                    </a></span></div>
        </div>
    </div>
    <!-- advace_search_popup end -->
    <!-- advace_search_popup -->
    <div class="popup manage_schedule_popup_1">
        <div class="freeusers_box manage_schedulingof_newsletter_popup">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" height="17" width="18"  alt="gopremiumcancell"></a></div>
            <div class="heading"><?php echo _clang(NEWSLETTER_EXACTLY); ?></div>
            <p><?php echo _clang(GET_THE_ADVANCED); ?></p>
            <div class="gopremium_btn">
                <a class="btn btn_main" href="<?php echo site_url('premium-account') ?>">
<!--                    <img src="<?php echo base_url(); ?>assets/img/gopremium.png" height="33" width="129"  alt="gopremium">-->
                    <?php echo _clang(GO_PREMIUM_BUTTON_POPUP); ?>
                </a></div>
        </div>
    </div>
    <!-- advace_search_popup end -->
    <!-- advace_search_popup 2 -->
    <div class="popup manage_schedule_popup_2">
        <div class="freeusers_box subscribetonewsletter_popup">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
            <div class="heading"><?php echo _clang(NEWSLETTER_EXACTLY); ?></div>
            <p><?php echo _clang(GET_THE_ADVANCED); ?></p>
            <div class="gopremium_btn">
                <a class="btn btn_main" href="<?php echo site_url('premium-account') ?>">
                    <?php echo _clang(GO_PREMIUM_BUTTON_POPUP); ?>
<!--                    <img src="<?php echo base_url(); ?>assets/img/gopremium.png" height="33" width="129" alt="gopremium">-->
                </a></div>
            <div class="gopremium_btn"><a onclick="subcribe_1_submit('subscribe_1');" class="popup_close" href="javascript:void(0);"><?php echo _clang(CONTINUE_P); ?></a></div>
            <div class="gopremium_btn"><label style="color:#808080;"><?php echo _clang(YOU_WILL); ?></label></div>
        </div>
    </div>
    <!-- advace_search_popup end 2 -->
    <!-- advace_search_popup 3 -->
    <div class="popup manage_schedule_popup_3">
        <div class="freeusers_box">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
            <div class="heading"><?php echo _clang(NEWSLETTER_EXACTLY); ?></div>
            <p><?php echo _clang(GET_THE_ADVANCED); ?></p>
            <div class="gopremium_btn">
                <a class="btn btn_main" href="<?php echo site_url('premium-account') ?>">
                    <?php echo _clang(GO_PREMIUM_BUTTON_POPUP); ?>
<!--                    <img src="<?php echo base_url(); ?>assets/img/gopremium.png" height="33" width="129" alt="gopremium">-->
                </a></div>
            <span><?php echo _clang(WITHOUT_SCHEDULING); ?></span>
        </div>
    </div>
    <!-- advace_search_popup end 3 -->
    <!-- notviewdetail -->
    <div class="popup notviewdetail">
        <div class="freeusers_box advancedsearch_popup_box">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
            <div style="margin-top:30px;" class="heading"><?php echo _clang(OUR_EXTENSIVE); ?> <a href="<?php echo site_url('signup') ?>"><?php echo _clang(SIGN_UP_NOW); ?></a>, <?php echo _clang(ITS_FREE_P); ?></div>

        </div>
    </div>
    <!-- notviewdetail end -->
    <!-- uploadavatar -->
    <div class="popup uploadavatar">
        <div class=" uploadavatar_popupbox">
            <div class="gopremium_cancell_btn">
                <a class="popup_close" href="javascript:void(0);">
                    <img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"/>
                </a>
            </div>

            <form id="upload_form" enctype="multipart/form-data" method="post" action="<?php echo site_url('myknewdog/upload_crop_avatar'); ?>" onsubmit="return checkForm();" >
                <!-- hidden crop params -->
                <input type="hidden" id="x1" name="x1" />
                <input type="hidden" id="y1" name="y1" />
                <input type="hidden" id="x2" name="x2" />
                <input type="hidden" id="y2" name="y2" />
                <?php
                $temp = (empty($user)) ? '' : $user[0]['avatar'];
//if (!empty($user)){$user1 = $user[0]['avatar'];}else{$user1 = "";}
                ?>
                <input type="hidden" name="old_avatar" value="<?php echo $temp; ?>" />

                <h2><?php echo _clang(STEP_ONE); ?></h2>
                <div>
                    <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler();" />
                </div>

                <div class="error"></div>

                <div style="display: none; text-align: center;" class="step2">
                    <h2 style="text-align:left;"><?php echo _clang(STEP_TWO); ?></h2>
                    <img id="preview" alt="" src="#" />

                    <div class="info">
                        <label><?php echo _clang(FILE_SIZE); ?></label> <input type="text" id="filesize" name="filesize" />
                        <label><?php echo _clang(TYPE); ?></label> <input type="text" id="filetype" name="filetype" />
                        <label><?php echo _clang(IMAGE_DIMENSION); ?></label> <input type="text" id="filedim" name="filedim" />
                        <label><?php echo _clang(WIDTH); ?></label> <input type="text" id="w" name="w" />
                        <label><?php echo _clang(HEIGHT); ?></label> <input type="text" id="h" name="h" />
                    </div>

                    <input style="margin-bottom:15px;" class="btn btn_main" type="submit" value="Upload" />
                </div>
            </form>
        </div>
    </div>
    <!-- uploadavatar end-->
    <!-- notviewdetail -->
    <div class="popup for_premium_memebers_only">
        <div class="freeusers_box advancedsearch_popup_box">
            <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
            <div style="margin-top:30px; text-align:center;" class="heading"><?php echo _clang(PREMIUM_MEMBERS_ONLY); ?> <a href="<?php echo site_url('premium-account') ?>"><?php echo _clang(GO_PREMIUM); ?></a> <?php echo _clang(NOW); ?> </div>

        </div>
    </div>
    <!-- notviewdetail end -->
</div>
