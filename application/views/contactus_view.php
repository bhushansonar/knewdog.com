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
          <!--  <section class="homepage" id="container">-->
    <section class="help" id="container">
        <section id="help_leftbar">
            <div class="help_leftbar_inner">
                <div class="page_helptitle">
                    <h2><?php echo _clang(WE_WILL_BE); ?></h2>
                    <p style=" color: #000000;font-size: 18px;"><?php echo _clang(TO_CONTACTUS); ?>:</p>
                </div>

                <div class="form_area">
                    <h1><?php echo _clang(CONTACTUS); ?></h1>

                    <form autocomplete="on" method="post" action="<?php echo site_url('contactus/contactus_data') ?>">

                        <p> <label for="username" class="iconic user"> <?php echo _clang(NAME_CU); ?> <span class="required">*</span></label> <input type="text" name="username" id="username" required="required" 																 					placeholder="<?php echo _clang(HI_FRIENDS); ?>"> </p>

                        <p> <label for="usermail" class="iconic mail-alt"> <?php echo _clang(EMAIL_ADDRESS); ?> <span class="required">*</span></label> <input type="email" name="usermail" id="usermail" placeholder=	 					"<?php echo _clang(I_PROMISE); ?>" required="required"> </p>

                        <p> <label for="usersite" class="iconic link"> <?php echo _clang(WEBSITE); ?> </label> <input type="url" name="usersite" id="usersite" placeholder="<?php echo _clang(EG_CU); ?>"> </p>

                        <p> <label for="subject" class="iconic quote-alt"> <?php echo _clang(SUBJECT); ?> </label> <input type="text" name="subject" id="subject" placeholder="<?php echo _clang(WHAT_WOULD_CU); ?>"> </p>

                        <p> <label for="message"> <?php echo _clang(MESSAGE_CU); ?>  <span class="required">*</span></label> <textarea id="message" name="message" placeholder="<?php echo _clang(DONT_BE_CU); ?> " required="required"></textarea> </p>
                        <div class="comment_recaptcha"><?php echo $recaptcha_html; ?></div>
                        <p class="indication"> <?php echo _clang(ALL_FIELDS_CA); ?> <span class="required">*</span> <?php echo _clang(ARE_REQUIRED_CU); ?></p>

                        <input style="width:114px; margin-left:129px;" type="submit" name="submit" value="<?php echo _clang(SUBMIT_BUTTON) ?>" class="btn btn_main" >		

                    </form>
                </div>
            </div>
        </section>
        <?php include_once("includes/sidebars/help_sidebar.php"); ?>
    </section>
</main>