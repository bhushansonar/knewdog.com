<main>
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

            <section class="home_right">
                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                    <article>

                        <p class="quicksignup_home">Recover your password</p>
                        <form method="post" class="form_home" action="<?php echo site_url('signin/forgot_password') ?>">
                            <input class="emailaddress_home" name="email" type="text" placeholder="<?php echo _clang(YOUR_EMAIL_ADD); ?>"><br/>
                            <!--<input class="signup_btn1" value="Sign Up Now!" name="Submit" type="submit" />-->
                            <input style="margin-top:5px; margin-bottom:5px; font-size: 20px; padding: 10px 23px;" class="btn btn_main" value="<?php echo _clang(SUBMIT_BUTTON);?>" name="Submit" type="submit" />
                        </form>


                    </article>
                <?php } ?>
            </section>
        </section>
    </section>
</main>