<?php
//echo $cls; die;
$lang = $this->session->userdata('language_shortcode');
$data = '';
if ($cls == 'subscribe_1') {
    if (count($subscribe_users) >= $allow_subscription) {
        $data = '<div class="popup_ajax manage_schedule_popup_2" style="display: block;">
        <div class="freeusers_box subscribetonewsletter_popup" style="height:90px;">
            <div class="gopremium_cancell_btn"><a href="javascript:void(0);" class="popup_close"><img width="18" height="17" alt="gopremiumcancell" src="' . base_url() . '/assets/img/gopremiumcancell.png"></a></div>
            <div class="heading">';
        if ($type_of_membership == 'FREE') {
            $data .= _clang(POPUP_MSG_ALLOW_SUBSCRIPTION_FREE);
        } else if ($type_of_membership == 'PRE1') {
            $data .= _clang(POPUP_MSG_ALLOW_SUBSCRIPTION_PRE1);
        } else if ($type_of_membership == 'PRE2') {
            $data .= _clang(POPUP_MSG_ALLOW_SUBSCRIPTION_PRE2);
        }

        $data .= '</div>
            <div class="gopremium_btn">
            <a class="btn btn_main" href="' . base_url() . '/premium-account">
               ' . _clang(GO_PREMIUM_BUTTON_POPUP) . '
                </a>
                </div>
        </div>
    </div>';
    } else {
        if (count($subscribe) == 0) {
            $data = '<div class="popup_ajax subscribe_1">
	<form method="post" name="subscribe_1" id="subscribe_1" action="' . site_url('subscribe/add') . '">
	<div class="subscribetonewsletters votebox">
    <div class="head_title">' . _clang(SUBSCRIBE) . ':<label id="popup_nl_title">' . $newsletter[0]['newsletter_name'] . '</label></div>
    <input type="hidden" id="s_newsletter_id" name="s_newsletter_id" value="' . $newsletter[0]['newsletter_id'] . '" />
    <input type="hidden" id="s_user_id" name="s_user_id" value="' . $user_id . '" />
    <div class="title">' . _clang(CHOOSE_ONE) . ':</div>

	<div class="jumpmenu ' . get_if_free_user('class_free_user') . '">
		<div class="' . get_if_free_user('class_free_user_overlay_3') . '" ' . get_if_free_user('manage_schedule_popup_2') . ' ></div>
        <select name="schedule_id">';
            for ($i = 0; $i < count($schedule); $i++) {

                $sending_value = $schedule[$i]['sending'];
                $ending = $schedule[$i]['ends'];
                $sending_content = $this->user_model->get_translate_languages('en', array("'$sending_value'"));
                $ending_content = $this->user_model->get_translate_languages('en', array("'$ending'"));
                $days_value = "";
                $lang = $this->session->userdata('language_shortcode');
                if (!empty($schedule[$i]['weeks_on'])) {
                    $weeks_on_d_remove_comma = str_replace(',', ' ', $schedule[$i]['weeks_on']);
                    $weeks_on_d_t = explode(" ", $weeks_on_d_remove_comma);
                    $main_weeks_on_d_t = "'" . implode("','", $weeks_on_d_t) . "'";
                    $weeks_on_d_t_one = $this->user_model->get_translate_languages('en', array("$main_weeks_on_d_t"));
                    $weeks_on_d_t1 = array();
                    for ($w = 0; $w < count($weeks_on_d_t_one); $w++) {
                        if ($lang == 'de') {
                            $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['de'];
                        } elseif ($lang == 'fr') {
                            $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['fr'];
                        } else {
                            $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['en'];
                        }
                    }
                    $days_value = implode(", ", $weeks_on_d_t1);
                } elseif (!empty($schedule[$i]['monthly_on'])) {
                    $monthly_weekday_day[] = $schedule[$i]['monthly_weekday_day'];
                    $main_monthly_on_d_t = "'" . implode("','", $monthly_weekday_day) . "'";
                    $monthly_on_d_t_one = $this->user_model->get_translate_languages('en', array("$main_monthly_on_d_t"));
                    $monthly_on = array();
                    for ($m = 0; $m < count($monthly_on_d_t_one); $m++) {
                        if ($lang == 'de') {
                            $monthly_on = $monthly_on_d_t_one[$m]['de'];
                        } elseif ($lang == 'fr') {
                            $monthly_on = $monthly_on_d_t_one[$m]['fr'];
                        } else {
                            $monthly_on = $monthly_on_d_t_one[$m]['en'];
                        }
                    }
                }

                if (!empty($schedule[$i]['day_of_the_month'])) {
                    //echo 'comming';
                    $last_days_main_value = array();
                    if ($schedule[$i]['day_of_the_month'] == 'last_day') {
                        $last_days_var = 'Last day';
                        $last_days[] = $last_days_var;
                        $last_days_arr = "'" . implode("','", $last_days) . "'";
                        //echo $last_days_arr;
                        $last_days_value = $this->user_model->get_translate_languages('en', array("$last_days_arr"));

                        $last_days_main_arr = array();
                        for ($l = 0; $l < count($last_days_value); $l++) {
                            if ($lang == 'de') {
                                $last_days_main_arr = $last_days_value[$l]['de'];
                            } elseif ($lang == 'fr') {
                                $last_days_main_arr = $last_days_value[$l]['fr'];
                            } else {
                                $last_days_main_arr = $last_days_value[$l]['en'];
                            }
                        }
                        $last_days_main_value = $last_days_main_arr;
                    } else {
                        $last_days_main_value = ordinalize($schedule[$i]['day_of_the_month']);
                    }
                }

                if ($lang == 'de') {
                    $final_sending_content = $sending_content[0]['de'];
                    $after_keyword_content = $ending_content[0]['de'];
                } elseif ($lang == 'fr') {
                    $final_sending_content = $sending_content[0]['fr'];
                    $after_keyword_content = $ending_content[0]['fr'];
                } else {
                    $final_sending_content = $sending_content[0]['en'];
                    $after_keyword_content = $ending_content[0]['en'];
                }

                if ($schedule[$i]['sending'] == 'Daily') {

                    $senddata = _clang(DAYS_ON);
                } else if ($schedule[$i]['sending'] == "Weekly") {
                    $senddata = _clang(WEEK_ON);
                } else if ($schedule[$i]['sending'] == "Monthly") {
                    $senddata = _clang(MONTH_ON);
                }

                if ($schedule[$i]['every'] == 'last_day') {
                    $every_temp = "last month";
                } else {
                    $every_temp = $schedule[$i]['every'];
                }
                $every_d = _clang(EVERY) . " " . $every_temp . " " . $senddata;

                if ($schedule[$i]['ends'] == "Never") {
                    $ends_in = _clang(ENDS) . " " . $after_keyword_content;
                } else if ($schedule[$i]['ends'] == "after") {
                    $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_after'] . " " . _clang(OCCURRENCES);
                } else if ($schedule[$i]['ends'] == "on") {
                    $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_on'];
                }
                //echo $schedule[$i]['day_of_the_month'];exit;
                $monthly_content = "";
                $monthly_content .=($schedule[$i]['monthly_on'] == 'day_of_the_month') ? _clang(ON) . " " . $last_days_main_value . " " : " ";
                $monthly_content .=($schedule[$i]['monthly_on'] == 'weekday') ? _clang(ON) . " " . $schedule[$i]['monthly_weekday_count'] . " " . $monthly_on . " " : "";
                $data .='<option value="' . $schedule[$i]['schedule_id'] . '">' . $final_sending_content . " " . $every_d . " " . $days_value . " " . $monthly_content . " " . _clang(AT) . " " . date("H.i", strtotime($schedule[$i]['at'] . ":00:00")) . " " . _clang(TO) . " " . _clang(EMAIL_C) . " " . $schedule[$i]['sending_to_email'] . " " . $ends_in . "</option>";
            }
            $data .='</select>
    </div>
    <div class="link_button">
		<div class="' . get_if_free_user('class_free_user_overlay_4') . '" ' . get_if_free_user('manage_schedule_popup_2') . ' ></div>
             <div class="left_link"><a onclick="submitform(\'gotoschedule\')" href="javascript:void(0)">' . _clang(MANAGE_SCHEDULE) . '</a></div>
        <div class="right_button"><input style="margin-bottom: 5px; float: right; margin-top: 1px; padding-left: 18px; padding-right: 18px;" onclick="subcribe_1_submit(\'subscribe_1\');" class="btn btn_main" value="ok" name="Submit" type="button" /><a href="#" class="cancel popup_close">' . _clang(CANCEL_P_A) . '</a></div>
    </div>
	</form>
         <form id="gotoschedule" action="' . site_url('myknewdog') . '" method="post">
                                <input type="hidden" name="form" value="section_3" />
                            </form>

</div>';
        } else {
            $data = '<div class="popup_ajax subscribe_1">
			<div class="subscription_compeleted votebox">
				<div class="gopremium_cancell_btn"><a class="popup_close" onclick="submitform(\'gotonl\')" href="javascript:void(0);"><img src="' . site_url('assets/img/cancel_white.png') . '" alt=""></a></div>
				<div class="head_title">' . _clang(MANAGE_SCHEDULE) . ':</div>
				<div class="title">' . $newsletter[0]['newsletter_name'] . '</div>
				<div class="content">
					' . _clang(WE_WILL) . ' <a onclick="submitform(\'gotomynl\')" href="javascript:void(0);">' . _clang(MY_NEWSLETTERS_PA) . '</a>
				</div>
			</div>
		</div><form method="post" id="gotomynl" action="' . site_url('newsletter') . '">
			<input type="hidden" name="form" value="section_2"/>
		</form>
		<form method="post" id="gotonl" action="' . site_url('newsletter') . '"></form>';
        }
    }
} else if ($cls == 'subscribe_1_edit') {


    $data = '<div class="popup_ajax subscribe_1_edit">

	<form method="post" name="subscribe_1" id="subscribe_1" action="' . site_url('subscribe/edit') . '">
	<div class="subscribetonewsletters votebox">
    <div class="head_title">Subscribe to Newsletter:<label id="popup_nl_title">' . $newsletter[0]['newsletter_name'] . '</label></div>
    <input type="hidden" id="s_newsletter_id" name="s_newsletter_id" value="' . $newsletter[0]['newsletter_id'] . '" />
    <input type="hidden" id="s_user_id" name="s_user_id" value="' . $user_id . '" />
    <div class="title">' . _clang(CHOOSE_ONE_PA) . ':</div>

	<div class="jumpmenu ' . get_if_free_user('class_free_user') . '">
		<div class="' . get_if_free_user('class_free_user_overlay_3') . '" ' . get_if_free_user('manage_schedule_popup_2') . ' ></div>
       <select name="schedule_id">';
    for ($i = 0; $i < count($schedule); $i++) {

        $sending_value = $schedule[$i]['sending'];
        $ending = $schedule[$i]['ends'];
        $sending_content = $this->user_model->get_translate_languages('en', array("'$sending_value'"));
        $ending_content = $this->user_model->get_translate_languages('en', array("'$ending'"));
        $days_value = "";
        $lang = $this->session->userdata('language_shortcode');
        if (!empty($schedule[$i]['weeks_on'])) {
            $weeks_on_d_remove_comma = str_replace(',', ' ', $schedule[$i]['weeks_on']);
            $weeks_on_d_t = explode(" ", $weeks_on_d_remove_comma);
            $main_weeks_on_d_t = "'" . implode("','", $weeks_on_d_t) . "'";
            $weeks_on_d_t_one = $this->user_model->get_translate_languages('en', array("$main_weeks_on_d_t"));
            $weeks_on_d_t1 = array();
            for ($w = 0; $w < count($weeks_on_d_t_one); $w++) {
                if ($lang == 'de') {
                    $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['de'];
                } elseif ($lang == 'fr') {
                    $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['fr'];
                } else {
                    $weeks_on_d_t1[] = $weeks_on_d_t_one[$w]['en'];
                }
            }
            $days_value = implode(", ", $weeks_on_d_t1);
        } elseif (!empty($schedule[$i]['monthly_on'])) {
            $monthly_weekday_day[] = $schedule[$i]['monthly_weekday_day'];
            $main_monthly_on_d_t = "'" . implode("','", $monthly_weekday_day) . "'";
            $monthly_on_d_t_one = $this->user_model->get_translate_languages('en', array("$main_monthly_on_d_t"));
            $monthly_on = array();
            for ($m = 0; $m < count($monthly_on_d_t_one); $m++) {
                if ($lang == 'de') {
                    $monthly_on = $monthly_on_d_t_one[$m]['de'];
                } elseif ($lang == 'fr') {
                    $monthly_on = $monthly_on_d_t_one[$m]['fr'];
                } else {
                    $monthly_on = $monthly_on_d_t_one[$m]['en'];
                }
            }
        }



        if ($lang == 'de') {
            $final_sending_content = $sending_content[0]['de'];
            $after_keyword_content = $ending_content[0]['de'];
        } elseif ($lang == 'fr') {
            $final_sending_content = $sending_content[0]['fr'];
            $after_keyword_content = $ending_content[0]['fr'];
        } else {
            $final_sending_content = $sending_content[0]['en'];
            $after_keyword_content = $ending_content[0]['en'];
        }

        if ($schedule[$i]['sending'] == 'Daily') {
            $senddata = _clang(DAYS_ON);
        } else if ($schedule[$i]['sending'] == "Weekly") {
            $senddata = _clang(WEEK_ON);
        } else if ($schedule[$i]['sending'] == "Monthly") {
            $senddata = _clang(MONTH_ON);
        }

        if ($schedule[$i]['every'] == 'last_day') {
            $every_temp = "last month";
        } else {
            $every_temp = $schedule[$i]['every'];
        }
        $every_d = _clang(EVERY) . " " . $every_temp . " " . $senddata;
        $selected_edit = ($schedule_id == $schedule[$i]['schedule_id']) ? "selected='selected'" : "";
        if ($schedule[$i]['ends'] == "Never") {
            $ends_in = _clang(ENDS) . " " . $after_keyword_content;
        } else if ($schedule[$i]['ends'] == "after") {
            $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_after'] . " " . _clang(OCCURRENCES);
        } else if ($schedule[$i]['ends'] == "on") {
            $ends_in = _clang(ENDS) . " " . $after_keyword_content . " " . $schedule[$i]['ends_on'];
        }
        $monthly_content = "";
        $monthly_content .=($schedule[$i]['monthly_on'] == 'day_of_the_month') ? _clang(ON) . " " . ordinalize($schedule[$i]['day_of_the_month']) . " " : " ";
        $monthly_content .=($schedule[$i]['monthly_on'] == 'weekday') ? _clang(ON) . " " . $schedule[$i]['monthly_weekday_count'] . " " . $monthly_on . " " : "";
        $data .='<option ' . $selected_edit . ' value="' . $schedule[$i]['schedule_id'] . '">' . $final_sending_content . " " . $every_d . " " . $monthly_content . " " . $days_value . " " . _clang(AT) . " " . date("H.i", strtotime($schedule[$i]['at'] . ":00:00")) . " " . _clang(TO_EMAIL) . " " . $schedule[$i]['sending_to_email'] . " " . $ends_in . "</option>";
    }
    $data .='</select>
    </div>
    <div class="link_button">
		<div class="' . get_if_free_user('class_free_user_overlay_4') . '" ' . get_if_free_user('manage_schedule_popup_2') . ' ></div>
        <div class="left_link"><a onclick="submitform(\'gotoschedule\')" href="javascript:void(0)">' . _clang(NEW_SCHEDULE_PA) . '</a></div>
        <div class="right_button"><input style="margin-bottom: 5px; float: right; margin-top: 1px; padding-left: 18px; padding-right: 18px;" class="btn btn_main" value="' . _clang(OK_BUTTON) . '" name="Submit" type="submit" /><a href="#" class="cancel popup_close">' . _clang(CANCEL_P_A) . '</a></div>
    </div>
	</form>
        <form id="gotoschedule" action="' . site_url('myknewdog') . '" method="post">
                                <input type="hidden" name="form" value="section_3" />
                            </form>

</div>';
} elseif ($cls == 'subscribe_success') {

    $data = '<div class="popup_ajax subscribe_success">
			<div class="subscription_compeleted votebox">
				<div class="gopremium_cancell_btn"><a class="popup_close" onclick="submitform(\'gotonl\')" href="javascript:void(0);"><img src="' . site_url('assets/img/cancel_white.png') . '" alt=""></a></div>
				<div class="head_title">' . _clang(SUBSCRIPTION) . ':</div>
				<div class="title">' . $newsletter[0]['newsletter_name'] . '</div>
				<div class="content">
					' . _clang(WE_WILL_SEND) . ' <a onclick="submitform(\'gotomynl\')" href="javascript:void(0);">' . _clang(MY_NEWSLETTERS_PA) . '</a>
				</div>
			</div>
		</div>
		<form method="post" id="gotomynl" action="' . site_url('newsletter') . '">
			<input type="hidden" name="form" value="section_2"/>
		</form>
		<form method="post" id="gotonl" action="' . site_url('newsletter') . '"></form>';
} else if ($cls == 'schedule') {
    $data = '<div class="popup_ajax schedule">
					<div style="width:648px;" id="" class=" signup_popup">
						<div class="popup_heading">' . _clang(EDIT_MY) . '</div>
		  					<div class="popup_cancle"><a style="opacity:1;" class="popup_close" href="#"><img height="32" width="32" src="' . base_url() . 'assets/img/popup-close.png" alt="Popup Close"></a></div>
		  						<div class="signupfree" class=" popup_signupfree">
										<form style="padding-left: 38px; padding-top: 10px;" id="schedule_form_popup" name="schedule_form" method="post" action="' . site_url('myknewdog/schedule_edit') . '">

                            <input type="hidden" name="form" value="section_3" />
							<input type="hidden" name="schedule_id" value="' . $schedule[0]['schedule_id'] . '" />
                            <div class="sendingtoemail">
                                <label>' . _clang(SENDING_TO) . ':</label>

                                	<input type="hidden" name="sd_user_id" value="' . $user[0]['user_id'] . '" />
                                    <select style="float:left;" onchange="schedule_summary(\'popup\')" name="sending_to_email">';
    $sending = ($schedule[0]['sending_to_email'] == $user[0]['primary_email']) ? "selected='selected'" : "";
    $data .='<option ' . $sending . ' value="' . $user[0]['primary_email'] . '">' . $user[0]['primary_email'] . '</option>';
    for ($e = 0; $e < count($additional_email); $e++) {
        $sending = ($schedule[0]['sending_to_email'] == $additional_email[$e]['email']) ? "selected='selected'" : "";
        $data .='<option ' . $sending . ' value="' . $additional_email[$e]['email'] . '">' . $additional_email[$e]['email'] . '</option>';
    }
    $data .='</select>

                            </div>
                            <section id="sendingtoemail_type">
                            <div class="sending row">
                                <div class="heading">' . _clang(SENDING) . ':</div>
								<span style="display:none;" id="schedule_sending">' . $schedule[0]['sending'] . '</span>
                                <p>
                                    <label>';
    $sending_1 = ($schedule[0]['sending'] == "Daily") ? "checked='checked'" : "";
    $data .='<input ' . $sending_1 . ' onclick="schedule_set(this.id,\'popup\'); schedule_summary(\'popup\');" type="radio" id="Daily"  value="Daily" name="sending">' . _clang(DAILY) . '</label>
                                    <br>
                                    <label>';
    $sending_2 = ($schedule[0]['sending'] == "Weekly") ? "checked='checked'" : "";
    $data .='<input ' . $sending_2 . ' onclick="schedule_set(this.id,\'popup\'); schedule_summary(\'popup\');" type="radio" id="Weekly"  value="Weekly" name="sending">' . _clang(WEEKLY) . '</label>
                                    <br>
                                    <label>';
    $sending_3 = ($schedule[0]['sending'] == "Monthly") ? "checked='checked'" : "";
    $data .='<input ' . $sending_3 . ' onclick="schedule_set(this.id,\'popup\'); schedule_summary(\'popup\');" type="radio" id="Monthly" value="Monthly" name="sending">' . _clang(MONTHLY) . '</label>
                                    <br>
                                </p>

                            </div>
                            <div class="everyweekson row">
                                <div class="heading"><label class="head_lable">' . _clang(EVERY) . ':</label>
								<span style="float:none;" class="every_fields" id="every_field">';
    if ($schedule[0]['sending'] == "Daily") {
        $data .='<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Daily" name="every" title="">';
        for ($c = 1; $c <= 30; $c++) {
            if ($c == $schedule[0]['every']) {
                $sele_every = 'selected="selected"';
            } else {
                $sele_every = '';
            }
            $data .='<option ' . $sele_every . ' value="' . $c . '">' . $c . '</option>';
        }
        $days = _clang(DAYS_ON);
        $data .='<option value="last_day">Last Day</option></select>' . $days;
        $weeks_on_2_class = "display:none;";
        $week_on_class = "display:block;";
    } else if ($schedule[0]['sending'] == "Weekly") {

        $data .='<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Weekly" name="every" title="">';
        for ($c = 1; $c <= 5; $c++) {
            if ($c == $schedule[0]['every']) {
                $sele_every = 'selected="selected"';
            } else {
                $sele_every = '';
            }
            $data .='<option ' . $sele_every . ' value="' . $c . '">' . $c . '</option>';
        }
        $data .='</select> Week(s)';
        $weeks_on_2_class = "display:none;";
        $week_on_class = "display:block;";
    } else if ($schedule[0]['sending'] == "Monthly") {

        $data .='<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Monthly" name="every" title="">';
        for ($c = 1; $c <= 12; $c++) {
            if ($c == $schedule[0]['every']) {
                $sele_every = 'selected="selected"';
            } else {
                $sele_every = '';
            }
            $data .='<option ' . $sele_every . ' value="' . $c . '">' . $c . '</option>';
        }
        $data .='</select> Month(s)';
        $weeks_on_2_class = "display:block;";
        $week_on_class = "display:none;";
    }
    $data .='</span></div>
	<div class="weeks_on" style="' . $week_on_class . '">
		<div style="float:left;">';
    $weeks_on = explode(",", $schedule[0]['weeks_on']);
    //print_r($weeks_on);
    $weeks_on_1 = (in_array("Monday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_1 . ' type="checkbox" value="Monday" name="weeks_on[]"><label>' . _clang(MONDAY) . '</label></div>';
    $weeks_on_2 = (in_array("Tuesday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_2 . ' type="checkbox" value="Tuesday" name="weeks_on[]"><label>' . _clang(TUESDAY) . '</label></div>';
    $weeks_on_3 = (in_array("Wednesday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_3 . ' type="checkbox" value="Wednesday" name="weeks_on[]"><label>' . _clang(WEDNESDAY) . '</label></div>';
    $weeks_on_4 = (in_array("Thursday", $weeks_on)) ? "checked='checked'" : "";
    $data .= '<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_4 . ' type="checkbox" value="Thursday" name="weeks_on[]"><label>' . _clang(THURSDAY) . '</label></div>
                                    </div>
                                    <div style="float:right;">';
    $weeks_on_5 = (in_array("Friday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_5 . ' type="checkbox" value="Friday" name="weeks_on[]"><label>' . _clang(FRIDAY) . '</label></div>';
    $weeks_on_6 = (in_array("Saturday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_6 . ' type="checkbox" value="Saturday" name="weeks_on[]"><label>' . _clang(SATURDAY) . '</label></div>';
    $weeks_on_7 = (in_array("Sunday", $weeks_on)) ? "checked='checked'" : "";
    $data .='<div><input onclick="schedule_summary(\'popup\');" ' . $weeks_on_7 . ' type="checkbox" value="Sunday" name="weeks_on[]"><label>' . _clang(SUNDAY) . '</label></div>
                                    </div>
                            </div>';
    $data .= '<div style="width:220px; ' . $weeks_on_2_class . '" class="weeks_on_2">';
    $monthly_on1 = ($schedule[0]['monthly_on'] == 'day_of_the_month') ? "checked='checked'" : "";
    $data .= '<div><input ' . $monthly_on1 . ' type="radio" name="monthly_on" value="day_of_the_month" onclick="schedule_summary(\'popup\');"><label>' . _clang(DAY_OF_MONTH) . '</label>
                                            	<span id="day_of_the_month">
                                                	<select onchange="schedule_summary(\'popup\');" style="width:91px;" id="current_Daily" name="day_of_the_month" title="">';
    if ($schedule[0]['day_of_the_month'] == 'last_day') {
        $data .= '<option value="last_day">Last Day</option>';
    }
    for ($m = 1; $m <= 30; $m++) {
        if ($m == $schedule[0]['day_of_the_month']) {
            $sele_day_of_the_month = 'selected="selected"';
        } else {
            $sele_day_of_the_month = '';
        }
        $data .='<option ' . $sele_day_of_the_month . ' value="' . $m . '">' . $m . '</option>';
    } $data .= '<option value="last_day">Last Day</option>';

    '</select>
                                                 </span>
                                             </div>
                                         	<div style="width: 175px;">';
    $monthly_on2 = ($schedule[0]['monthly_on'] == 'weekday') ? "checked='checked'" : "";
    $data .= '<input ' . $monthly_on2 . ' type="radio" name="monthly_on" value="weekday" onclick="schedule_summary(\'popup\');">
        <label>' . _clang(WEEKDAY) . '</label>
                                            <span id="weekday">
                                            	<select style="width:50px;" onchange="schedule_summary(\'popup\');" id="" name="monthly_weekday_count" title="">';
    for ($mw = 1; $mw <= 5; $mw++) {
        if ($mw == $schedule[0]['monthly_weekday_count']) {
            $sele_monthly_weekday_count = 'selected="selected"';
        } else {
            $sele_monthly_weekday_count = '';
        }
        $data .='<option ' . $sele_monthly_weekday_count . ' value="' . $mw . '">' . $mw . '.</option>';
    }

    $data .= '</select>
                                             </span>
                                             <span style="float: right;">
                                             	<select style="width:91px;" onchange="schedule_summary(\'popup\');"  id="" name="monthly_weekday_day" title="">';

    $monthly_Monday = ($schedule[0]['monthly_weekday_day'] == 'Monday') ? 'selected="selected"' : "";
    $monthly_Tuesday = ($schedule[0]['monthly_weekday_day'] == 'Tuesday') ? 'selected="selected"' : "";
    $monthly_Wednesday = ($schedule[0]['monthly_weekday_day'] == 'Wednesday') ? 'selected="selected"' : "";
    $monthly_Thursday = ($schedule[0]['monthly_weekday_day'] == 'Thursday') ? 'selected="selected"' : "";
    $monthly_Friday = ($schedule[0]['monthly_weekday_day'] == 'Friday') ? 'selected="selected"' : "";
    $monthly_Saturday = ($schedule[0]['monthly_weekday_day'] == 'Saturday') ? 'selected="selected"' : "";
    $monthly_Sunday = ($schedule[0]['monthly_weekday_day'] == 'Sunday') ? 'selected="selected"' : "";
    $data .='<option ' . $monthly_Monday . ' value="Monday">' . _clang(MONDAY) . '</option>
													<option ' . $monthly_Tuesday . ' value="Tuesday">' . _clang(TUESDAY) . '</option>
													<option ' . $monthly_Wednesday . ' value="Wednesday">' . _clang(WEDNESDAY) . '</option>
													<option ' . $monthly_Thursday . ' value="Thursday">' . _clang(THURSDAY) . '</option>
													<option ' . $monthly_Friday . ' value="Friday">' . _clang(FRIDAY) . '</option>
													<option ' . $monthly_Saturday . ' value="Saturday">' . _clang(SATURDAY) . '</option>
													<option ' . $monthly_Sunday . ' value="Sunday">' . _clang(SUNDAY) . '</option>
												</select>
                                                </span>
                                             </div>
                                         </div>
									</div>
                            <div class="time row">
                                <div class="heading"><label>' . _clang(AT) . ':</label>

                                    <select  onchange="schedule_summary(\'popup\');" name="at">';
    for ($i = 0; $i < 24; $i++) {
        $at_1 = ($schedule[0]['at'] == $i) ? "selected='selected'" : "";
        $data .='<option ' . $at_1 . ' value="' . $i . '">' . date("H.i", strtotime($i . ":00:00")) . '</option>';
    }
    $data .='</select>

                                </div>
                                <label>' . _clang(ENDS) . ':</label>

                                <p style="margin-left:63px;">
                                    <label style="width:185px;">';
    $ends_1 = ($schedule[0]['ends'] == 'Never') ? "checked='checked'" : "";
    $data .='<input onclick="schedule_summary(\'popup\');" ' . $ends_1 . ' type="radio" id="" value="Never" name="ends">
                                    <label>' . _clang(NEVER) . '</label>
                                    </label>
                                    <br>
                                    <label style="width:185px;">
                                    <label for="ends_after1">';
    $ends_2 = ($schedule[0]['ends'] == 'after') ? "checked='checked'" : "";
    $data .='<input onclick="schedule_summary(\'popup\');" ' . $ends_2 . ' type="radio" id="" value="after" name="ends" id="ends1">
                                    </label>
                                    <label>' . _clang(AFTER) . '</label>
                                    <label for="ends1"><input onkeyup="schedule_summary(\'popup\');" onblur="schedule_summary(\'popup\');" type="text" placeholder="12" value="' . $schedule[0]['ends_after'] . '" name="ends_after" id="ends_after1" class="occuranes"></label>
                                    <label>' . _clang(OCCURRENCES) . '</label>
                                    </label>
                                    <br>
                                    <label style="width:185px;">';
    $ends_3 = ($schedule[0]['ends'] == 'on') ? "checked='checked'" : "";
    $data .='<label for="ends_on1"><input onclick="schedule_summary(\'popup\');" ' . $ends_3 . ' type="radio" id="on1" value="on" name="ends"></label>
									<label>' . _clang(ON) . ':</label>
									<span style="display:none;" id="ends_on_date">' . $schedule[0]['ends_on'] . '</span>
                                    <label for="on1"><input onchange="schedule_summary(\'popup\');" style="padding-left:3px;" id="ends_on1" type="text" value="' . $schedule[0]['ends_on'] . '" placeholder="2014-05-16"  name="ends_on" class="occuranes_12172014"></label>
                                    </label>
                                    <br>
                                </p>

                                 </div>
                            </section>
                            <section id="summary">
                            	<div class="summary_title">' . _clang(SUMMARY) . '</div>
                                <div class="summary_emailid" style="width: 449px; float: left; margin-bottom:7px;"><b id="schedule_summary_popup"><!--Weekly on Wednesday at 20:00 to username@dmail.com-->&nbsp;</b></div>
                                <div style="width:133px;" class="summary_cancel"><input class="btn btn_main"style="cursor:pointer;" type="submit" value="' . _clang(OK_BUTTON) . '"><a class="popup_close" style="color:#E46C0A;" href="javascript:void(0)">' . _clang(CANCEL_P_A) . '</a></div>

                            </section>
                            </form>
								</div>
							</div>
						</div>
					</div>
				</div><script></script>';
} else if ($cls == 'profile') {

    $data = '<div class="popup_ajax profile">
		<div class="freeusers_box signup_popup">
		<div class="popup_heading">' . _clang(EDIT_PROFILE) . '</div>
		  <div class="popup_cancle"><a style="opacity:1;" class="popup_close" href="#"><img height="32" width="32" src="' . base_url() . 'assets/img/popup-close.png" alt="Popup Close"></a></div>
		  <div class="signupfree" class=" popup_signupfree">
		  		<form style="margin-top:24px;" method="post" name="subscribe_1" id="subscribe_1" action="' . site_url('myknewdog/edit_profile') . '">';
    if ($number == 1) {
        $data .= '<div class="profile_control">
						<label>' . _clang(FIRSTNAME_PA) . ':</label>
						<div class="controls">
							<input name="firstname" type="text" value="' . $user[0]['firstname'] . '">
						</div>
					</div>

					<div class="profile_control">
						<label>' . _clang(LASTNAME_PA) . ':</label>
						<div class="controls">
							<input name="lastname" type="text" value="' . $user[0]['lastname'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(GENDER_P_A) . ':</label>
						<div class="controls">
							<select name="gender">
								<option ' . (($user[0]['gender'] == "Male") ? "selected='selected'" : "") . ' value="Male">' . _clang(MALE) . '</option>
								<option ' . (($user[0]['gender'] == "Female") ? "selected='selected'" : "") . ' value="Female">' . _clang(FEMALE) . '</option>
								<option ' . (($user[0]['gender'] == "Neutral") ? "selected='selected'" : "") . ' value="Neutral">' . _clang(NEUTRAL) . '</option>
							 </select>
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(COMPANY_PA) . ':</label>
						<div class="controls">
							<input name="company_name" type="text" value="' . $user[0]['company_name'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(TOWN_PA) . ':</label>
						<div class="controls">
							<input name="town" type="text" value="' . $user[0]['town'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(ZIPCODE_PA) . ':</label>
						<div class="controls">
							<input name="zip_code" type="text" value="' . $user[0]['zip_code'] . '">
						</div>
					</div>';
        $data .='<div class="profile_control">
						<label>' . _clang(COUNTRY_PA) . ':</label>
						<div class="controls">
						  <select name="country">';
        for ($l = 0; $l < count($countries); $l++) {
            $data .='<option ' . (($user[0]["country"] == $countries[$l]["id"]) ? "selected='selected'" : "") . ' value="' . $countries[$l]['id'] . '">' . $countries[$l]["country_name"] . '</option>';
        }
        $data .='</select>
						</div>
					</div>';
    } else if ($number == 2) {
        $data .= '<div class="profile_control">
						<label>' . _clang(PRIMARY_EMAIL) . ':</label>
						<div class="controls">
							<input name="primary_email" type="text" value="' . $user[0]['primary_email'] . '">
						</div>
					</div>';
    } else if ($number == 3) {

        $data .='<div class="profile_control">
						<label>' . _clang(LANGUAGES_PA) . ':</label>
						<div class="controls">
						  <select name="language_id">';
        $language_id = explode(",", $user[0]['language_id']);
        for ($l = 0; $l < count($language); $l++) {
            if (!in_array($language[$l]['language_id'], $language_id)) {
                $data .='<option value="' . $language[$l]['language_id'] . '">' . $language[$l]['language_longform'] . '</option>';
            }
        }
        $data .='</select>
						</div>
					</div>';
    } else if ($number == 4) {
        $data .='<div class="profile_control">
						<label>' . _clang(INTEREST_PA) . ':</label>
						<div class="controls">
						   <select name="user_interests">';
        $newsletter_keyword_ids = explode(",", $user[0]['user_interests']);
        for ($k = 0; $k < count($keyword); $k++) {
            if (!in_array($keyword[$k]['newsletter_keyword_id'], $newsletter_keyword_ids)) {
                $word = !empty($keyword[$k][$this->session->userdata('language_shortcode')]) ? $keyword[$k][$this->session->userdata('language_shortcode')] : $keyword[$k]['en'];
                $data .='<option value="' . $keyword[$k]['newsletter_keyword_id'] . '">' . $word . '</option>';
            }
        }
        $data .='</select>
						</div>
					</div>';
    } else if ($number == 5) {
        //$data .= "hii";
        //$data .= "number->". $number;
        $data .='<div class="profile_control">
						<label>Time zone:</label>
						<div class="controls">
						   <select name="time_zone">';
        for ($t = 0; $t < count($time_zone); $t++) {
            if ($time_zone[$t]['time_zone_id'] == $user[0]['time_zone']) {
                $selected = "selected='selected'";
            } else {
                $selected = '';
            }
            $curdatetime = get_timeby_timezone($time_zone[$t]['time_zone'], 'Y-m-d H:i:s');
            $data .='<option ' . $selected . ' value="' . $time_zone[$t]['time_zone_id'] . '">(UTC ' . $time_zone[$t]['time_zone_time'] . ") " . $time_zone[$t]['time_zone'] . "   ( DateTime: " . $curdatetime . ' ) </option>';
        }
        $data .='</select>
						</div>
					</div>';
    }
    $data .='<div class="profile_action">
					<input style="margin-top:5px; margin-bottom:5px;" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" type="submit" />
					</div>
				</form>
				</div>
		   </div>
	  </div>';
} else if ($cls == 'account_settings') {
    $data = '<div class="popup_ajax account_settings">
		<div class="freeusers_box signup_popup">
		<div class="popup_heading">' . _clang(EDIT_ACC) . '</div>
		  <div class="popup_cancle"><a style="opacity:1;" class="popup_close" href="#"><img height="32" width="32" src="' . base_url() . 'assets/img/popup-close.png" alt="Popup Close"></a></div>
		  <div class="signupfree" class=" popup_signupfree">
		  		<form style="margin-top:24px;" method="post" name="subscribe_1" id="subscribe_1" action="' . site_url('myknewdog/edit_account_settings') . '">';
    if ($number == 1) {
        $data .= '<div class="profile_control">
						<label>' . _clang(OLD_PASS) . ':</label>
						<div class="controls">
							<input name="old_password" type="password" value="">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(NEW_PASS) . ':</label>
						<div class="controls">
							<input name="password" type="password" value="">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(CONFORM_PASS) . ':</label>
						<div class="controls">
							<input name="password2" type="password" value="">
						</div>
					</div>';
    } else if ($number == 2) {
        $data .= '<div class="profile_control">
						<label>' . _clang(LANGUAGE_INTERFACE) . ':</label>
						<div class="controls">
							<select name="language_interface">';
        for ($l = 0; $l < count($site_language); $l++) {
            $selected = ($user[0]['language_interface'] == $site_language[$l]['site_language_id']) ? 'selected="selected"' : '';
            $data .='<option ' . $selected . ' value="' . $site_language[$l]['site_language_id'] . '">' . $site_language[$l]['language_longform'] . '</option>';
        }
        $data .='</select>
						</div>
					</div>';
    } else if ($number == 3) {
        $data .= '<div class="profile_control">
						<label>' . _clang(FIRSTNAME_PA) . ':</label>
						<div class="controls">
							<input name="i_firstname" type="text" value="' . $user[0]['i_firstname'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(COMPANY_PA) . ':</label>
						<div class="controls">
							<input name="i_company_name" type="text" value="' . $user[0]['i_company_name'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(TOWN_PA) . ':</label>
						<div class="controls">
							<input name="i_town" type="text" value="' . $user[0]['i_town'] . '">
						</div>
					</div>
					<div class="profile_control">
						<label>' . _clang(ZIPCODE_PA) . ':</label>
						<div class="controls">
							<input name="i_zip_code" type="text" value="' . $user[0]['i_zip_code'] . '">
						</div>
					</div>';
        $data .='<div class="profile_control">
						<label>' . _clang(COUNTRY_PA) . ':</label>
						<div class="controls">
						  <select name="i_country">';
        for ($l = 0; $l < count($countries); $l++) {
            $data .='<option ' . (($user[0]["i_country"] == $countries[$l]["id"]) ? "selected='selected'" : "") . ' value="' . $countries[$l]['id'] . '">' . $countries[$l]["country_name"] . '</option>';
        }
        $data .='</select>
						</div>
					</div>';
    } else if ($number == 4) {
        $data .= '<div class="profile_control">
						<p style="text-align:center; color:#E46C0A;">' . _clang(GO_TO_PA) . '</p>
							</div>';
    } else if ($number == 5) {
        $data .= '<div class="profile_control">

                                                    <label>' . _clang(USERNAME_PA) . ':</label>
						<div class="controls">
							<input name="username" type="text" value="' . $user[0]['username'] . '">
						</div>
					</div>';
    }
    if ($number != 4) {
        $data .='<div class="profile_action">
					<input style="margin-top:5px; margin-bottom:5px;" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" type="submit" />
					</div>';
    }
    $data .='</form>
				</div>
		   </div>
	  </div>';
} else if ($cls == 'archive_newsletter') {
    $data_frame = stripslashes($newsletter[0]['description']);
    echo $data_frame;
} else if ($cls == 'additional_email') {
    $data = '<div class="popup_ajax additional_email">
		<div class="freeusers_box signup_popup">
		<div class="popup_heading">' . _clang(EDIT_PROFILE) . '</div>
		  <div class="popup_cancle"><a style="opacity:1;" class="popup_close" href="#"><img height="32" width="32" src="' . base_url() . 'assets/img/popup-close.png" alt="Popup Close"></a></div>
		  <div class="signupfree" class=" popup_signupfree">
		  		<form style="margin-top:24px;" method="post" name="subscribe_1" id="subscribe_1" action="' . site_url('myknewdog/edit_additional_email') . '">
				<input type="hidden" id="additional_email_mode" name="mode" value="Add" />
				<input type="hidden" id="additional_email_id" name="additional_email_id" value="" />
				';

    if ($number == 1) {
        $data .= '<div class="profile_control">
						<label id="additional_label">' . _clang(ADD_EMAIL) . ':</label>
						<div class="controls">
							<input name="email" id="additional_email" type="text" value="">
						</div>
					</div>';
    }
    $data .='<div class="profile_action">
					<input style="margin-top:5px; margin-bottom:5px;" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" type="submit" />
					</div>';
    $data .='<div class="profile_control">
						<label style="height:55px;">' . _clang(EDIT_EMAIL) . ':</label>
						<div class="controls" style="padding-top:2px;">';
    for ($l = 0; $l < count($additional_email); $l++) {

        $data .= '<div style="line-height:20px">
            <a onclick="update_additional_email(this.id)" id="' . $additional_email[$l]['additional_email_id'] . '_' . $additional_email[$l]['email'] . '" style="color:#0070C0; float:left; width:170px;" href="javascript:void(0);">' . $additional_email[$l]["email"] . '</a>
                <span id="' . $additional_email[$l]['additional_email_id'] . '_' . $additional_email[$l]['email'] . '" style=" cursor:pointer; float:none; margin-left:11px;" onclick="update_additional_email(this.id)">
                    <img src="' . site_url('assets/img/edit.png') . '" alt="">
                        </span>
                        <span style="cursor:pointer; float:none; margin-left:11px;">
                        <a onclick=" popups_ajax_schedule_delete(\'delete_additional_mail\',' . $additional_email[$l]["additional_email_id"] . ')" style="color:#0070C0; float:none;" href="javascript:void(0);"><img src="' . site_url('assets/img/wrong.png') . '" alt=""></a>
                        </div>';
    }
    $data .='</div>
					</div>
				</form>
				</div>
		   </div>
	  </div>';
} else if ($cls == 'cancle_account') {
    if ($number == 'FREE') {
        $data .='<div class="popup_ajax cancle_account">
	<div class="freeusers_box advancedsearch_popup_box" style=" height: auto;overflow: hidden;">
        <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="' . base_url() . 'assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
        <div class="heading">' . _clang(HOLD_ON) . '</div>
        <p>' . _clang(YOU_ARE_PA) . '</p>
		<p style="color:#E46C0A;">' . _clang(PLEASE_ANSWER) . '</p>
		<form style="margin-top:7px;" method="post" name="subscribe_1" id="cancle_account" action="' . site_url('myknewdog/cancle_account') . '">
		<div class="profile_control">
						<p style="margin-left:63px;">
                                    <label style="width:185px;">
								    <input  type="radio" id="" value="I did not find the newsletters I was searching for." name="ans">
                                    <label>' . _clang(I_DIDNT) . '</label>
                                    </label>
                                    <br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="I do not need newsletters anymore." name="ans">
                                    <label>' . _clang(I_DIDNT_NEED) . '</label>
                                    </label>
									<br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="It is not all it is cracked up to be." name="ans">
                                    <label>' . _clang(ITS_NOT_ALL_IT) . '</label>
                                    </label>
									<br>
								    <label style="width:185px;">
                                    <label for="ends_after1">
								  	<input type="radio" id="" value="tell_us" name="ans" id="ends1">
                                    </label>
                                    <label>' . _clang(TELL_US_EVERYTHING) . ' </label>
                                    <label for="ends1"><input  type="text" placeholder="' . _clang(TELL_US_EVERYTHING) . '" style="width:182px !important;" name="tell_us" id="" class="occuranes"></label>
                                    </label>

                                </p>
						</div>

        <div class="cancle_popup_btn"><input type="submit" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" /><span style="float:none; margin-left:20px;"><a class="popup_close" href="javascript:void(0);">' . _clang(I_DONT) . '</a></span></div>
		<form>
     </div>
  </div>';
    } else if ($number == 'PRE1') {

        $data .='<div class="popup_ajax cancle_account">
	<div  class="freeusers_box advancedsearch_popup_box" style=" height: auto;overflow: hidden;">
        <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="' . base_url() . 'assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
        <div class="heading">' . _clang(HOLD_ON) . '</div>
        <p>' . _clang(YOU_CANCELING) . '</p>

		<p style="color:#E46C0A;">' . _clang(PLEASE_ANSWER) . '</p>
		<form style="margin-top:7px;" method="post" name="subscribe_1" id="cancle_account" action="' . site_url('myknewdog/cancle_account') . '">
		<div class="profile_control">
						<p style="margin-left:63px;">
                                    <label style="width:185px;">
								    <input  type="radio" id="" value="I didn’t find the newsletters I was searching for." name="ans">
                                    <label>' . _clang(I_DIDNT) . '</label>
                                    </label>
                                    <br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="I don’t need newsletters anymore." name="ans">
                                    <label>' . _clang(I_DIDNT_NEED) . '</label>
                                    </label>
									<br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="It’s not all it’s cracked up to be." name="ans">
                                    <label>' . _clang(ITS_NOT_ALL_IT) . '</label>
                                    </label>
									<br>
								    <label style="width:185px;">
                                    <label for="ends_after1">
								  	<input type="radio" id="" value="tell_us" name="ans" id="ends1">
                                    </label>
                                    <label>' . _clang(TELL_US_EVERYTHING) . '</label>
                                    <label for="ends1"><input  type="text" placeholder="' . _clang(TELL_US_EVERYTHING) . '" style="width:182px !important;" name="tell_us" id="" class="occuranes"></label>
                                    </label>

                                </p>
						</div>

        <div class="cancle_popup_btn"><input type="submit" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" /><span style="float:none; margin-left:20px;"><a class="popup_close" href="javascript:void(0);">' . _clang(I_DONT) . '</a></span></div>
		<form>
     </div>
  </div>';
    } else if ($number == 'PRE2') {

        $data .='<div class="popup_ajax cancle_account">
	<div  class="freeusers_box advancedsearch_popup_box" style=" height: auto;overflow: hidden;">
        <div class="gopremium_cancell_btn"><a class="popup_close" href="javascript:void(0);"><img src="' . base_url() . 'assets/img/gopremiumcancell.png" height="17" width="18" alt="gopremiumcancell"></a></div>
        <div class="heading">' . _clang(HOLD_ON) . '</div>
        <p>' . _clang(XXL_PLAN) . '</p>
        <p style="color:#E46C0A;">' . _clang(PLEASE_ANSWER) . '</p>
		<form style="margin-top:7px;" method="post" name="subscribe_1" id="cancle_account" action="' . site_url('myknewdog/cancle_account') . '">
		<div class="profile_control">
						<p style="margin-left:63px;">
                                    <label style="width:185px;">
								    <input  type="radio" id="" value="I didn’t find the newsletters I was searching for." name="ans">
                                    <label>' . _clang(I_DIDNT) . '</label>
                                    </label>
                                    <br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="I don’t need newsletters anymore." name="ans">
                                    <label>' . _clang(I_DIDNT_NEED) . '</label>
                                    </label>
									<br>
									<label style="width:185px;">
								    <input  type="radio" id="" value="It’s not all it’s cracked up to be." name="ans">
                                    <label>' . _clang(ITS_NOT_ALL_IT) . '</label>
                                    </label>
									<br>
								    <label style="width:185px;">
                                    <label for="ends_after1">
								  	<input type="radio" value="tell_us" name="ans" id="ends1">
                                    </label>
                                    <label>' . _clang(TELL_US_EVERYTHING) . ' </label>
                                    <label><input onclick="javascript:document.getElementById("ends1").checked;"  type="text" placeholder="' . _clang(TELL_US_EVERYTHING) . '" style="width:182px !important;" name="tell_us" id="" class="occuranes"></label>
                                    </label>

                                </p>
						</div>

        <div class="cancle_popup_btn"><input type="submit" class="btn btn_main" value="' . _clang(SUBMIT_BUTTON) . '" name="submit" /><span style="float:none; margin-left:20px;"><a class="popup_close" href="javascript:void(0);">' . _clang(I_DONT) . '</a></span></div>
		<form>
     </div>
  </div>';
    }
}
//$data_frame = urlencode($data_frame);
//echo "<iframe srcdoc='".$data_frame."' src='data:text/html;charset=utf-8,%3Chtml%3E%3Cbody%3E %3C/body%3E%3C/html%3E' />";
echo $data;
?>
<!--<script>
    function schedule_summary(loc) {

        if (loc == 'site') {
            //alert('run');
            var sending = $('input[name=sending]:checked', '#schedule_form').val();
            var monthly_on_checked = $('.site input[name="monthly_on"]:checked').val();//$('input[name=monthly_on]:checked', '#schedule_form').val();
            //alert(monthly_on_checked);
            var day_of_month;
            if (monthly_on_checked == 'day_of_the_month') {
                day_of_month = $('select[name=day_of_the_month]', '#schedule_form').val();
            } else {
                monthly = $('select[name=monthly_weekday_day]', '#schedule_form').val();
                monthly_count = $('select[name=monthly_weekday_count]', '#schedule_form').val();
            }
            //alert(day_of_month);
            var monthly;
            var monthly_count;
            (sending != null) ? $("#schedule_form .head_lable").css("display", "block") : "";
            /*$("#schedule_form .every_fields").css("display","none");
             $("#schedule_form .every_fields").attr("disabled",true);
             $("#schedule_form #every_field_"+sending).css("display","block");
             $("#schedule_form #every_field_"+sending+" select").attr("disabled",false);*/
            var current_id = $('select[name=every]', '#schedule_form').attr("id");
            if (($('#schedule_form #every_field').is(":empty")) || current_id != 'current_' + sending) {
                if (sending == 'Daily') {
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Daily" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="last_day">Last Day</option></select>' + days);

                } else
                if (sending == 'Weekly') {
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Weekly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>' + weeks);
                } else if (sending == 'Monthly') {
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Monthly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>' + months);
                    //New logic

                    $("#schedule_form .everyweekson").append('');
                    $("#schedule_form .weeks_on").css("display", "none");
                    $("#schedule_form .weeks_on_2").css("display", "block");

//                        var monthly = "";
//                        if (monthly_on_checked =='day_of_the_month') {
//                            alert("in");
//                            monthly = $('select[name=day_of_the_month]', '#schedule_form').val();
//                        } else {
//                            alert("else in");
//                            monthly = $('select[name=monthly_weekday_day]', '#schedule_form').val();
//                        }
                    //console.log(monthly);
                }

                /*if(monthly_on_checked == 'day_of_the_month'){

                 $("#day_of_the_month").html('')
                 $("#weekday").html('');
                 }else{
                 $("#day_of_the_month").html('')
                 $("#weekday").html('');

                 }*/
            }

            var every = $('select[name=every]', '#schedule_form').val();

//                console.log(monthly);

            var weeks_on = $.map($(':checkbox[name=weeks_on\[\]]:checked'), function(n, i) {
                return n.value;
            }).join(', ');
            var at = $('select[name=at]', '#schedule_form').val();
            var sending_to_email = $('select[name=sending_to_email]', '#schedule_form').val();
            var ends = $('input[name=ends]:checked', '#schedule_form').val();
            if (ends == 'after') {
                $('#ends_after', '#schedule_form').val();
            }
            var ends_occur = $('#ends_after', '#schedule_form').val();
            var ends_on = $('#ends_on', '#schedule_form').val();

        } else if (loc == "popup") {

            var sending = $('input[name=sending]:checked', '#schedule_form_popup').val();
            //new data
            /*(sending != null) ? $("#schedule_form .head_lable").css("display","block") : "";
             $("#schedule_form .every_fields").css("display","none");
             $("#schedule_form .every_fields").attr("disabled",true);
             $("#schedule_form #every_field_"+sending).css("display","block");
             $("#schedule_form #every_field_"+sending+" select").attr("disabled",false);*/
            (sending != null) ? $("#schedule_form_popup .head_lable").css("display", "block") : "";
            /*$("#schedule_form .every_fields").css("display","none");
             $("#schedule_form .every_fields").attr("disabled",true);
             $("#schedule_form #every_field_"+sending).css("display","block");
             $("#schedule_form #every_field_"+sending+" select").attr("disabled",false);*/
            var current_id = $('select[name=every]', '#schedule_form_popup').attr("id");
            if (($('#schedule_form_popup #every_field').is(":empty")) || current_id != 'current_' + sending) {
                if (sending == 'Daily') {

                    $("#schedule_form_popup .weeks_on").css("display", "block");
                    $("#schedule_form_popup .weeks_on_2").css("display", "none");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Daily" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="last_day">Last Day</option></select>' + days);

                } else
                if (sending == 'Weekly') {
                    //alert("got in");

                    $("#schedule_form_popup .weeks_on").css("display", "block");
                    $("#schedule_form_popup .weeks_on_2").css("display", "none");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Weekly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>' + weeks);


                } else if (sending == 'Monthly') {

                    $("#schedule_form_popup .weeks_on").css("display", "none");
                    $("#schedule_form_popup .weeks_on_2").css("display", "block");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Monthly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>' + months);

                }

            }
            //new data end
            var every = $('select[name=every]', '#schedule_form_popup').val();
            var weeks_on = $.map($(':checkbox[name=weeks_on\[\]]:checked'), function(n, i) {
                return n.value;
            }).join(', ');
            var at = $('select[name=at]', '#schedule_form_popup').val();
            var sending_to_email = $('select[name=sending_to_email]', '#schedule_form_popup').val();
            var ends = $('input[name=ends]:checked', '#schedule_form_popup').val();
            if (ends == 'after') {
                $('#ends_after', '#schedule_form_popup').val(1);
            }
            var ends_occur = $('#ends_after1', '#schedule_form_popup').val();
            var ends_on = $('#ends_on1', '#schedule_form_popup').val();

        }


        var sending_d = sending;
        if (sending == 'Daily') {

            var senddata = "day(s)";

        } else if (sending == "Weekly") {
            var senddata = "week(s)";
        } else if (sending == "Monthly") {
            var senddata = "month(s)";
        }
        //if(every){
        if (every == 'last_day') {
            var every_temp = "last month";
        } else {
            var every_temp = every;
        }
        var every_d = " every " + every_temp + " " + senddata + " ";
        //}else{
        //	var every_d = "";
        //}

        if (weeks_on) {
            var ON = '<?php echo summary_lang('on') ?>';
            //alert(weeks_on);
            var weeks_on_d = "On " + weeks_on;
        } else {
            var weeks_on_d = "";
        }
        //alert(weeks_on_d);
        var hour = at;

        var reserv = new Date('', '', '', hour, '')

        var at_d = " at " + reserv.format('H:i');
        var sending_to_email_d = " to " + sending_to_email;
        if (ends == "Never") {
            var ends_in = " ending " + ends;
        } else if (ends == "after") {

            var ends_in = " ending " + ends + " " + ends_occur + " occurrences";
        } else if (ends == "on") {
            var ends_in = " ending " + ends + " " + ends_on;
        }

        setTranslateKeyword(sending_d, every_d, weeks_on_d, day_of_month, monthly_count, monthly, at_d, sending_to_email_d, ends_in, on, loc);

        if (loc == 'site') {
            $("#schedule_summary").html(sending_d + every_d + weeks_on_d + day_of_month + monthly_count + monthly + at_d + sending_to_email_d + ends_in);
        } else if (loc == 'popup') {
            $("#schedule_summary_popup").html(sending_d + every_d + weeks_on_d + day_of_month + monthly_count + monthly + at_d + sending_to_email_d + ends_in);
        }

    }
</script>-->
<!--<script>
    function schedule_summary(loc) {

        if (loc == 'site') {
            //alert('run');
            var monthly;
            var monthly_count;
            var monthly_on_checked;
            var day_of_month;
            var sending = $('input[name=sending]:checked', '#schedule_form').val();
            //alert(sending);
//                if (sending=="Weekly") {
//                    //alert("hiiii");
//                     //monthly_on_checked = $('.site input[name="weeks_on"]:checked').val();
//                    //alert(monthly_on_checked);
//                }
            if (sending == "Monthly") {
                //alert("hiiii");
                //('#weekday').attr('checked', 'checked');
                // $("#weekday").prop("checked", true)
                var ON = '<?php echo summary_lang('on') ?>';
                var on = ON;
                monthly_on_checked = $('.site input[name="monthly_on"]:checked').val();
                //alert(monthly_on_checked);
                if (monthly_on_checked == 'weekday') {
                    monthly = $('select[name=monthly_weekday_day]', '#schedule_form').val();
                    monthly_count = $('select[name=monthly_weekday_count]', '#schedule_form').val();
                } else if (monthly_on_checked == 'day_of_the_month') {
                    day_of_month = $('select[name=day_of_the_month]', '#schedule_form').val();
                }
            }
            //alert(day_of_month);

            (sending != null) ? $("#schedule_form .head_lable").css("display", "block") : "";
            var current_id = $('select[name=every]', '#schedule_form').attr("id");
            if (($('#schedule_form #every_field').is(":empty")) || current_id != 'current_' + sending) {
                if (sending == 'Daily') {
                    //alert(sending);
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Daily" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="last_day">Last Day</option></select>' + days);

                } else
                if (sending == 'Weekly') {
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Weekly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>' + weeks);
                } else if (sending == 'Monthly') {
                    $("#schedule_form .weeks_on").css("display", "block");
                    $("#schedule_form .weeks_on_2").css("display", "none");
                    $("#schedule_form #every_field").html('<select onchange="schedule_summary(\'site\');" style="width:90px;" id="current_Monthly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>' + months);
                    //New logic

                    $("#schedule_form .everyweekson").append('');
                    $("#schedule_form .weeks_on").css("display", "none");
                    $("#schedule_form .weeks_on_2").css("display", "block");
                }
            }

            var every = $('select[name=every]', '#schedule_form').val();
            var weeks_on = $.map($(':checkbox[name=weeks_on\[\]]:checked'), function(n, i) {
                return n.value;
            }).join(', ');
            //alert(weeks_on);
            var at = $('select[name=at]', '#schedule_form').val();
            var sending_to_email = $('select[name=sending_to_email]', '#schedule_form').val();
            var ends = $('input[name=ends]:checked', '#schedule_form').val();
            if (ends == 'after') {
                $('#ends_after', '#schedule_form').val();
            }
            var ends_occur = $('#ends_after', '#schedule_form').val();
            var ends_on = $('#ends_on', '#schedule_form').val();

        } else if (loc == "popup") {

            var sending = $('input[name=sending]:checked', '#schedule_form_popup').val();
            (sending != null) ? $("#schedule_form_popup .head_lable").css("display", "block") : "";
            var current_id = $('select[name=every]', '#schedule_form_popup').attr("id");

            if (sending == "Monthly") {
                //alert("hiiii");
                //('#weekday').attr('checked', 'checked');
                // $("#weekday").prop("checked", true)
                var ON = '<?php echo summary_lang('on') ?>';
                var on = ON;
                monthly_on_checked = $('.site input[name="monthly_on"]:checked').val();
                //alert(monthly_on_checked);
                if (monthly_on_checked == 'weekday') {
                    monthly = $('select[name=monthly_weekday_day]', '#schedule_form').val();
                    monthly_count = $('select[name=monthly_weekday_count]', '#schedule_form').val();
                } else if (monthly_on_checked == 'day_of_the_month') {
                    day_of_month = $('select[name=day_of_the_month]', '#schedule_form').val();
                }
            }
            if (($('#schedule_form_popup #every_field').is(":empty")) || current_id != 'current_' + sending) {
                if (sending == 'Daily') {

                    $("#schedule_form_popup .weeks_on").css("display", "block");
                    $("#schedule_form_popup .weeks_on_2").css("display", "none");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Daily" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="last_day">Last Day</option></select>' + days);

                } else
                if (sending == 'Weekly') {
                    //alert("got in");

                    $("#schedule_form_popup .weeks_on").css("display", "block");
                    $("#schedule_form_popup .weeks_on_2").css("display", "none");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Weekly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>' + weeks);


                } else if (sending == 'Monthly') {

                    $("#schedule_form_popup .weeks_on").css("display", "none");
                    $("#schedule_form_popup .weeks_on_2").css("display", "block");

                    $("#schedule_form_popup #every_field").html('<select onchange="schedule_summary(\'popup\');" style="width:90px;" id="current_Monthly" name="every" title=""><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>' + months);


//                        var ON = '<?php //echo summary_lang('on')                           ?>';
//                        var on = ON;
//                        monthly_on_checked = $('.site input[name="monthly_on"]:checked').val();
//                        alert(monthly_on_checked);
//                        if (monthly_on_checked == 'weekday') {
//                            monthly = $('select[name=monthly_weekday_day]', '#schedule_form').val();
//                            monthly_count = $('select[name=monthly_weekday_count]', '#schedule_form').val();
//                        } else if (monthly_on_checked == 'day_of_the_month') {
//                            day_of_month = $('select[name=day_of_the_month]', '#schedule_form').val();
//                        }

                }

            }
            //new data end
            var every = $('select[name=every]', '#schedule_form_popup').val();
            var weeks_on = $.map($(':checkbox[name=weeks_on\[\]]:checked'), function(n, i) {
                return n.value;
            }).join(', ');
            var at = $('select[name=at]', '#schedule_form_popup').val();
            var sending_to_email = $('select[name=sending_to_email]', '#schedule_form_popup').val();
            var ends = $('input[name=ends]:checked', '#schedule_form_popup').val();
            if (ends == 'after') {
                $('#ends_after', '#schedule_form_popup').val(1);
            }
            var ends_occur = $('#ends_after1', '#schedule_form_popup').val();
            var ends_on = $('#ends_on1', '#schedule_form_popup').val();

        }


        var sending_d = sending;
        if (sending == 'Daily') {
            var senddata = "day(s)";

        } else if (sending == "Weekly") {
            var senddata = "week(s)";
        } else if (sending == "Monthly") {
            var senddata = "month(s)";
        }
        //if(every){
        if (every == 'last_day') {
            var every_temp = "last month";
        } else {
            var every_temp = every;
        }
        var every_d = " every " + every_temp + " " + senddata + " ";
        //}else{
        //	var every_d = "";
        //}

        if (weeks_on) {

            //alert(weeks_on);
            var weeks_on_d = weeks_on;
            var ON = '<?php echo summary_lang('on') ?>';
            var on = ON;
        } else {
            var weeks_on_d = "";
            //var on = "";
            var ON = '<?php echo summary_lang('on') ?>';
            var on = ON;
        }
        //alert(weeks_on_d);
        //alert(weeks_on_d);
        var hour = at;

        var reserv = new Date('', '', '', hour, '')

        var at_d = " at " + reserv.format('H:i');
        var sending_to_email_d = " to " + sending_to_email;
        if (ends == "Never") {
            var ends_in = " ending " + ends;
        } else if (ends == "after") {

            var ends_in = " ending " + ends + " " + ends_occur + " occurrences";
        } else if (ends == "on") {
            var ends_in = " ending " + ends + " " + ends_on;
        }
        //alert(on);
        setTranslateKeyword(sending_d, every_d, weeks_on_d, day_of_month, monthly_count, monthly, at_d, sending_to_email_d, ends_in, on, loc);

//            if (loc == 'site') {
//                $("#schedule_summary").html(sending_d + every_d + weeks_on_d + day_of_month + monthly_count + monthly + at_d + sending_to_email_d + ends_in);
//            } else if (loc == 'popup') {
//                $("#schedule_summary_popup").html(sending_d + every_d + weeks_on_d + day_of_month + monthly_count + monthly + at_d + sending_to_email_d + ends_in);
//            }

    }
</script>-->