<main>
    <section class="homepage" id="container">
        <div class="homepage_inner">
            <article style="margin:30px auto 19px 0;">
                <div style="margin:0 0 0.8125em; font-weight:bold; font-size:190%;"><?php echo _clang(HOME_HEAD_TEXT); ?></div>
                <p><strong>
                        <span style=" font-size:large;"><?php echo _clang(HOME_SUB_TEXT); ?></span>
                    </strong>
                </p>
            </article>
            <div id="home_left">
                <img src="<?php echo base_url(); ?>assets/img/formimg_home.PNG" alt="">
            </div>

            <div id="home_right">
                <div class="topheader">
                    <ul>
                        <li class="signinwith"><?php echo _clang(SIGN_IN_WITH); ?></li>
                        <li class="facebook"><img src="<?php echo base_url(); ?>assets/img/facebook.png" alt=""><?php echo _clang(FACEBOOK); ?></li>
                        <li class="google"><img src="<?php echo base_url(); ?>assets/img/google.png" alt=""><?php echo _clang(GOOGLE); ?></li>
                    </ul>
                </div>
                <br/>
                <p class="quicksignup_home"><?php echo _clang(QUICK_SING_UP); ?></p>
                <form class="form_home">
                    <input class="username_home" name="" type="text" placeholder="Username">
                    <input class="emailaddress_home" name="" type="text" placeholder="Your e-mail address">
                    <input class="signup_btn" name="" type="button">
                </form>
                <p class="freeaccount quicksignup_home"><?php echo _clang(FOR_A_FREE_ACCOUNT); ?></p>
                <span class="freeaccount_text">
                    <?php echo _clang(AND_FROM_NOW); ?>
                    <br/>
                    <span class="learnmore_home"><?php echo _clang(LEARN_MORE_H); ?>...</span>
                </span>
            </div>
        </div>
    </section>
</main>