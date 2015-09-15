<main>
    <?php
    $user_id = $this->session->userdata("user_id");
//echo '<pre>'; print_r($user);
//echo '</pre>';
    $pre1_year_4 = get_gopremium_price('pre1_year_4');
    $pre1_year_2 = get_gopremium_price('pre1_year_2');
    $pre1_year_1 = get_gopremium_price('pre1_year_1');

    $pre2_year_4 = get_gopremium_price('pre2_year_4');
    $pre2_year_2 = get_gopremium_price('pre2_year_2');
    $pre2_year_1 = get_gopremium_price('pre2_year_1');
    ?>
    <div class="set_errors">
        <?php
        if ($this->session->flashdata('validation_error_messages')) {
            echo $this->session->flashdata('validation_error_messages');
        }
        echo validation_errors();
        if ($this->session->flashdata('flash_message')) {
            //echo "->".$this->session->flashdata("flash_mynl_tab");
            echo '<div class="alert ' . $this->session->flashdata("flash_class") . '">';
            echo '<a class="close" data-dismiss="alert">&#215;</a>';
            echo $this->session->flashdata("flash_message");
            echo '</div>';
        }
        //echo '<pre>'; print_r($user); die;
        ?>
    </div>
    <section class="knewdog findnewsletter" id="container">
        <section id="knewdog_leftbar">
            <div class="knewdog_leftbar_inner">
                <h2><?php echo _clang(LOREM_IPSUM); ?></h2>
                <p><?php echo _clang(WITH_KNEWDOG); ?></p>
                <div class="pre_true">
                    <ul>
                        <li><?php echo _clang(AT_VERO); ?></li>
                        <li><?php echo _clang(STET); ?> </li>
                        <li><?php echo _clang(LABORE); ?> </li>
                    </ul>
                </div>
                <form name="gopremium" action="<?php echo site_url("premium-account/checkout") ?>" method="post">
                    <div class="pre_true">

                        <div class="twoy"><input onclick="display_tabs('years_4');" type="radio" value="pre1_year_4" name="payment" <?php echo custom_set_radio('payment', 'pre1_year_4', true) ?> class="pre_month">$ <?php echo $pre1_year_4['month']; ?> <?php echo _clang(A_MONTH_4); ?>
                            <div class="pre_bg"><?php echo _clang(SAVE_UP); ?></div></div>
                        <p class="twoy"><input onclick="display_tabs('years_2');" type="radio" name="payment" value="pre1_year_2" class="pre_month">$ <?php echo $pre1_year_2['month']; ?> <?php echo _clang(A_MONTH_2); ?></p>
                        <p class="twoy"><input onclick="display_tabs('years_1');" type="radio" name="payment" value="pre1_year_1" class="pre_month">$ <?php echo $pre1_year_1['month']; ?> <?php echo _clang(A_MONTH_1); ?></p>
                    </div>
                    <div style="margin-top:2px;" class="pre_true">

                        <div class="twoy"><input type="radio" onclick="display_tabs('years_4');" value="pre2_year_4" name="payment" <?php echo custom_set_radio('payment', 'pre2_year_4') ?> class="pre_month">$ <?php echo $pre2_year_4['month']; ?> <?php echo _clang(A_PRE2_MONTH_4); ?></div>
                        <!--<div class="pre_bg">Save up to 33% per Year</div> -->
                        <p class="twoy"><input onclick="display_tabs('years_2');" type="radio" name="payment" value="pre2_year_2" class="pre_month">$ <?php echo $pre2_year_2['month']; ?> <?php echo _clang(A_PRE2_MONTH_2); ?></p>
                        <p class="twoy"><input onclick="display_tabs('years_1');" type="radio" name="payment" value="pre2_year_1" class="pre_month">$ <?php echo $pre2_year_1['month']; ?> <?php echo _clang(A_PRE2_MONTH_1); ?></p>
                    </div>
                    <div class="pre_true">
                        <p>
                            <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                <a style="color: #fff !important" class="btn btn_main" onClick="popup('signin')" href="javascript:void(0)"> <?php echo _clang(LOGIN_TO_GOPREMIUM) ?></a><span onclick="display_compare();" class="memberplan"><a href="javascript:void(0)">> <?php echo _clang(COMPARE_ALL); ?></a></span>

                            <?php } else { ?>
                                <input type="submit" class="btn btn_main" value="<?php echo _clang(GO_PREMIUM) ?>"> <span onclick="display_compare();" class="memberplan"><a href="javascript:void(0)">> <?php echo _clang(COMPARE_ALL); ?></a></span>
                            <?php } ?>

                        </p>
                    </div>
                </form>


                <div class="pre_true">
                    <h3><?php echo _clang(DID_YOU); ?></h3>
                    <p class="our_risk"><?php echo _clang(OUR_RISK_FREE); ?></p>
                </div>
                <section style="display:none;" class="section_compare">
                    <div style="margin-top:20px;" class="cm_main1">
                        <div class="cm_plan1"><h3><?php echo _clang(COMPARE_PLANS); ?></h3></div>
                        <div class="your_plan1"><span class="crplan"><?php echo _clang(YOUR_CURRENT_PLAN); ?></span><h3><?php echo _clang(FREE_GP); ?></h3></div>
                        <div class="prem1"><h3><?php echo _clang(PREMIUM); ?></h3></div>
                        <div class="best_value1"><span class="value"><?php echo _clang(BEST_VALUE); ?></span><h3><?php echo _clang(XXL); ?></h3></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan1">
                            <ul><li><?php echo _clang(PRICING); ?>:</li>
                                <li><a href="javascript:void(0)" onclick="display_tabs(this.id)" id="years_4" class="active"><?php echo _clang(YEARS4); ?></a> </li>
                                <li><a href="javascript:void(0)" onclick="display_tabs(this.id)" id="years_2"><?php echo _clang(YEARS2); ?></a> </li>
                                <li><a href="javascript:void(0)" onclick="display_tabs(this.id)" id="years_1"><?php echo _clang(YEARS1); ?></a> </li>
                            </ul>
                            <p class="safeup"><img alt="<?php echo _clang(SAFE_UP); ?>" src="<?php echo base_url(); ?>assets/img/safeup.png"><?php echo _clang(SAFE_UP); ?></p>
                        </div>
                        <div class="your_plan2"><?php echo _clang(FOREVER_FREE); ?></div>
                        <form class="prem2" name="pre1" action="<?php echo site_url("premium-account/checkout") ?>" method="post">
                            <input type="hidden" class="input_pre1" name="payment" value="" />
                            <div class="">
                                <h5 class="years_4">$ <?php echo $pre1_year_4['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <h5 class="years_2">$ <?php echo $pre1_year_2['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <h5 class="years_1">$ <?php echo $pre1_year_1['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <p class="crplan years_4">($ <?php echo $pre1_year_4['year']; ?> per year)</p>
                                <p class="crplan years_2">($ <?php echo $pre1_year_2['year']; ?> per year)</p>
                                <p class="crplan years_1">($ <?php echo $pre1_year_1['year']; ?> per year)</p>
                                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                    <a style="color: #fff !important" class="btn btn_main" onClick="popup('signin')" href="javascript:void(0)"> <?php echo _clang(LOGIN_TO_GOPREMIUM) ?> </a>
                                <?php } else { ?>
                                    <div class="start_now"><input type="submit" name="submit" value="<?php echo _clang(START_NOW); ?>!" style="white-space: normal;" class="btn btn_main" /></div>
                                <?php } ?>
                                <p class="crplan years_4"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre1_year_4['final']; ?></p>
                                <p class="crplan years_2"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre1_year_2['final']; ?></p>
                                <p class="crplan years_1"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre1_year_1['final']; ?></p>


                            </div>
                        </form>
                        <form class="best_value1" name="pre2" action="<?php echo site_url("premium-account/checkout") ?>" method="post">
                            <input type="hidden" class="input_pre2" name="payment" value="" />
                            <div class="">
                                <h5 class="years_4">$ <?php echo $pre2_year_4['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <h5 class="years_2">$ <?php echo $pre2_year_2['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <h5 class="years_1">$ <?php echo $pre2_year_1['month']; ?> <?php echo _clang(A_MONTH_GP); ?></h5>
                                <p class="crplan years_4">($ <?php echo $pre2_year_4['year']; ?> <?php echo _clang(PER_YEAR); ?>)</p>
                                <p class="crplan years_2">($ <?php echo $pre2_year_2['year']; ?> <?php echo _clang(PER_YEAR); ?></p>
                                <p class="crplan years_1">($ <?php echo $pre2_year_1['year']; ?> <?php echo _clang(PER_YEAR); ?></p>
                                <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                    <a style="color: #fff !important" class="btn btn_main" onClick="popup('signin')" href="javascript:void(0)"> <?php echo _clang(LOGIN_TO_GOPREMIUM) ?></a>
                                <?php } else { ?>
                                    <div class="start_now"><input type="submit" name="submit" value="<?php echo _clang(START_NOW); ?>!" style="white-space: normal;" class="btn btn_main" /></div>
                                <?php } ?>
                                <p class="crplan years_4"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre2_year_4['final']; ?></p>
                                <p class="crplan years_2"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre2_year_2['final']; ?></p>
                                <p class="crplan years_1"><?php echo _clang(TOTAL_FOR); ?>: $ <?php echo $pre2_year_1['final']; ?></p>
                            </div>
                        </form>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(READ_NEWSLETTER); ?></div>
                        <div class="your_plan"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(SUBSCRIBE_TO); ?></div>
                        <div class="your_plan"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(SEARCH_NEWSLETTER); ?></div>
                        <div class="your_plan"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(ADVANCED_SEARCH_GP); ?></div>
                        <div class="your_plan"></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(SCHEDULING_FOR); ?>
                            <p class="schnews"><?php echo _clang(GET_YOUR_NEWSLETTER); ?></p>
                        </div>
                        <div class="your_plan"></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(PRIVACY_PROTECTION); ?>
                            <p class="schnews"><?php echo _clang(ONLY_USER); ?></p>
                        </div>
                        <div class="your_plan"></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(NUMBER_OF_EMAIL); ?>
                            <p class="schnews"><?php echo _clang(WHERE_WE); ?></p>
                        </div>
                        <div class="your_plan">1</div>
                        <div class="prem">3</div>
                        <div class="best_value">3</div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(NUMBER_OF_SCHEDULING); ?>
                            <p class="schnews"><?php echo _clang(FOR_NEWSLETTER); ?></p>
                        </div>
                        <div class="your_plan">0</div>
                        <div class="prem">10</div>
                        <div class="best_value">999</div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(NUMBER_OF_NEWSLETTER); ?>
                            <p class="schnews"><?php echo _clang(FOR_SENDING); ?></p>
                        </div>
                        <div class="your_plan">5</div>
                        <div class="prem">99</div>
                        <div class="best_value">999</div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(NO_ADS); ?>

                        </div>
                        <div class="your_plan"></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(ADULT_CONTENT_GP); ?>

                        </div>
                        <div class="your_plan"></div>
                        <div class="prem"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan"><?php echo _clang(SEPARATE_INVOICE); ?>

                        </div>
                        <div class="your_plan"></div>
                        <div class="prem"></div>
                        <div class="best_value"><img src="<?php echo base_url(); ?>assets/img/true_yellow.png" alt=""></div>
                    </div>
                    <div class="cm_main">
                        <div class="cm_plan">

                        </div>
                        <div class="your_plan"></div>
                        <div class="prem">
                            <form class="" name="pre1" action="<?php echo site_url("premium-account/checkout") ?>" method="post">
                                <input type="hidden" class="input_pre1" name="payment" value="" />
                                <div class="start_now">
                                    <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                        <a style="color: #fff !important" class="btn btn_main" onClick="popup('signin')" href="javascript:void(0)"> <?php echo _clang(LOGIN_TO_GOPREMIUM) ?> </a>
                                    <?php } else { ?>
                                        <input type="submit" name="submit" value="<?php echo _clang(START_NOW); ?>!" class="btn btn_main" style="white-space: normal;"/>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                        <div class="best_value">
                            <form class="" name="pre2" action="<?php echo site_url("premium-account/checkout") ?>" method="post">
                                <input type="hidden" class="input_pre2" name="payment" value="" />
                                <div class="start_now">
                                    <?php if (!$this->session->userdata('is_logged_in')) { ?>
                                        <a style="color: #fff !important" class="btn btn_main" onClick="popup('signin')" href="javascript:void(0)"><?php echo _clang(LOGIN_TO_GOPREMIUM) ?></a>
                                    <?php } else { ?><input type="submit" name="submit" value="<?php echo _clang(START_NOW); ?>!" style="white-space: normal;" class="btn btn_main" />
                                    <?php } ?>
                                </div>
                            </form>


                        </div>
                    </div>


                </section>
                <div class="flpayment"><strong><?php echo _clang(METHOD_PAYMENT); ?>:</strong></div>
                <div class="flpayment"><!--<a href="#"><img src="<?php echo base_url(); ?>assets/img/secure_paypal.jpg"></a>--><!-- PayPal Logo --><table><tr><td></td></tr><tr><td><a href="https://www.paypal.com/in/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup', 'WIPaypal', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700');
                                return false;"><img src="https://www.paypalobjects.com/webstatic/en_IN/mktg/logos/AM_SbyPP_mc_vs_dc_ae.jpg" alt="PayPal Acceptance Mark"></a></td></tr></table><!-- PayPal Logo --></div>
                <p class="flpayment"><?php echo _clang(THIS_CONTRACT); ?></p>
                <p class="flpayment"><?php echo _clang(ALL_PRICES); ?> <a style="text-decoration:underline; font-size:11px !important; color:#808080 !important;" href="<?php echo site_url('legal') ?>"><?php echo _clang(TERM_OF_USE); ?></a> <?php echo _clang(APPLY_BY); ?></p>
                <p class="flpayment">*	<?php echo _clang(YOU_CAN_CANCEL); ?>

                    <?php echo _clang(IF_YOU_CANCEL); ?>
                </p>

            </div>
        </section>

        <?php
        include_once("includes/sidebars/myknewdog_sidebar.php");
        ?>
    </section>
    <script type ="text/javascript">
                            function display_compare() {
                                if ($(".section_compare").is(':hidden')) {
                                    //$(".section_compare").css("display","block")
                                    $(".section_compare").fadeIn();
                                    display_tabs('years_4');
                                    var payment = $("input[name=payment]:checked").val();
                                    var year = payment.split("_");
                                    if (year[2] == 1) {
                                        display_tabs('years_1');
                                    } else if (year[2] == 2) {
                                        display_tabs('years_2');
                                    } else if (year[2] == 4) {
                                        display_tabs('years_4');
                                    }

                                } else {
                                    $(".section_compare").css("display", "none")
                                }
                            }
                            function display_tabs(id) {
                                //var num = id.split("_");
                                $(".cm_plan1 li a").removeClass("active");
                                $("#" + id).addClass("active");
                                $(".years_4").css("display", "none");
                                $(".years_2").css("display", "none");
                                $(".years_1").css("display", "none");
                                $("." + id).fadeIn();
                                if ($(".years_4").is(':visible')) {
                                    //alert("year4");
                                    $(".input_pre1").val("pre1_year_4");
                                    $(".input_pre2").val("pre2_year_4");
                                } else if ($(".years_2").is(':visible')) {

                                    $(".input_pre1").val("pre1_year_2");
                                    $(".input_pre2").val("pre2_year_2");
                                } else if ($(".years_1").is(':visible')) {

                                    $(".input_pre1").val("pre1_year_1");
                                    $(".input_pre2").val("pre2_year_1");
                                }
                            }

                            display_tabs('years_4');

    </script>
</main>