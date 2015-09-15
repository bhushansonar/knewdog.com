<main>
    <?php
    $user_id = $this->session->userdata("user_id");
    $account_detail = get_gopremium_price($payment);
    $timestamp = strtotime('+' . $account_detail['total_years']);
    $date_to = date('F j, Y', $timestamp);
    $date_today = date('F j, Y');
    $get_user = $this->user_model->get_user_by_id($user_id);
//echo '<pre>'; print_r($account_type);
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
    <section class="homepage" id="container">
        <div class="homepage_inner" style="overflow: hidden;border-bottom: 1px solid #CECECE;">
            <div class="chk_article">
                <p><strong>
                        <span style=" font-size:14px;"><?php echo _clang(CHECK_YOUR) ?></span>
                    </strong>
                </p>
            </div>
            <div id="home_left">
                <div class="form">
                    <!--$paypal_url='https://www.sandbox.paypal.com/cgi-bin/webscr'; // Test Paypal API URL
        $paypal_id='your_seller_id'; // Business email ID-->
                    <form action="<?php echo site_url("premium-account/paypal") ?>" method="post" name="frm1">

                        <input type="hidden" name="payment_type" value="<?php echo $payment ?>" />
                        <input type="hidden" name="date_from" value="<?php echo $date_today ?>" />
                        <input type="hidden" name="date_to" value="<?php echo $date_to ?>" />

<!--<input type="hidden" name="business" value="hardik.amutech@gmail.com">-->
                        <input type="hidden" name="business" value="pay@knewdog.com">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="item_name" value="<?php echo $account_detail['plan'] ?> (<?php echo $account_detail['total_years'] ?>)">
                        <input type="hidden" name="item_number" value="<?php echo generate_invoice_number(); ?>">
                        <input type="hidden" name="quantity" value="<?php echo $account_detail['months_in_years']; ?>">
                        <input type="hidden" name="amount" value="<?php echo $account_detail['month']; ?>">
                        <input type="hidden" name="no_shipping" value="1">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="handling" value="0">
                        <input type='hidden' name='rm' value='2'>
                        <input type="hidden" name="cancel_return" value="<?php echo site_url("home/cancel") ?>">
                        <input type="hidden" name="return" value="https://www.knewdog.com/home/success<?php //echo site_url("home/success")     ?>">

                        <ul>
                            <li><?php echo _clang(FIRSTNAME_C) ?></li>
                            <li class="textbox_li"><input type="text" value="<?php echo $get_user[0]['firstname'] ?>" name="first_name" size="30" /></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(LASTNAME_C) ?></li>
                            <li class="textbox_li"><input type="text" name="last_name" size="30" value="<?php echo $get_user[0]['lastname'] ?>" /></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(COUNTRY_C) ?></li>
                            <li><select name="country" class="chk_selectbox" >
                                    <?php for ($l = 0; $l < count($countries); $l++) { ?>
                                        <option <?php echo ($get_user[0]['country'] == $countries[$l]['id']) ? 'selected="selected"' : '' ?>  value="<?php echo $countries[$l]['country_code'] ?>"><?php echo $countries[$l]['country_name'] ?></option>
                                    <?php } ?>	
                                </select></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(CITY_C) ?></li>
                            <li class="textbox_li"><input type="text" value="<?php echo $get_user[0]['town'] ?>" name="city" size="30" /></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(POSTAL_C) ?></li>
                            <li class="textbox_li"><input value="<?php echo $get_user[0]['zip_code'] ?>" type="text" name="zip" size="30" /></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(ADDRESS_C) ?></li>
                            <li class="textbox_li"><input placeholder="<?php echo _clang(ADDRESS1_C) ?>" type="text" name="address1" size="30" /></li>
                        </ul>
                        <ul>
                            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li class="textbox_li"><input placeholder="<?php echo _clang(ADDRESS2_C) ?>" type="text" name="address2" size="30" /></li>
                        </ul>
                        <ul>
                            <li><?php echo _clang(EMAIL_C) ?></li>
                            <li class="textbox_li"><input value="<?php echo $get_user[0]['primary_email'] ?>" type="text" name="email" size="30" /></li>
                        </ul>
                        <ul>
                            <li style="margin:20px 0px 0px 110px;"><input name="submit" class="btn btn_main" type="submit" value="<?php echo _clang(UPGRADENOW) ?>" /></li>
                            <li class="chk_cancel"><a href="<?php echo site_url("premium-account"); ?>" class="chk_a"><?php echo _clang(CANCEL_C) ?></a></li>
                        </ul>
                    </form>
                </div>
            </div>

            <div style="margin-left:36px;" class="home_right">
                <div class="chk_right">
                    <div class="your_order">
                        <ul>
                            <li class="your_order_space" style="font-size:14px;"><b><?php echo _clang(YOUR_ORDER) ?>:</b></li>
                            <?php
                            
                            if ($account_detail['total_years'] == '1 year') {
                                $account_year = _clang(YEARS1);
                            } else if ($account_detail['total_years'] == '2 years') {
                                $account_year = _clang(YEARS2);
                            } else {
                                $account_year = _clang(YEARS4);
                            }
                            ?>
                            <li class="your_order_space"><b><?php echo $account_detail['plan'] ?> (<?php echo $account_year; ?>)</b><span style="float: right; margin-right: 15px;">$ <?php echo str_replace('.', ',', $account_detail['month']); ?></span></li>
                            <li style="float:right; margin-right:15px"><?php echo _clang(A_MONTH) ?></li>
                            <li class="your_order_space_date"><?php echo _clang(FROM) ?> <?php echo $date_today ?> <?php echo _clang(TO); ?> <?php echo $date_to ?></li>
                        </ul>
                    </div>
                    <div class="calculate">
                        <ul>
                            <li class="calculate_arrange">$ <?php echo str_replace('.', ',', $account_detail['month']); ?> x <?php echo $account_detail['months_in_years']; ?> <?php echo _clang(MONTHS) ?></li>
                            <li class="calculate_arrange">= $ <?php echo str_replace('.', ',', $account_detail['final']); ?></li>
                        </ul>
                    </div>
                    <div class="change">
                        <ul>
                            <li><a href="<?php echo site_url('premium-account'); ?>" style=" "><?php echo _clang(CHANGE) ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="right_bottom">
                    <ul>
                        <li><?php echo _clang(GO_PREMIUM_C) ?></li>
                    </ul>
                </div>

            </div>
        </div>
        <p style="margin-top:25px;" class="flpayment"><?php echo _clang(BY_CLICKING_C) ?></p>
    </section>
</main>