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
    //echo "<pre>";print_r($google_login);exit;
    if (!empty($google_login['authUrl'])) { //user is not logged in, show login button
        $googleurl1 = @$google_login['authUrl'];
        $googleurl = htmlspecialchars($googleurl1);
    } else {
        $googleurl = "#";
    }
    ?>
    <div class="set_errors">
        <?php
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {

            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        ?>
    </div>
    <div class="homepage" id="container">
        <div class="homepage_inner">
            <div style="margin:30px auto 19px 0;">
                <?php echo cms_block('HOME_TOP'); ?>

            </div>

            <div id="home_left">
                <?php echo cms_block('HOME_IMAGE'); ?>
            </div>

            <div class="home_right">
                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                    <div class="topheader">
                        <ul>
                            <li class="signinwith"><?php echo _clang(SIGN_IN_WITH); ?></li>
                            <li class="facebook"><a onClick="javascript:void window.open('<?php echo $facebookurl; ?>', 'fb_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                    return false;" href="<?php echo $facebookurl ?>"><img  height="26" width="26" src="<?php echo base_url(); ?>assets/img/facebook.png" alt="facebook" ><?php echo _clang(FACEBOOK); ?></a></li>
                            <li class="google"><a onClick="javascript:void window.open('<?php echo $googleurl; ?>', 'g_popup', 'width=600,height=300,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
                                    return false;" href="<?php echo $googleurl ?>"><img  height="26" width="26" src="<?php echo base_url(); ?>assets/img/google.png" alt="google" ><?php echo _clang(GOOGLE); ?></a></li>
                        </ul>
                    </div>
                    <br/>
                    <p class="quicksignup_home"><?php echo _clang(QUICK_SING_UP); ?></p>
                    <form method="post" class="form_home" action="<?php echo site_url('signup/create_member') ?>">
                        <input type="hidden" name="redirect" value="home" />
                        <input class="username_home" name="username" type="text" placeholder="<?php echo _clang(USERNAME); ?>">
                        <input class="emailaddress_home" name="email" type="text" placeholder="<?php echo _clang(YOUR_EMAIL_ADD); ?>"><br/>
                        <input class="btn btn_main" style="margin-top: 5px; font-size: 20px; padding: 10px 23px;" value="<?php echo _clang(SIGN_UP_BUTTON); ?>" name="Submit" type="submit" />
                    </form>
                    <p class="freeaccount quicksignup_home"><?php echo _clang(FOR_A_FREE_ACCOUNT); ?></p>
                <?php } ?>
                <?php /* ?><span class="freeaccount_text">
                  <?php echo _clang(AND_FROM_NOW);?>
                  <br/>
                  <span class="learnmore_home"><?php echo _clang(LEARN_MORE_H);?>...</span>
                  </span><?php */ ?>
                <?php echo cms_block('HOME_SIGN_UP_BOTTOM'); ?>
            </div>
        </div>
    </div>
</main>